<?php

use App\Models\UserModel;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function getJWTFromRequest($authenticationHeader): string
{
    if (is_null($authenticationHeader)) { //JWT is absent
        throw new Exception('Missing or invalid JWT in request');
    }
    //JWT is sent from client in the format Bearer XXXXXXXXX
    return explode(' ', $authenticationHeader)[1];
}

function validateJWTFromRequest(string $encodedToken)
{
    $key = Services::getSecretKey();
    // $decodedToken = JWT::decode($encodedToken, $key, 'HS256');
    $decodedToken = JWT::decode($encodedToken, new Key($key, 'HS512'));
    $userModel = new UserModel();
    //print_r($userModel->findUserByEmailAddress($decodedToken->user_email));exit();
    $userModel->findUserByEmailAddress($decodedToken->user_email);
}

function getSignedJWTForUser(string $email)
{
    $issuedAtTime = time();
    $tokenTimeToLive = getenv('JWT_TIME_TO_LIVE');
    $tokenExpiration = $issuedAtTime + $tokenTimeToLive;
    $alg="HS512";
    $payload = [
        'user_email' => $email,
        'iat' => $issuedAtTime,
        'exp' => $tokenExpiration,
    ];

    $jwt = JWT::encode($payload, Services::getSecretKey(),$alg);
    return $jwt;
}
