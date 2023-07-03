<?php
require 'Feed.php';

class API {
    private bool $answered = false;

    public function getArticles(): void {
        $feed = new Feed();
        $this->sendResponse(200, 'Success', $feed->getArticles());
    }

    private function sendResponse(int $code, string $message, $data): void
    {
        header("Access-Control-Allow-Origin: " . Configuration::ACCESS_CONTROL_ALLOW_ORIGIN);
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type:application/json");
        header("HTTP/1.1 " . $code);

        $response['code'] = $code;
        $response['message'] = $message;
        $response['data'] = $data;

        if ($this->answered === false)
            echo json_encode($response);

        $this->answered = true;
    }
}