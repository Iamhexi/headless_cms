<?php
require_once 'Article.php';
require_once 'Person.php';


class Authorship {
    public function __construct(
        public Article $article,
        public Person $author
    ) {}
}