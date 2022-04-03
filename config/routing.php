<?php
declare(strict_types=1);


use Salle\LSocial\Controller\CreateUserController;
use Salle\LSocial\Controller\HomeController;
use Salle\LSocial\Controller\LoginController;
use Salle\LSocial\Controller\RegisterController;
use Salle\LSocial\Middleware\StartSessionMiddleware;

/** @var TYPE_NAME $app */
$app->add(StartSessionMiddleware::class);

$app->get('/', HomeController::class . ':showHome')->setName('home');

$app->get('/sign-up', RegisterController::class . ":showForm");
$app->post('/sign-up', RegisterController::class . ":handleFormSubmission")->setName('registerPOST');

$app->get('/sign-in', LoginController::class . ":showForm");
$app->post('/sign-in', LoginController::class . ":handleFormSubmission")->setName('loginPOST');

$app->post('/user', CreateUserController::class . ":apply")->setName('create_user');
