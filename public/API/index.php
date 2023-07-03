<?php
require_once '../../src/API.php';
// handles redirecting modules
@$action = $_GET['action'];
$api = new API();

switch($action) {
    case 'add':
        $api->addArticle();
        break;

    case 'remove':
        $api->removeArticle();
        break;

    case 'get':
        $api->getArticles();
        break;
    
    default:
        $api->reportUnrecognizedEndpoint();
        break;
}