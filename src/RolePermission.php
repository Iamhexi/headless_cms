<?php

class RolePermission {
    public function __construct(
        public Role $role,
        public Permission $permission
    ) {}
}