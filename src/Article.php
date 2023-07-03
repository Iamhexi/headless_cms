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

    public function isAuthoredBy(Person $person): bool {
        foreach($this->authorships as $authorship) // spl contains() methods doesn't work here as it checks refereces
            if ($authorship->person === $person)
                return true;
        return false;
    }
}