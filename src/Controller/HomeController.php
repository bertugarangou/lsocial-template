<?php
declare(strict_types=1);

namespace Salle\LSocial\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

final class HomeController
{
    private Twig $twig;


    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function showHome(Request $request, Response $response)
    {
        return $this->twig->render(
            $response,
            'home.twig',[]);
    }
}