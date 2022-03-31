<?php
declare(strict_types=1);

use DI\Container;
use Psr\Container\ContainerInterface;
use Salle\LSocial\Controller\CreateUserController;
use Salle\LSocial\Controller\LoginController;
use Salle\LSocial\Model\Repository\MySQLUserRepository;
use Salle\LSocial\Model\Repository\PDOSingleton;
use Salle\LSocial\Model\UserRepository;
use Slim\Views\Twig;

$container = new Container(); # init container

$container->set(
    'view', #nom creador de vistes
    function () {
        return Twig::create(__DIR__ . '/../templates', ['cache' => false]);
    }
);

$container->set(
    LoginController::class,
    function (Container $c) {
        $controller = new LoginController($c->get("view"));
    return $controller;
    }
);

$container->set('db', function () {
    return PDOSingleton::getInstance(
        $_ENV['MYSQL_USER'],
        $_ENV['MYSQL_ROOT_PASSWORD'],
        $_ENV['MYSQL_HOST'],
        $_ENV['MYSQL_PORT'],
        $_ENV['MYSQL_DATABASE']
    );
});

$container->set(
    CreateUserController::class,
    function (Container $c) {
        $controller = new CreateUserController($c->get("view"), $c->get(UserRepository::class));
        return $controller;
    }
);

$container->set(UserRepository::class, function (ContainerInterface $container) {
    return new MySQLUserRepository($container->get('db'));
});

$container->set(
    CookieController::class,
    function (Container $c) {
        $controller = new CookieController($c->get("view"));
        return $controller;
    }
);