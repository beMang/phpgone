<?php
namespace tests;

use phpGone\Router\Route;

class RouteTest extends \PHPUnit\Framework\TestCase
{
    protected const CONTROLLER_PATH = '\\tests\\TestClass\\Controllers\\TestController';

    public function testUrl()
    {
        $route = new Route('/test', self::CONTROLLER_PATH, 'test');
        $this->assertSTringContainsString('/test', $route->getUrl());
    }

    public function testUnknowController()
    {
        $controller = uniqid() . '\\' . uniqid();
        $this->expectExceptionMessage('La classe du controller ' .
            $controller . ' est inexistante (Voir fichier de config)');
        new Route('/tests', $controller, 'doc');
    }

    public function testUnknowAction()
    {
        $action = uniqid();
        $this->expectExceptionMessage('L\'action de la route est inaccesible ou inconnue (Voir fichier de config)');
        new Route('/test', self::CONTROLLER_PATH, $action);
    }
}
