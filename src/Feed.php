<?php
require_once 'DatabaseController.php';
require_once 'Article.php';
require_once '../../Configuration.php';

class Feed {
    private DatabaseController $db;
    private array $articles = [];

    public function __construct() {
        $this->db = new DatabaseController();
        $this->loadArticles();
    }

    private function loadArticles(): void {
        $table = Configuration::DATABASE_TABLE_ARTICLES;
        $sql = "SELECT id, serialized_object FROM $table;";
        $rows = $this->db->getArrayOfRecords($sql);
        
        foreach($rows as $row) {
            
            $article = unserialize($row['serialized_object']);
            $id = $row['id'];
            
            if ($article->id === null) {
                $article->id = $id;
                $this->setIdForSerializedArticle($row['id'], $article);
            }
            $this->articles[$id] = $article;
        }
    }

    private function setIdForSerializedArticle(int $id, Article $article) {
        $serializedObject = serialize($article);

        $table = Configuration::DATABASE_TABLE_ARTICLES;
        $sql = "UPDATE $table SET serialized_object = '$serializedObject' where id = $id;";
        $this->db->sendQuery($sql);
    }

    public function getArticles(
        int $howMany = Configuration::DEFAULT_NUMBER_OF_ARTICLES_TO_RETRIEVE_FROM_FEED): array /* of Article objects */
    {
        return array_slice(array: $this->articles, offset: -$howMany,  preserve_keys: true);
    }

    public function removeArticle(int $id): bool {
        $table = Configuration::DATABASE_TABLE_ARTICLES;
        $sql = "DELETE FROM $table where id = $id;";
        if ($this->db->sendQuery($sql)) {
            unset($this->articles[$id]);
            return true;
        } else {
            Logger::report(LogLevel::Error , 'The feed could not remove an article from the database.');
            return false;
        }
    }

    public function addArticle(Article $article): bool {
        $table = Configuration::DATABASE_TABLE_ARTICLES;
        $serializedObject = serialize($article);
        $sql = "INSERT INTO $table (id, serialized_object) VALUES (NULL, '$serializedObject');"; // auto increment id
        if ($this->db->sendQuery($sql)) {
            $this->articles[] = $article; // this new article doesn't have id, after retrieving it from the database it will be assigned
            
            $num = count($this->articles);
            echo "TOTAL NUMBER OF ARTICLES {$num}.";

            return true;
        } {
            Logger::report(LogLevel::Error , 'The feed could add a new article to the database.');
            return false;
        }
    }

}