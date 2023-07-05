<?php
require_once 'FeedEndpoint.php';

class API {
    use FeedEndpoint;
    
    private bool $answered = false;
    
    public function reportUnrecognizedEndpoint(): void {
        $this->sendResponse(405, 'Failure', 'An unrecognized endpoint has been requested. Check if the method and the URL are both valid.');
    }

    private function sendResponse(int $code, string $message, $data): void
    {
        // Set headers to allow cross-origin requests
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type");

        // Handle preflight requests
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            // Allow preflight requests to return appropriate headers
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
            header("Access-Control-Allow-Headers: Content-Type");
            exit;
        }

        // header('Content-Type: application/json'); // FIXME: this header violates CSP policy and blocks requests

        $response['code'] = $code;
        $response['message'] = $message;
        $response['data'] = $data;
        http_response_code($code);

        
        if ($this->answered === false)
            echo json_encode($response);
        
        $this->answered = true;
    }
}