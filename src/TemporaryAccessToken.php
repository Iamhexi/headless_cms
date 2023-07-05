<?php
require_once 'DatabaseController.php';
require_once '../../Configuration.php';

class TemporaryAccessToken implements Token {
    private string $token = '';
    private DatabaseController $db;

    public function __construct(int $personId){
        $this->db = new DatabaseController();
        $this->generateRandomToken();
        $this->storeTokenInDatabase($personId);
    }
    
    public function getToken(): string {
        return $this->token;
    }

    private function storeTokenInDatabase(int $personId): bool {
        $expireTime = time() + Configuration::API_TEMPORARY_TOKEN_EXPIRE_TIME_IN_SECONDS;

        $table = Configuration::DATABASE_TABLE_TEMPORARY_ACCESS_TOKENS;
        $sql = "INSERT INTO $table (person_id, hashed_token, expire_time) VALUES ($personId, '{$this->token}', $expireTime);";
        return $this->db->sendQuery($sql);
    }

    private function generateRandomToken(): void {
        $this->token = openssl_random_pseudo_bytes(64);
        $this->token = bin2hex($this->token);
    }
}