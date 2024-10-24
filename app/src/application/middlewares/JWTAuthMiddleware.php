<?php

namespace festival\application\middlewares;

use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException ;
use Firebase\JWT\BeforeValidException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use festival\application\providers\auth\JWTAuthnProvider;

class JWTAuthMiddleware{

    public function __invoke(Request $rq, Response $rs, callable $next): Response{
        try {
            $h = $rq->getHeader('Authorization')[0] ;
            $tokenstring = sscanf($h, "Bearer %s")[0];

            $auth = JWTAuthnProvider::class->getSignedInUser($tokenstring);

        } catch (ExpiredException $e) {
            throw new \Exception("Token expired", 401);
        } catch (SignatureInvalidException $e) {
            throw new \Exception("Token invalid", 401);
        } catch (BeforeValidException $e) {
            throw new \Exception("Token not yet valid", 401);
        } catch (\UnexpectedValueException $e) {
            throw new \Exception(" invalid", 401);
        }

        $rq = $rq->withAttribute('auth', $auth);

        return $next->handle($rq);
    }
}