<?php
require_once '../../../src/API.php';
// handles redirecting modules
$api = new API();

switch($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $api->authenticate();
        break;
    
    default:
        $api->reportUnrecognizedEndpoint();
        break;
}