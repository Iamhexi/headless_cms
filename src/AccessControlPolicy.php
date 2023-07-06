<?php
require_once 'DatabaseController.php';

class AccessControlPolicy {
    public static function isAllowed(Person $person, PermissionType $action, WebLocation $onObject): bool {
        if (self::hasPersonalAccess($person, $action, $onObject) || self::hasRoleAccess($person, $action, $onObject))
            return true;
        return false;
    }

    public static function hasPersonalAccess(Person $person, PermissionType $action, WebLocation $onObject): bool {
        $table = Configuration::DATABASE_TABLE_PERSONAL_ACCESS_RIGHTS;
        $sql = "SELECT person_id, serialized_object FROM $table WHERE person_id = {$person->id};";
        $db = new DatabaseController();
        $rows = $db->getArrayOfRecords($sql);

        $locationType = ($onObject instanceof Article) ? PermissionObject::Article : PermissionObject::Page;
        
        foreach($rows as $row) {
            $personalRight = unserialize($row['serialized_object']);
            if (
                $personalRight->permission->type === $action &&
                $personalRight->permission->object === $locationType
            ) {
                return true;
            }
        }
        return false;
    }

    public static function hasRoleAccess(Person $person, PermissionType $action, WebLocation $onObject): bool {
        $db = new DatabaseController();

        $table = Configuration::DATABASE_TABLE_ROLE_PERMISSIONS;
        $sql = "SELECT serialized_object FROM $table;";
        $rows = $db->getArrayOfRecords($sql);

        $locationType = ($onObject instanceof Article) ? PermissionObject::Article : PermissionObject::Page;
        $role = $person->role;
        
        foreach($rows as $row) {
            $permission = unserialize($row['serialized_object']);
            if ($permission->role === $role &&
                $permission->permission->type === $action &&
                $permission->permission->object === $locationType &&
                (
                    $permission->permission->specifier === PermissionSpecifier::All || 
                    (
                        $permission->permission->specifier === PermissionSpecifier::TheirOwn &&
                        $onObject->isAuthoredBy($person)
                    )
                )   
            )
                return true;
        }
        return false;
    }
}