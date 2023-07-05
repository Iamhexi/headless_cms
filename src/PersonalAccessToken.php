<?php
require_once 'Token.php';
require_once 'DatabaseController.php';
require_once '../../Configuration.php';

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

    public function __construct(string $token) {
        $this->db = new DatabaseController();
        $this->token = $token;
        $this->owner = $this->getPersonByToken();
    }

    private function getPersonByToken(): ?Person {
        $hashedToken = password_hash($this->token, PASSWORD_DEFAULT);
        $table = Configuration::DATABASE_TABLE_PEOPLE;

        $sql = "SELECT id, first_name, last_name, serialized_role, hashed_personal_access_token FROM $table where hashed_personal_access_token = '$hashedToken';";
        $row = $this->db->getArrayOfRecords($sql);

        if ($row === [])
            return null;
            
        return new Person(
            $row['id'],
            $row['first_name'],
            $row['last_name'],
            unserialize('serialized_role'),
            $hashedToken,
            time()
        );
    }
}