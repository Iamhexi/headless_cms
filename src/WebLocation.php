<?php

abstract class WebLocation {
        protected int $id;
        protected string $title;
        protected int $lastModificationTime;
        protected string $content;

    public function getArticleUrl(): string {
        $url = mb_strtolower($this->title);
        $url = explode(' ', $url);
        $url = implode('_', $url);
        return urlencode($url);
    }
}