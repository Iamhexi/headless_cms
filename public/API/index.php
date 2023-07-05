<?php
require_once '../../src/API.php';
// handles redirecting modules
$api = new API();

switch($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $api->addArticle();
        break;

    case 'DELETE':
        $api->removeArticle();
        break;

    case 'PUT':
        $api->updateArticle();

    case 'GET':
        $api->getArticles();
        break;
    
    default:
        $api->reportUnrecognizedEndpoint();
        break;
}