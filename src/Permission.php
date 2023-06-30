<?php

class Permission {
    public function __construct(
        public int $id,
        public PermissionType $type,
        public PermissionSpecifier $specifier,
        public PermissionObject $object
    ) {}
}

enum PermissionObject {
    case Article;
    case Page;
}

enum PermissionType {
    case Create;
    case Update;
    case Delete;
}

enum PermissionSpecifier {
    case None;
    case Specific;
    case TheirOwn;
    case All;
}