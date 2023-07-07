<?php
require_once 'Authenticator.php';

trait AuthenticationEndpoint {
    public function authenticate(): void {
        $token = @$_GET['token'];
        $personalToken = new PersonalAccessToken($token);

        if ( Authenticator::authenticate( $tempToken = Authenticator::generateTemporaryAccessToken($personalToken) ) !== false)
            $this->sendResponse(200, 'Successfully authenticated', $tempToken->getToken());
        else 
            $this->sendResponse(401, 'Failed to authenticate', 'The provided Personal Access Token (PAT) seems to be incorrect. Try the different one.');
    }
}