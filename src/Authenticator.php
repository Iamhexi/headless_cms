<?php
require_once 'PersonalAccessToken.php';
require_once 'TemporaryAccessToken.php';
require_once 'DatabaseController.php';
require_once '../../../Configuration.php';


class Authenticator {

    public static function generateTemporaryAccessToken(PersonalAccessToken $token): TemporaryAccessToken {
        return new TemporaryAccessToken($token->getOwner()->id ?? -1);
    }

    // Checks if the given token exists in the database. Returns the identity of the owner if so. Otherwise, returns false.
    public static function authenticate(TemporaryAccessToken $token): Person|false {
        if (!$token->isValid())
            return false;

        $person = self::getPersonAssocicatedWithTemporaryTokenFromDatabase($token);
        if ($person === null)
            return false;

        self::updateLastActiveTime($person);
        return $person;
    }

    private static function getPersonAssocicatedWithTemporaryTokenFromDatabase(TemporaryAccessToken $token): ?Person {
        $peopleTable = Configuration::DATABASE_TABLE_PEOPLE;
        $tempTokenTable = Configuration::DATABASE_TABLE_TEMPORARY_ACCESS_TOKENS;
        $sql = "SELECT p.id, p.first_name, p.last_name, p.serialized_role, t.expire_time, p.hashed_personal_access_token,  
                FROM $peopleTable p INNER JOIN $tempTokenTable t ON t.person_id = p.id;
                WHERE t.token = '{$token->getToken()}'
                ";
        
        $db = new DatabaseController();
        $rows = $db->getArrayOfRecords($sql);

        if ($rows === [])
            return null;

        $row = $rows[0];

        $person = new Person(
            $row['id'],
            $row['first_name'],
            $row['last_name'],
            unserialize($row['serialized_role']),
            $row['hashed_personal_access_token'],
            new DateTime('@'. (string) $row['last_active_time'])
        );
    }

    private static function updateLastActiveTime(Person $person): void {
        $table = Configuration::DATABASE_TABLE_PEOPLE;
        $now = time();
        $sql = "UPDATE $table SET last_active_time = $now WHERE id = {$person->id};";
        
        $db = new DatabaseController();
        if (!$db->sendQuery($sql))
            Logger::report(LogLevel::Warning, 'Person could not update its \'lastActiveTime\' in the database.');
    }

}