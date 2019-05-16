<?php

namespace tests\TestClass;

use GuzzleHttp\Psr7\Response;

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
        } else {
            return new Response('200', [], $testname . ' shit');
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
}
