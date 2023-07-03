<?php
require_once 'Feed.php';
require_once 'Utils.php';

class API {
    private bool $answered = false;
    private Feed $feed;

    public function __construct() {
        $this->feed = new Feed();
    }

    public function getArticles(): void {
        $this->sendResponse(200, 'Success', $this->feed->getArticles());
    }

    public function removeArticle(): void { 
        $input = (array) json_decode(file_get_contents('php://input'), true);
        $id = @$input['id'];

        if (isset($id) && !empty($id))
            if ($this->feed->removeArticle($id)) {
                $this->sendResponse(200, 'Success', 'The article has been successfully removed.');
                return;
            }
        $this->sendResponse(400, 'Failure', 'The \'id\' parameter is missing.');
    }

    public function addArticle(): void {
        $input = (array) json_decode(file_get_contents('php://input'), true);

        @$title = $input['title'];
        @$content = $input['content'];
        @$coverPhotoURL = $input['coverPhotoURL'];
        
        if (!Utils::initialized($title, $content, $coverPhotoURL)) {
            $this->sendResponse(400, 'Failure', 'The request has failed due to the missing data.');
            return;
        }
        
        $article = new Article(null, $title, time(), $content, $coverPhotoURL);
        if ($this->feed->addArticle($article))
            $this->sendResponse(200, 'Success', 'Successfully added the article to the database.');
        else
            $this->sendResponse(500, 'Failure', 'The request has been processed successfully but the database could not saved the article.');

    }

    public function reportUnrecognizedEndpoint(): void {
        $this->sendResponse(405, 'Failure', 'An unrecognized endpoint has been requested. Check if the method and the URL are both valid.');
    }

    private function sendResponse(int $code, string $message, $data): void
    {
        // Set headers to allow cross-origin requests
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type");

        // Handle preflight requests
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            // Allow preflight requests to return appropriate headers
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
            header("Access-Control-Allow-Headers: Content-Type");
            exit;
        }

        $response['code'] = $code;
        $response['message'] = $message;
        $response['data'] = $data;
        http_response_code($code);

        
        if ($this->answered === false)
            echo json_encode($response);
        
        $this->answered = true;
    }
}