<?php
require_once 'Role.php';

class Person {
    public function __construct(
        public int $id,
        public string $firstName,
        public string $lastName,
        public Role $role,
        public string $hashedPersonalAccessToken,
        public int $lastTimeActive
    ) {}
}