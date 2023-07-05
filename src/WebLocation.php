<?php

abstract class WebLocation {
        public ?int $id;
        protected ?string $title;
        protected int $lastModificationTime;
        protected ?string $content;

    public function getArticleUrl(): string {
        $url = mb_strtolower($this->title);
        $url = explode(' ', $url);
        $url = implode('_', $url);
        return urlencode($url);
    }

    public abstract function isAuthoredBy(Person $person): bool;
}