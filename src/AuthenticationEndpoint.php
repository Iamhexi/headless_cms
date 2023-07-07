<?php
require_once 'Authenticator.php';

trait AuthenticationEndpoint {
    public function authenticate(): void {
        $input = Utils::getJSONInputAsArray();

        $token = @$input['token'];
        $personalToken = new PersonalAccessToken($token);
        if ($person = Authenticator::authenticate( $tempToken = Authenticator::generateTemporaryAccessToken($personalToken) ))
            $this->sendResponse(200, 'Successfully authenticated', $tempToken->getToken());
        else 
            $this->sendResponse(401, 'Failed to authenticate', 'The provided Personal Access Token (PAT) seems to be incorrect. Try the different one.');
    }
}