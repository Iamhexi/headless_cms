<?php
require_once '../../../src/API.php';
require_once '../../../src/Authenticator.php';
// handles redirecting modules
$api = new API();

$token = @$_GET['token'];

switch($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        if ($person = Authenticator::authenticate($token))
            $api->addArticle();
        else
            $api->reportFailedAuthentication();
        break;

    case 'DELETE':
        if ($person = Authenticator::authenticate($token))
            $api->removeArticle();
        else
            $api->reportFailedAuthentication();
        break;

    case 'PUT':
        if ($person = Authenticator::authenticate($token))
            $api->updateArticle();
        else
            $api->reportFailedAuthentication();
        break;

    case 'GET':
        $api->getArticles();
        break;
    
    default:
        $api->reportUnrecognizedEndpoint();
        break;
}