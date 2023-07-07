<?php
require_once 'Role.php';
require_once 'DatabaseController.php';
require_once '../../../Configuration.php';

class Person {
    public function __construct(
        public int $id,
        public string $firstName,
        public string $lastName,
        public ?Role $role = null,
        public string $hashedPersonalAccessToken,
        public DateTime $lastTimeActive
    ) {}

    public static function getPersonById(int $personId): ?Person {
        $table = Configuration::DATABASE_TABLE_PEOPLE;
        $sql = "SELECT id, first_name, last_name, serialized_role, hashed_personal_access_token, last_active_time 
                FROM $table id = $personId";
        
        $db = new DatabaseController();
        $rows = $db->getArrayOfRecords($sql);

        if ($rows === [])
            return null;
        else {
            $row = $rows[0];
            return new Person(
                $row['id'],
                $row['first_name'],
                $row['last_name'],
                unserialize($row['serialized_role']),
                $row['hashed_personal_access_token'],
                new DateTime('@'. (string) $row['last_active_time'])
            );    
        }
    }
}