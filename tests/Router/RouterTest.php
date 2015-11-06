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

        $app = new \Vegas\Mvc\Application();
        $app->setDI($di);
        $app->useImplicitView(true);
        $app->setModulesDirectory('modules/');
        $app->registerModules([
            'Test' => [
                'path' => APP_ROOT . '/app/modules/Test',
                'className' => 'Test\\Module',
                'viewsDir' => 'modules/Test/View'
            ]
        ]);

        $loader = new Loader();

        $loader->registerNamespaces(
            array(
                'Test' => APP_ROOT . '/app/modules/Test'
            )
        );

        $loader->register();


        $view = new View();
        $view->setViewsDir(APP_ROOT . '/app/');
        $view->setLayoutsDir('layouts/');
        $view->setLayout('main');
        $di->setShared('view', $view);

        $di->set('router', function() use ($di) {
            $router = new Router(false);
            $router->setDI($di);


            $router->add('/test', [
                'module' => 'Test',
                'controller' => 'Frontend\Index',
                'action' => 'index'
            ])
                ->pushFilter(
                    new TestPlugin()
                )
                ->pushFilter(new TestAfterPlugin())
                ->beforeMatch(function($uri, $route) {
                    echo "BeforeMatch!";
                    return true;
                });

            require APP_ROOT . '/app/modules/Test/Config/routes.php';

            return $router;
        });

        $response = $app->handle('/test');
        echo $response->getContent();
        $response = $app->handle('/test/ip');
        echo $response->getContent();

        $di->get('Test\Service\Foo', [123])->bar();
    }
}