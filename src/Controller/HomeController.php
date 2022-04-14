<?php
declare(strict_types=1);

namespace Salle\LSocial\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Salle\LSocial\Model\Repository\MySQLUserRepository;
use Slim\Views\Twig;
use Salle\LSocial\Model\Repository\MySQLUserRepository as MySQL;

final class HomeController
{
    private Twig $twig;


    public function __construct(Twig $twig,private MySQLUserRepository $SQLRepo){
        $this->twig = $twig;
    }

    public function showHome(Request $request, Response $response)
    {
        if (!isset($_SESSION['id'])) return $response->withHeader('Location', '/sign-in')->withStatus(302);
        else{

            $username = $this->SQLRepo->getUsername($_SESSION['id']);
            return $this->twig->render($response,'home.twig', [
                "username" => $username
            ]);
        }
    }


}