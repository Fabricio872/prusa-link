<?php

namespace App\Services;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Twig
{
    private static $instance = null;
    private Environment $twig;

    public function __construct()
    {
        $loader     = new FilesystemLoader(__DIR__ . '/../Templates');
        $this->twig = new Environment($loader, [
            'cache' => __DIR__ . '/../../cache',
            'debug' => $_ENV['DEV'],
        ]);
    }

    public static function getInst()
    {
        if (self::$instance == null) {
            self::$instance = new Twig();
        }

        return self::$instance;
    }

    public function getTwig(): Environment
    {
        return $this->twig;
    }
}