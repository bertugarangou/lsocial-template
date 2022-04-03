<?php
# Gràcies stackoverflow 😶
declare(strict_types=1);

namespace Salle\LSocial\Controller;

use Salle\LSocial\Model\User;
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

        if(empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
            $errors['email'] = 'The email address is not valid.';
        }else if($this->emailLassallista($data['email']) == false){
            $errors['email'] = 'Only emails from the domain @salle.url.edu are accepted.';
        }else if($this->SQLRepo->checkEmailExists($data['email']) == true){
            $errors['email'] = 'User already exists. Email must be unique.';
        }


        #mirar contra
        if(empty($data['passwd']) || strlen($data['passwd']) < 5){
            $errors['passwd'] = 'The password must contain at least 6 characters.';
        }else if(preg_match('/[A-Z]/',$data['passwd']) != 1 || preg_match('/[a-z]/',$data['passwd']) != 1 || preg_match('/[0-9]/',$data['passwd']) != 1){
            $errors['passwd'] = 'The password must contain both upper and lower case letters and numbers.';
        }else if(strcmp($data['passwd'], $data['passwd2']) != 0){
            $errors['passwd'] = 'Passwords are not equal';
        }

        #mirar birthdate
        if(!empty($data['birth'])){
            if($this->validateDate($data['birth']) == false){
                $errors['birth'] = 'Birthday is invalid.';
            }else if($this->validateAge($data['birth']) == false){
                $errors['birth'] = 'Sorry, you are underage.';
            }
        }



        if(count($errors) == 0){#està nais 👌

            $user = new User($data['email'], $data['passwd'], $data['birth']);
            $this->SQLRepo->save($user);

            return $this->twig->render($response,'login.twig',[
                'formMethod' => "GET"
            ]); #TODO: canviar link

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
    private function validateDate($birthday): bool{
        if(is_string($birthday)) $birthday = strtotime($birthday);
        if($birthday - time() >= -86400) return false; # si es tria el dia actual dona error, that's ok
        return true;
    }

    private function validateAge($birthday):bool{
        if(is_string($birthday)) $birthday = strtotime($birthday);
        if(time() - $birthday < 18 * 31556926) return false;
        return true;
    }

    private function emailLassallista(mixed $email): bool{

        #ja hi haurà quelcom dins la string si arriba
        $troncar = explode('@',$email);
        $domini = array_pop($troncar);
        if(strcmp($domini, "salle.url.edu") == 0){
            return true;
        }
        return false;
    }
}