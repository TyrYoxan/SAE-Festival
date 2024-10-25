<?php

namespace festival\application\middlewares;

use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\BeforeValidException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use festival\application\providers\auth\JWTAuthnProvider;
use Slim\Psr7\Response as SlimResponse;

class JWTAuthMiddleware implements MiddlewareInterface
{
    public function process(Request $request, RequestHandlerInterface $handler): Response
    {
        try {
            var_dump($request->getHeader('Authorization')[0]);
            $header = $request->getHeader('Authorization')[0] ?? null;

            if ($header === null) {
                throw new \Exception("Authorization header missing", 401);
            }

            $tokenString = sscanf($header, "Bearer %s")[0];

            // Valider le token et obtenir l'utilisateur
            $auth = JWTAuthnProvider::getSignedInUser($tokenString);

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
        $response = new SlimResponse();
        $response->getBody()->write(json_encode(['error' => $message]));
        return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
    }
}
