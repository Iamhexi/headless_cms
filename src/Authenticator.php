<?php
require_once 'PersonalAccessToken.php';
require_once 'TemporaryAccessToken.php';
require_once 'DatabaseController.php';
require_once '../../../Configuration.php';


class Authenticator {

    public static function generateTemporaryAccessToken(PersonalAccessToken $token): ?TemporaryAccessToken {
        if (!$token->hasOwner())
            return null;
        return new TemporaryAccessToken($token->getOwner()->id ?? -1);
    }

    // Checks if the given token exists in the database. Returns the identity of the owner if so. Otherwise, returns false.
    public static function authenticate(TemporaryAccessToken|string|null $token): Person|false {
        if ($token === null) {
            Logger::report(LogLevel::Info, "An attempt to authenticate without any token has been detected!");
            return false;
        }

        $person = self::getPersonAssocicatedWithTemporaryTokenFromDatabase($token);
        if ($person === null)
            return false;

        self::updateLastActiveTime($person);
        return $person;
    }

    private static function getPersonAssocicatedWithTemporaryTokenFromDatabase(TemporaryAccessToken|string $token): ?Person {
        $peopleTable = Configuration::DATABASE_TABLE_PEOPLE;
        $tempTokenTable = Configuration::DATABASE_TABLE_TEMPORARY_ACCESS_TOKENS;

        if ($token instanceof TemporaryAccessToken)
            $token = $token->getToken();

        $sql = "SELECT p.id, p.first_name, p.last_name, p.serialized_role, t.expire_time, p.hashed_personal_access_token, last_active_time  
                FROM $peopleTable p INNER JOIN $tempTokenTable t ON t.person_id = p.id
                WHERE t.token = '$token' AND t.expire_time > UNIX_TIMESTAMP(now());
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
            /*unserialize($row['serialized_role']),*/ null, // TODO: Handle a serialized role object.
            $row['hashed_personal_access_token'],
            new DateTime('@'. (string) $row['last_active_time'])
        );
        
        return $person;
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