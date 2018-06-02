<?php
namespace Test;

use phpGone\Router\Route;

class RouteTest extends \PHPUnit\Framework\TestCase
{
    public static function setUpBeforeClass()
    {
        require_once(__DIR__ . '/../vendor/autoload.php');
    }
    
    public function testUrl()
    {
        $route = new Route('/test', 'Demo\Show', 'doc');
        $this->assertContains('/test', $route->getUrl());
    }

    public function testUnknowController()
    {
        $controller = uniqid() . '\\' . uniqid();
        $this->expectExceptionMessage('La classe du controller \\app\\Controllers\\' .
            $controller . 'est inexistante (Voir fichier de config)');
        new Route('/tests', $controller, 'doc');
    }

    public function testUnknowAction()
    {
        $action = uniqid();
        $this->expectExceptionMessage('L\'action de la route est inaccesible ou inconnue (Voir fichier de config)');
        new Route('/test', 'Demo\Show', $action);
    }

    public function testInvalidUrl()
    {
        $this->expectExceptionMessage('L\'url de la route est invalide (Voir fichier de config)');
        new Route(45456, 'Demo\Show', 'doc');
    }
}
