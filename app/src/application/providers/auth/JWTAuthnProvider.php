<?php

namespace festival\application\providers\auth;

use festival\core\Dto\DtoCredentials;
use festival\core\ReposotiryInterfaces\UtilisateurRepositoryInterface;
use PhpParser\Token;
use festival\core\Dto\DtoAuth;
use festival\core\services\auth\serviceAuthn;

class JWTAuthnProvider implements AuthnProviderInterface{

    private UtilisateurRepositoryInterface $repositoryUtilisateur;

    public function __construct(UtilisateurRepositoryInterface $repositoryUtilisateur){
        $this->repositoryUtilisateur = $repositoryUtilisateur;
    }


    public function signin(DtoCredentials $credentials): DtoAuth{
        $user = $this->repositoryUtilisateur->getUserByEmail($credentials);
        if (!$user) {
            throw new \Exception('Cet utilisateur n\'existe pas');
        }

        $payload = [ 'iss'=>'localhost:22000/users/signin',
            'aud'=>'localhost:22000/users/signin',
            'iat'=>time(),
            'exp'=>time()+getenv('JWT_EXPIRATION_TIME'),
            'sub' => $user->getId(),
            'data' => [
                'role' => $user->getRole(),
                'email' => $user->getEmail(),
                'name' => $user->getNom()
            ]
        ] ;

        $jwt = new JWTManager();
        $auth = new serviceAuthn($this->repositoryUtilisateur);
        $accessToken = $jwt->creatAccessToken($payload);
        $refreshToken = $jwt->creatRefreshToken($payload);
        $user2 = $auth->byCredentials($credentials);
        $user2->addToken($accessToken, $refreshToken);
        return $user2;
    }

    public function refresh(Token $token): DtoAuth{
        $payload = JWTManager::class->decodeToken($token);

        $token = JWTManager::class->creatAccessToken($payload);
        $rtoken = JWTManager::class->creatRefreshToken($payload);
        $auth = new DtoAuth($payload['data']['name'], $payload['data']['email'], $payload['sub'], $payload['data']['role']);
        
        return $auth->addToken($token, $rtoken);
    }

    static function getSignedInUser(string $token): DtoAuth{
        $jwtManager = new JWTManager(); // ou la classe appropriée
        $payload = $jwtManager->decodeToken($token);
        return new DtoAuth($payload['data']->name, $payload['data']->email, $payload['sub'], $payload['data']->role);
    }
}