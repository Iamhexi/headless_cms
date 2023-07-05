<?php
require_once 'PersonalAccessToken.php';
require_once 'TemporaryAccessToken.php';


class Authenticator {
    public static function generateTemporaryAccessToken(PersonalAccessToken $token): TemporaryAccessToken {
        return new TemporaryAccessToken($token->getOwner()->id);
    }

    public static function authenticate(TemporaryAccessToken $token): Person|false {
        // TODO: Checks if token exists in the database. Returns the identity of the owner if so. Otherwise, returns false.
    }

}