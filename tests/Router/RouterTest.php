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
use Phalcon\Mvc\Router\Exception;
use Phalcon\Mvc\View;
use Vegas\Mvc\Router;
use Vegas\Tests\ApplicationTestCase;

class RouterTest extends ApplicationTestCase
{
    public function testShouldRunPluginFilter()
    {
        $mock = $this->getMockForAbstractClass('\Vegas\Mvc\Router\PluginInterface');
        $mock->expects($this->once())
            ->method('beforeMatch')
            ->willReturn(true);

        $mock->expects($this->once())
            ->method('afterMatch')
            ->willReturn(true);

        $router = new Router(false);
        $router->setDI(\Phalcon\Di::getDefault());
        $router->add('/test', [
            'controller' => 'Test',
            'action' => 'index'
        ])->pushFilters([$mock]);


        $router->handle('/test');
    }

    public function testShouldRunPluginEvent()
    {
        $mock = $this->getMockForAbstractClass('\Vegas\Mvc\Router\PluginInterface');
        $mock->expects($this->once())
            ->method('beforeMatch')
            ->willReturn(true);

        $mock->expects($this->once())
            ->method('afterMatch')
            ->willReturn(true);

        $router = new Router(false);
        $router->setDI(\Phalcon\Di::getDefault());
        $router->add('/test', [
            'controller' => 'Test',
            'action' => 'index'
        ])->pushEvents([$mock]);


        $router->handle('/test');
    }

    public function testCreateGroup()
    {
        $router = new Router(false);
        $router->setDI(\Phalcon\Di::getDefault());
        $group = $router->createGroup([
            'module' => 'Test',
            'controller' => 'Index'
        ]);
        $group->setPrefix('vegas/test');

        $this->assertInstanceOf('\Phalcon\DiInterface', $group->getDI());
    }

    public function testCheckRouteFirstPosition()
    {
        $router = new Router(false);
        $router->setDI(\Phalcon\Di::getDefault());
        $router->add('/test', [
            'controller' => 'Test',
            'action' => 'index'
        ], ['GET'], \Phalcon\Mvc\Router::POSITION_FIRST);
    }

    /**
     * @expectedException Exception
     */
    public function testCheckRouteException()
    {
        $router = new Router(false);
        $router->setDI(\Phalcon\Di::getDefault());
        $router->add('/test', [
            'controller' => 'Test',
            'action' => 'index'
        ], ['GET'], 2);
    }
}