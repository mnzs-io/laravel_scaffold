<?php

namespace App\Services;

use DateTimeImmutable;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTService
{
    public static function generateToken($user, $association): string
    {
        $secretKey = env('JWT_KEY');
        // TODO: TROCAR?
        $tokenId = base64_encode(random_bytes(16));
        $issuedAt = new DateTimeImmutable;
        $expire = $issuedAt->modify('+6 minutes')->getTimestamp();
        $serverName = 'your.server.name';
        $userID = $user->id;

        // Create the token as an array
        $data = [
            'iat' => $issuedAt->getTimestamp(),
            'jti' => $tokenId,
            'iss' => $serverName,
            'nbf' => $issuedAt->getTimestamp(),
            'exp' => $expire,
            'data' => [
                'userID' => $userID,
            ],
        ];

        // Encode the array to a JWT string.
        $token = JWT::encode(
            $data,
            $secretKey,
            'HS512'
        );

        return $token;
    }

    public static function parseToken()
    {
        $token = request()->bearerToken();
        if (!$token) {
            throw new \Exception('Token not found');
        }
        try {
            $decoded = JWT::decode($token, new Key(env('JWT_KEY'), 'HS512'));

            return $decoded;
        } catch (\Exception $e) {
            throw new \Exception('Invalid token: ' . $e->getMessage());
        }
    }

    public static function getUser()
    {
        $token = self::parseToken();
        $userId = $token->data->userID;

        return \App\Models\User::find($userId);
    }
}
