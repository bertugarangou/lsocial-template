<?php
declare(strict_types=1);

use Slim\Factory\AppFactory;
use Slim\Views\TwigMiddleware;
use Symfony\Component\Dotenv\Dotenv;require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = new Dotenv();

$dotenv->load(__DIR__ . '/../.env');    # IMPORTANT PRIMER .ENV I DESPRES DEPENDENVIES
require_once __DIR__ . '/../config/dependencies.php';

AppFactory::setContainer($container);#twig

$app = AppFactory::create();

$app->add(TwigMiddleware::createFromContainer($app));#twig middleware INTERIOR
$app->addBodyParsingMiddleware(); #abans del route
$app->addRoutingMiddleware(); #routing middleware MIG

$app->addErrorMiddleware(true, false, false); #error middleware EXTERIOR

require_once __DIR__ . '/../config/routing.php';

$app->run();