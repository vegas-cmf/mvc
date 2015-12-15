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
        ])->pushFilter($mock);


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
        ])->pushEvent($mock);


        $router->handle('/test');
    }
}