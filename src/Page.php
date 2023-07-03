<?php

class Page extends WebLocation {
    
    public function isAuthoredBy(Person $person): bool {
       return false; // a page doesn't have an author
    }
}