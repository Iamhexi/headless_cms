<?php
require 'Permission.php';
require 'Article.php';
require 'Person.php';

// is it really necessary? I suppose it just an overcomplication
class PersonalAccessRight {
    public function __construct(
        public Permission $permission,
        public WebLocation $article,
        public Person $person
    ) {}
}