<?php
declare(strict_types=1);


use Salle\LSocial\Controller\HomeController;
use Salle\LSocial\Controller\LoginController;
use Salle\LSocial\Controller\RegisterController;
use Salle\LSocial\Middleware\StartSessionMiddleware;

/** @var TYPE_NAME $app */
$app->add(StartSessionMiddleware::class);

$app->get('/', HomeController::class . ':showHome')->setName('home');
//$app->post('/', HomeController::class . ':handleFormSubmission')->setName('homeLogout');

$app->get('/sign-up', RegisterController::class . ":showForm")->setName('registerGET');
$app->post('/sign-up', RegisterController::class . ":handleFormSubmission")->setName('registerPOST');

$app->get('/sign-in', LoginController::class . ":showForm")->setName('loginGET');
$app->post('/sign-in', LoginController::class . ":handleFormSubmission")->setName('loginPOST');
