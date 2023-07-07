<?php
require_once 'DatabaseController.php';
require_once '../../../Configuration.php';

class TemporaryAccessToken implements Token {
    private string $token = '';
    private DatabaseController $db;
    private DateTime $expireTime;

    public function __construct(?int $personId){
        if ($personId === null)
            Logger::report(LogLevel::Error, 'An attempt to create Temporary Access Token without owner has been detected.');
        $this->db = new DatabaseController();
        $this->generateRandomToken();
        $this->setExpireTime();
        $this->storeTokenInDatabase($personId);
    }
    
    public function getToken(): string {
        return $this->token;
    }

    private function storeTokenInDatabase(int $personId): bool {
        
        $table = Configuration::DATABASE_TABLE_TEMPORARY_ACCESS_TOKENS;
        $sql = "INSERT INTO $table (person_id, token, expire_time) VALUES ($personId, '{$this->token}', {$this->expireTime->getTimestamp()});";
        return $this->db->sendQuery($sql);
    }

    private function setExpireTime(): void {
        $seconds = time() + Configuration::API_TEMPORARY_TOKEN_EXPIRE_TIME_IN_SECONDS;
        $this->expireTime = new DateTime('@' . (string) (time() + $seconds) );
    }

    private function generateRandomToken(): void {
        $this->token = openssl_random_pseudo_bytes(Configuration::TEMPORARY_ACCESS_TOKEN_LENGTH/2); // 1 hex digit => 2 bytes
        $this->token = bin2hex($this->token); 
    }
}