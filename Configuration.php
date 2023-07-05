<?php

class Configuration {
    public const DEBUG_MODE = true;
    public const DEFAULT_NUMBER_OF_ARTICLES_TO_RETRIEVE_FROM_FEED = 5;
    public const API_TEMPORARY_TOKEN_EXPIRE_TIME_IN_SECONDS = 3600;

    public const DATABASE_SERVER = 'localhost';
    public const DATABASE_USER = 'root';
    public const DATABASE_PASSWORD = 'Fss2PS1E';
    public const DATABASE_NAME = 'headless_cms';

    public const DATABASE_TABLE_PEOPLE = 'people'; // id, first_name, last_name, serialized_role, hashed_personal_access_token
    public const DATABASE_TABLE_ARTICLES = 'articles';
    public const DATABASE_TABLE_PAGES = 'pages';
    public const DATABASE_TABLE_PERMISSIONS = 'permissions';
    public const DATABASE_TABLE_ROLES = 'roles';
    public const DATABASE_TABLE_ROLE_PERMISSIONS = 'role_permissions';
    public const DATABASE_TABLE_PERSONAL_ACCESS_RIGHTS = 'personal_access_rights'; // person_id, permission_id, is_article, web_location_id
    public const DATABASE_TABLE_AUTHORSHIPS = 'authorships';
    public const DATABASE_TABLE_TEMPORARY_ACCESS_TOKENS = 'temporary_access_tokens';

    public const DATABASE_TABLE_TAGS = 'tags';
}