<?php

use App\Models\UserModel;
use App\Models\MunicipioModel;
use Config\Services;
use Firebase\JWT\JWT;

function getJWTFromRequest($authenticationHeader): string
{
    if (is_null($authenticationHeader)) {
        throw new Exception('Missing or invalid JWT in request');
    }
    return explode(' ', $authenticationHeader)[1];
}

function validateJWTFromRequest(string $encodedToken)
{
    $key = getenv('JWT_SECRET_KEY');
    $decodedToken = JWT::decode(
        $encodedToken,
        new \Firebase\JWT\Key($key, "HS256")
    );
    $userModel = new UserModel();
    $municipioModel = new MunicipioModel();
    $user = $userModel->findUserByUsername($decodedToken->username);
    $dataMunicipio = $municipioModel->getDataMunicipioToConnection($user['id_municipio']);
    $db = db_connect();
    $typeDB = Services::getDatabaseType();
    if ($typeDB == NULL) {
        $typeDB = "cloudDB";
    }
    $db->setDatabase($dataMunicipio[$typeDB]);
}

function getSignedJWTForUser(string $username)
{
    $issuedAtTime = time();
    $tokenTimeToLive = getenv('JWT_TIME_TO_LIVE');
    $tokenExpiration = $issuedAtTime + $tokenTimeToLive;
    $payload = [
        'username' => $username,
        'iat' => $issuedAtTime,
        'exp' => $tokenExpiration
    ];
    $jwt = JWT::encode($payload, getenv('JWT_SECRET_KEY'), 'HS256');
    return $jwt;
}
