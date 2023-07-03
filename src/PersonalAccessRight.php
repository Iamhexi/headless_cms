<?php
require 'Permission.php';
require 'Article.php';
require 'Person.php';

class PersonalAccessRight {
    public function __construct(
        public Permission $permission,
        public WebLocation $article,
        public Person $person
    ) {}
}