<?php

use PSpell\Config;

require 'Article.php';
require 'Logger.php';
require 'Authorship.php';

class Article extends WebLocation {
    public function __construct(
        private int $id,
        private string $title,
        private int $lastModificationTime,
        private string $content,
        private string $coverPhotoURL,
        private SplObjectStorage $authorships = new SplObjectStorage(), // array of Authorship objects
        private array $tags = [] // array of string objects
    ) {}

    public function addAuthor(Authorship $authorship): void {
        $this->authorships->attach($authorship);
    }

    public function generateSQLUpdateQueries(): array /* of strings */  {
        $table = Configuration::DATABASE_TABLE_ARTICLES;
        $sqlQueries[] = "UPDATE $table SET
            id = {$this->id},
            title = '{$this->title}',
            lastModificationTime = {$this->lastModificationTime},
            content = '{$this->content}',
            coverPhotoURL = '{$this->coverPhotoURL}';
        ";

        $table = Configuration::DATABASE_TABLE_TAGS;
        foreach ($this->tags as $tag)
            $sqlQueries[] = "
                INSERT INTO $table (article_id, tag) 
                SELECT {$this->id}, '$tag' FROM DUAL
                WHERE NOT EXISTS 
                (SELECT {$this->id}, '$tag' FROM $table WHERE article_id = {$this->id} AND tag = '$tag');
            ";

        $table = Configuration::DATABASE_TABLE_AUTHORSHIPS;
        foreach ($this->authorships as $authorship)
        $sqlQueries[] = "
            INSERT INTO $table (article_id, person_id) 
            SELECT {$this->id}, {$authorship->author->id} FROM DUAL
            WHERE NOT EXISTS 
            (SELECT {$this->id}, $authorship->author->id FROM $table 
            WHERE article_id = {$this->id} AND person_id = {$authorship->author->id});
            ";
        
        return $sqlQueries;
    }
}