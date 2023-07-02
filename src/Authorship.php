<?php
require 'Article.php';
require 'Person.php';


class Authorship {
    public function __construct(
        public Article $article,
        public Person $author
    ) {}
}