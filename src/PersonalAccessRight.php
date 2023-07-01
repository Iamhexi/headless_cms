<?php
require 'Permission.php';
require 'Article.php';
require 'Person.php';

class PersonalAccessRight {
    public function __construct(
        public Permission $permission,
        public Article $article,
        public Person $person
    ) {}
}