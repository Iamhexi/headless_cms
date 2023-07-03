<?php
require_once 'Permission.php';
require_once 'Article.php';
require_once 'Person.php';

class PersonalAccessRight {
    public function __construct(
        public Permission $permission,
        public WebLocation $article,
        public Person $person
    ) {}
}