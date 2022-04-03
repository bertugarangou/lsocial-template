<?php
declare(strict_types=1);

namespace Salle\LSocial\Middleware;

use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Psr7\Response as SlimResponse;

final class BeforeMiddleware{#no fer cas al nom, es de SORTIDA
    public function __invoke(Request $request, RequestHandler $next): Response
    {
        $response = $next->handle($request);

        $existingContent = (string) $response->getBody();

        $response = new SlimResponse();#crea una resposta de sortida
        $response->getBody()->write('BEFORE' . $existingContent);

        return $response;
    }
}