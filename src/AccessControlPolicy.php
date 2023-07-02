<?php
require 'DatabaseController.php';

class AccessControlPolicy {
    public static function isAllowed(Person $person, PermissionType $action, WebLocation $onObject): bool {
        if (self::hasPersonalAccess($person, $action, $onObject) || self::hasRoleAccess($person->role, $action, $onObject))
            return true;
        return false;
    }

    public static function hasPersonalAccess(Person $person, PermissionType $action, WebLocation $onObject): bool {
        $table = Configuration::DATABASE_TABLE_PERSONAL_ACCESS_RIGHTS;
        $sql = "SELECT serialized_object FROM $table;";
        $db = new DatabaseController();
        $rows = $db->getArrayOfRecords($sql);

        $locationType = ($onObject instanceof Article) ? PermissionObject::Article : PermissionObject::Page;
        
        foreach($rows as $row) {
            $personalRight = unserialize($row['serialized_object']);
            if (
                $personalRight->person->id === $person->id &&
                $personalRight->permission->type === $action &&
                $personalRight->permission->object === $locationType
            ) {
                return true;
            }
        }
        return false;
    }

    public static function hasRoleAccess(Role $role, PermissionType $action, WebLocation $onObject): bool {
        
    }
}