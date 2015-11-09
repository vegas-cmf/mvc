<?php

/**
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 */

namespace Vegas\Tests\Mvc\Router;

use Phalcon\DI;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Vegas\Mvc\Router;

class TestPlugin implements Router\PluginInterface {

    public function beforeMatch($uri, \Phalcon\Mvc\Router\Route $route)
    {
        echo 'beforeMatch!';
        return true;
    }

    public function afterMatch($uri, \Phalcon\Mvc\Router\Route $route)
    {
        echo 'afterMatch!';
        return true;
    }
}
class TestAfterPlugin implements Router\PluginInterface {

    public function beforeMatch($uri, \Phalcon\Mvc\Router\Route $route)
    {
        echo 'beforeMatch!';
        return true;
    }

    public function afterMatch($uri, \Phalcon\Mvc\Router\Route $route)
    {
        echo 'afterMatch!';
        return true;
    }
}

class RouterTest extends \PHPUnit_Framework_TestCase
{

    public function testRouteMatching()
    {
        $di = new \Phalcon\DI\FactoryDefault();
        $config = new \Phalcon\Config(require TESTS_ROOT_DIR . '/fixtures/app/config/config.php');

        $app = new \Vegas\Mvc\Application($di, $config);

        $response = $app->handle('/test');
//        echo $response->getContent();
//        $response = $app->handle('/test/ip');
//        echo $response->getContent();
//
        $di->get('Test\Service\Foo', [123])->bar();
    }
}