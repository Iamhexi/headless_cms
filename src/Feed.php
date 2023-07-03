<?php
require 'DatabaseController.php';
require 'Article.php';
require 'Configuration.php';

class Feed {
    private DatabaseController $db;
    private array $articles = [];

    public function __construct() {
        $this->loadArticles();
    }

    private function loadArticles(): void {
        $table = Configuration::DATABASE_TABLE_ARTICLES;
        $sql = "SELECT serialized_object FROM $table;";
        $rows = $this->db->getArrayOfRecords($sql);
        foreach($rows as $row)
            $this->articles[$row['id']] = unserialize($row['serialized_object']);
    }

    public function getArticles(
        int $howMany = Configuration::DEFAULT_NUMBER_OF_ARTICLES_TO_RETRIEVE_FROM_FEED): array /* of Article objects */
    {
        return array_slice($this->articles, -1, $howMany);
    }

    public function removeArticle(int $id): bool {
        $table = Configuration::DATABASE_TABLE_ARTICLES;
        $sql = "DELETE FROM $table where id = $id;";
        if ($this->db->sendQuery($sql)) {
            unset($this->articles[$id]);
            return true;
        } else {
            Logger::report(LogLevel::Error , 'The feed could remove an article to the database.');
            return false;
        }
    }

    public function addArticle(Article $article): bool {
        $table = Configuration::DATABASE_TABLE_ARTICLES;
        $serializedObject = serialize($article);
        $sql = "INSERT INTO $table (id, serialized_object) VALUES (NULL, $serializedObject);"; // auto increment id
        if ($this->db->sendQuery($sql)) {
            $this->articles[] = $article; // this new article doesn't have id, after retrieving it from the database it will be assigned
            return true;
        } {
            Logger::report(LogLevel::Error , 'The feed could add a new article to the database.');
            return false;
        }
    }

}