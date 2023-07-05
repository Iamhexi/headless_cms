<?php
require_once 'WebLocation.php';
require_once 'Logger.php';
require_once 'Authorship.php'; 

class Article extends WebLocation {
    public function __construct(
        public ?int $id = null,
        public ?string $title,
        public int $lastModificationTime,
        public ?string $content,
        public ?string $coverPhotoURL,
        // public SplObjectStorage $authorships = new SplObjectStorage(), // array of Authorship objects
        public array $tags = [] // array of string objects
    ) {}

    public function addAuthor(Authorship $authorship): void {
        // $this->authorships->attach($authorship);
    }

    public function isAuthoredBy(Person $person): bool {
        // foreach($this->authorships as $authorship) // spl contains() methods doesn't work here as it checks refereces
        //     if ($authorship->person === $person)
        //         return true;
        return false;
    }
}