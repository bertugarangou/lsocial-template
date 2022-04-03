<?php
declare(strict_types=1);

namespace Salle\LSocial\Controller;

use Slim\Routing\RouteContext;
use Slim\Views\Twig;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Salle\LSocial\Model\Repository\MySQLUserRepository;

final class RegisterController{
    public function __construct(private Twig $twig, private MySQLUserRepository $SQLRepo){}

    public function showForm(Request $request, Response $response): Response{

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();

        return $this->twig->render(
            $response,
            'signup.twig',
            [
                'formAction' => $routeParser->urlFor("registerPOST"),
                'formMethod' => "POST"
            ]
        );
    }


    public function handleFormSubmission(Request $request, Response $response): Response{
        $data = $request->getParsedBody();

        $errors = [];

        #mirar email
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL) || strpos($data['email'],"@salle.url.edu") == false || $this->SQLRepo->checkEmailExists($data['email']) == true) {
            $errors['email'] = 'The email address is not valid';
        }

        #mirar contra
        if(empty($data['passwd']) || strlen($data['passwd']) < 5 || preg_match('/[A-Z]/',$data['passwd']) != 1 || preg_match('/[a-z]/',$data['passwd']) != 1){
            $errors['passwd'] = 'The password is not valid';
        }


        if(count($errors) == 0){#està nais 👌
            return $this->twig->render($response,'home.twig',[
                'formMethod' => "GET"
            ]);
        }else {#errors sad uwu


            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $this->twig->render(
                $response,
                'signup.twig',
                [
                    'formErrors' => $errors,
                    'formData' => $data,
                    'formAction' => $routeParser->urlFor("registerPOST"),
                    'formMethod' => "POST"
                ]
            );
        }
    }
}