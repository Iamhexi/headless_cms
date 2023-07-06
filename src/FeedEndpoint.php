<?php
require_once 'Feed.php';
require_once 'Utils.php';
require_once 'AccessControlPolicy.php';

trait FeedEndpoint {
    private Feed $feed;

    public function __construct() {
        $this->feed = new Feed();
    }

    public function getArticles(): void {
        $this->sendResponse(200, 'Success', $this->feed->getArticles());
    }

    public function updateArticle(): void {
        $input = (array) json_decode(file_get_contents('php://input'), true);
        
        @$id = $input['id'];
        @$title = $input['title'];
        @$content = $input['content'];
        @$coverPhotoURL = $input['coverPhotoURL'];

        // Get person's identity by their personal access token.

        @$personId = $input['person_id'];
        
        $person = Person::getPersonById($personId);
        $permissionType = PermissionType::Update;
        $updatedArticle = $this->feed->getArticleById($id);

        if (!AccessControlPolicy::isAllowed($person, $permissionType, $updatedArticle))
            $this->sendResponse(403, 'Access forbidden', 'The owner of the provided token has no right to complete this action.');
        
        if (!Utils::initialized($title) && !Utils::initialized($content) && !Utils::initialized($coverPhotoURL) )  { 
            $this->sendResponse(400, 'Failure', 'No data has been provided to update the requested article.');
            return;
        } else if (!Utils::initialized($id)) {
            $this->sendResponse(400, 'Failure', 'No \'id\' has been provided to choose which article to update.');
        }
        
        $article = new Article($id, $title, time(), $content, $coverPhotoURL);
        if ($this->feed->updateArticle($article))
            $this->sendResponse(200, 'Success', 'Successfully updated the article.');
        else
            $this->sendResponse(500, 'Failure', 'The request has been processed successfully but the database could not update the article.');
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
}