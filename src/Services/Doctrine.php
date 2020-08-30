<?php

namespace App\Services;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\PDOMySql\Driver;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class Doctrine
{
    private static $instance = null;
    private EntityManager $em;

    private function __construct()
    {
        include_once __DIR__ . '/../../../../../wp-config.php';

        $proxyDir                  = null;
        $cache                     = null;
        $useSimpleAnnotationReader = false;
        $config                    = Setup::createAnnotationMetadataConfiguration([__DIR__ . "/../Entity"],
            $_ENV['DEV'],
            $proxyDir, $cache, $useSimpleAnnotationReader);

        $driver = new Driver();
        $conn   = new Connection([
            'driver'   => 'mysql',
            'user'     => DB_USER,
            'password' => DB_PASSWORD,
            'host'     => DB_HOST,
            'port'     => 3306,
            'dbname'   => DB_NAME,
        ], $driver);

        $this->em = EntityManager::create($conn, $config);
    }

    public static function getInst()
    {
        if (self::$instance == null) {
            self::$instance = new Doctrine();
        }

        return self::$instance;
    }

    public function getEm(): EntityManager
    {
        return $this->em;
    }
}