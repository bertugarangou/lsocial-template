<?php
declare(strict_types=1);

namespace Salle\LSocial\Controller;
use Slim\Views\Twig;


final class CookieController
{
    private Twig $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }
}