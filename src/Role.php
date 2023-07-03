<?php
require_once 'Permission.php';

class Role {
    public function __construct(
        public int $id,
        public string $title,
        private array $permissions
    ){}

    public function hasPermission(Permission $permission): bool {
        return in_array($permission, $this->permissions);
    }

    public function grantPermission(Permission $permission): void {
        $this->permissions[$permission->id] = $permission;
    }

    public function removePermission(Permission $permission): void {
        unset($this->permissions[$permission->id]);
    }

    public function __destruct() {
        // TODO: save changes to the db
    }
}