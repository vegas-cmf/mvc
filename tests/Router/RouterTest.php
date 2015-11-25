<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 * @homepage http://cmf.vegas
 */

namespace Vegas\Tests\Mvc\Router;

use Phalcon\DI;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Vegas\Mvc\Router;
use Vegas\Tests\ApplicationTestCase;

class TestPlugin implements Router\PluginInterface {

    public function beforeMatch($uri, \Vegas\Mvc\Router\Route $route)
    {
        echo 'beforeMatch!';
        return true;
    }

    public function afterMatch($uri, \Vegas\Mvc\Router\Route $route)
    {
        echo 'afterMatch!';
        return true;
    }
}
class TestAfterPlugin implements Router\PluginInterface {

    public function beforeMatch($uri, \Vegas\Mvc\Router\Route $route)
    {
        echo 'beforeMatch!';
        return true;
    }

    public function afterMatch($uri, \Vegas\Mvc\Router\Route $route)
    {
        echo 'afterMatch!';
        return true;
    }
}

class RouterTest extends ApplicationTestCase
{

    public function testRouteMatching()
    {
        $response = $this->app->handle('/test');
//        echo $response->getContent();
//        $response = $this->app->handle('/test/ip');
//        echo $response->getContent();
//
        $this->di->get('Test\Service\Foo', [123])->bar();
    }
}