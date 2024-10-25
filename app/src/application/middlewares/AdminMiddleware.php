<?php

namespace festival\application\middlewares;

use festival\application\providers\auth\JWTAuthnProvider;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response as SlimResponse;

class AdminMiddleware implements MiddlewareInterface {


    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface{

        try {
            $header = $request->getHeader('Authorization')[0] ?? null;

            if ($header === null) {
                throw new \Exception("Authorization header missing", 401);
            }

            $tokenString = sscanf($header, "Bearer %s")[0];
            // Valider le token et obtenir l'utilisateur
            $auth = JWTAuthnProvider::getSignedInUser($tokenString);

            if (!$auth->isAdmin()) {
                $rs = new SlimResponse();
                $rs->getBody()->write(json_encode(['error' => 'Forbidden']));
                return $rs->withStatus(403)->withHeader('Content-Type', 'application/json');
            }

        } catch (ExpiredException $e) {
            return $this->unauthorizedResponse("Token expired");
        } catch (SignatureInvalidException $e) {
            return $this->unauthorizedResponse("Token invalid");
        } catch (BeforeValidException $e) {
            return $this->unauthorizedResponse("Token not yet valid");
        } catch (\UnexpectedValueException $e) {
            return $this->unauthorizedResponse("Token invalid");
        } catch (\Exception $e) {
            return $this->unauthorizedResponse($e->getMessage());
        }

        // Ajouter l'utilisateur authentifié dans les attributs de la requête
        $request = $request->withAttribute('auth', $auth);

        // Appeler le prochain middleware
        return $handler->handle($request);
    }

    private function unauthorizedResponse(string $message): Response
    {
        $rs = new SlimResponse();
        $rs->getBody()->write(json_encode(['error' => $message]));
        return $rs->withStatus(401)->withHeader('Content-Type', 'application/json');
    }

}