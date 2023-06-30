<?php
require 'DatabaseController.php';
require 'Article.php';
require '../Configuration.php';

class Feed {
    private DatabaseController $db;
    private array $articles = [];

    public function getArticles(
        int $howMany = Configuration::DEFAULT_NUMBER_OF_ARTICLES_TO_RETRIEVE_FROM_FEED) 
    : array
    {
        return [];
    }

    public function removeArticle(int $id): bool {
        return false;
    }

    public function addArticle(Article $article): bool {
        return false;
    }

    public function __destruct() {
        if (!$this->saveChangesToDatabases())
            Logger::report(LogLevel::Error , 'The feed could not save the applied changes to the database.');
    }

    private function saveChangesToDatabases(): bool {
        // TODO: implement
        $this->db;


        return false;
    }

}