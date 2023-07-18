<?php

class Configuration {
    // Development
    public const DEBUG_MODE = true;
    
    // Security
    public const API_TEMPORARY_TOKEN_EXPIRE_TIME_IN_SECONDS = 3600;
    public const TEMPORARY_ACCESS_TOKEN_LENGTH = 64; // the database column for a has to contain that many characters
    public const PHP_TOKEN_HASHING_ALGORITHM = PASSWORD_ARGON2I; // Possible values: PASSWORD_DEFAULT, PASSWORD_BCRYPT, PASSWORD_ARGON2I, PASSWORD_ARGON2ID

    // Settings - Feed
    public const DEFAULT_NUMBER_OF_ARTICLES_TO_RETRIEVE_FROM_FEED = 5;

    // Database credentials
    public const DATABASE_SERVER = 'localhost';
    public const DATABASE_USER = 'root';
    public const DATABASE_PASSWORD = 'Fss2PS1E';
    public const DATABASE_NAME = 'headless_cms';

    public const DATABASE_TABLE_PEOPLE = 'people'; // id, first_name, last_name, serialized_role, hashed_personal_access_token, last_active_time
    public const DATABASE_TABLE_ARTICLES = 'articles'; // id, serialized_object
    public const DATABASE_TABLE_PAGES = 'pages'; // id, serialized_object
    public const DATABASE_TABLE_PERMISSIONS = 'permissions'; // combination of all available permissions
    public const DATABASE_TABLE_ROLES = 'roles'; // serialized_object
    public const DATABASE_TABLE_ROLE_PERMISSIONS = 'role_permissions'; // meta-table binding permissions with roles
    public const DATABASE_TABLE_PERSONAL_ACCESS_RIGHTS = 'personal_access_rights'; // person_id, serialized_object
    public const DATABASE_TABLE_AUTHORSHIPS = 'authorships'; // meta-table binding people (articles' authors) and articles
    public const DATABASE_TABLE_TEMPORARY_ACCESS_TOKENS = 'temporary_access_tokens'; // person_id, token, expire_time
    public const DATABASE_TABLE_TAGS = 'tags'; // meta-table binding articles and their tags
}