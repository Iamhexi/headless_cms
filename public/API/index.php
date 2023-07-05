<?php
require_once '../../src/FeedEndpoint.php';
// handles redirecting modules
$feedEndpoint = new FeedEndpoint();

switch($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $feedEndpoint->addArticle();
        break;

    case 'DELETE':
        $feedEndpoint->removeArticle();
        break;

    case 'PUT':
        $feedEndpoint->updateArticle();

    case 'GET':
        $feedEndpoint->getArticles();
        break;
    
    default:
        $feedEndpoint->reportUnrecognizedEndpoint();
        break;
}