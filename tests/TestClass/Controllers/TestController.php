<?php

namespace tests\TestClass\Controllers;

use bemang\Config;
use phpGone\Helpers\Url;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use bemang\renderer\RendererInterface;

class TestController extends \phpGone\Core\BackController
{
    protected $test;

    public function setUp()
    {
        $this->test = 'test';
    }

    public function test($testname)
    {
        if ($testname == 'error') {
            return $this->error();
        } elseif ($testname == 'redirect') {
            return $this->redirectToRoute('redirect');
        } elseif ($testname == 'redirectfalse') {
            return $this->redirectToRoute('badroute');
        } elseif ($testname == 'render') {
            return $this->render('test.twig', []);
        } elseif ($testname == 'phprender') {
            return $this->render('test', [], 'php');
        } elseif ($testname == 'twigrender') {
            return $this->render('test.twig', [], 'twig');
        } else {
            return new Response('200', [], $testname . ' shit');
        }
    }

    public function parameters(Request $request, Config $config, RendererInterface $render, Url $url)
    {
        if (isset($request) && isset($config) && isset($render) && isset($url)) {
            return new Response('200', [], 'OK');
        } else {
            return new Response('404', [], 'BAD');
        }
    }

    public function redirect()
    {
        return new Response('200', [], 'Redirect');
    }

    public function error404()
    {
        return new Response('404', [], 'Error 404');
    }

    public function index()
    {
        return new Response('200', [], 'home');
    }
}
