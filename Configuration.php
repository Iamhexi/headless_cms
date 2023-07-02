<?php

class Configuration {
    public const DEFAULT_NUMBER_OF_ARTICLES_TO_RETRIEVE_FROM_FEED = 5;

    public const DATABASE_SERVER = '';
    public const DATABASE_USER = '';
    public const DATABASE_PASSWORD = '';
    public const DATABASE_NAME = '';

    public const DATABASE_TABLE_ARTICLES = 'articles';
    public const DATABASE_TABLE_PAGES = 'pages';
    public const DATABASE_TABLE_PERMISSIONS = 'permissions';
    public const DATABASE_TABLE_ROLES = 'roles';
    public const DATABASE_TABLE_ROLE_PERMISSIONS = 'role_permissions';
    public const DATABASE_TABLE_PERSONAL_ACCESS_RIGHTS = 'personal_access_rights'; // person_id, permission_id, is_article, web_location_id
    public const DATABASE_TABLE_AUTHORSHIPS = 'authorships';
    public const DATABASE_TABLE_TAGS = 'tags';


}