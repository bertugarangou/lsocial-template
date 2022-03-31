<?php
declare(strict_types=1);


use Salle\LSocial\Controller\CreateUserController;
use Salle\LSocial\Controller\HomeController;
use Salle\LSocial\Controller\LoginController;
use Salle\LSocial\Controller\RegisterController;
use Salle\LSocial\Middleware\StartSessionMiddleware;

/** @var TYPE_NAME $app */
$app->add(StartSessionMiddleware::class);

$app->get('/sign-up', RegisterController::class . ":showSign-up")->setName('sign-upShow');
$app->post('/sign-up', RegisterController::class . ":sendSign-up")->setName('sign-upSend');

$app->get('/sign-in', LoginController::class . ":showLoginFormAction");
$app->post('/sign-in', LoginController::class . ":loginAction")->setName('sign-in');

$app->get('/', HomeController::class . ':showHome')->setName('home');

$app->post('/user', CreateUserController::class . ":apply")->setName('create_user');
