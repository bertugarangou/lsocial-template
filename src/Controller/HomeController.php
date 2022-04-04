<?php
declare(strict_types=1);

namespace Salle\LSocial\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;
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

        if (!isset($_SESSION['id'])) { #is not set
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();

            return $this->twig->render(
                $response,
                'login.twig',
                [
                    'formAction' => $routeParser->urlFor("loginPOST"),
                    'formMethod' => "GET"
                ]
            );
        } else {#is set OK

            return $this->twig->render(
                $response,
                'home.twig', []);
        }
    }
}