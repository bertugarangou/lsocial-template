<?php

declare(strict_types=1);

namespace Salle\LSocial\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

final class LoginController
{
    public function __construct(
        private Twig $twig
    )
    {
    }

    public function showLoginFormAction(Request $request, Response $response): Response
    {
        return $this->twig->render($response, 'login.twig', []);
    }

}