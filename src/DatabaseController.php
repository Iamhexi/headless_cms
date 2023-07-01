<?php
require 'Logger.php';
require 'InvalidSQLQuery.php';
require '../Configuration.php';


class DatabaseController
{
    private ?mysqli $connection = null;

    public function __construct(?mysqli $connection = null)
    {
        if ($connection !== null)
            $this->connection = $connection;
        else
            $this->connection = new mysqli(
                Configuration::DATABASE_SERVER,
                Configuration::DATABASE_USER,
                Configuration::DATABASE_PASSWORD,
                Configuration::DATABASE_NAME,
            );

        $this->connection->set_charset('utf8');
    }

    public function sendQuery(?string $query): bool
    {
        try {
            if ( !$this->connection->query($query) )
                throw new InvalidSQLQuery("DatabaseController could NOT perform the query = \"$query\" on the database.");
            return true;
        } catch (Exception $e){
            Logger::report(LogLevel::Error, $e->getMessage());
            return false;
        }
    }

    public function countMatchingRecords(string $query): int
    {
        try {
            if ( !($result = $this->connection->query($query)) )
                throw new InvalidSQLQuery("DatabaseController could NOT perform the query = \"$query\" on the database.");
            return $result->num_rows;
        } catch(InvalidSQLQuery $e) {
            Logger::report(LogLevel::Error, $e->getMessage());
            return -1;
        } catch (Exception $e) {
            Logger::report(LogLevel::CriticalError, $e->getMessage());
            return -1;
        }
    }

    public function getArrayOfRecords(string $query): array
    {
        try {

            if ( !($result = $this->connection->query($query)) )
                throw new InvalidSQLQuery("DatabaseController could NOT perform the query = \"$query\" on the database.");

            return $result->fetch_all(MYSQLI_ASSOC);

        } catch (InvalidSQLQuery $e){
            Logger::report(LogLevel::Error, $e->getMessage());
            return [];
        } catch (Exception $e){
            Logger::report(LogLevel::CriticalError, $e->getMessage());
            return [];
        }
    }

}