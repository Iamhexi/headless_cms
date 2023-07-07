<?php
require_once 'Token.php';
require_once 'DatabaseController.php';
require_once '../../../Configuration.php';

class PersonalAccessToken implements Token {
    private DatabaseController $db;
    private string $token = '';
    private ?Person $owner = null;

    public function getToken(): string {
        return $this->token;
    }

    public function getOwner(): ?Person {
        return $this->owner;
    }

    public function isValid(): bool {
        return $this->owner !== null;
    }

    public function __construct(string $token = '') {
        $this->db = new DatabaseController();
        $this->token = $token;
        $this->owner = $this->getPersonByToken();
    }

    private function getPersonByToken(): ?Person {
        $table = Configuration::DATABASE_TABLE_PEOPLE;

        $sql = "SELECT id, first_name, last_name, serialized_role, hashed_personal_access_token, last_active_time FROM $table;";
        $rows = $this->db->getArrayOfRecords($sql);

        foreach($rows as $row)
            if (password_verify($this->token, $row['hashed_personal_access_token']))
                return new Person(
                    $row['id'],
                    $row['first_name'],
                    $row['last_name'],
                    /* unserialize($row['serialized_role']), */ null, // TODO: handle serialized role object
                    $row['hashed_personal_access_token'],
                    new DateTime('@'. (string) $row['last_active_time'])
                );
        
        return null;
            
    }
}