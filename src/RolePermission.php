<?php

class RolePermission {
    public function __construct(
        public Role $role,
        public Permission $permission
    ) {
        $permission->specifier = PermissionSpecifier::Specific;
    }
}