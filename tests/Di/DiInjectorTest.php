<?php
/**
 * This file is part of Vegas package
 *
 * @author Mateusz Aniolek <mateusz.aniolek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 * @homepage http://cmf.vegas
 */

namespace Vegas\Tests\Mvc\Di;

use Lib\LibTestClass;
use Phalcon\DI\FactoryDefault;
use Test\Service\Bar;
use Test\Service\InjectorFoo;
use Test\Service\InjectorPrivate;
use Test\Service\Loop;
use Vegas\Mvc\Di;
use Vegas\Mvc\Router;
use Vegas\Tests\ApplicationTestCase;

use Test\Component\InjectorComponent;

class DiInjectorTest extends ApplicationTestCase
{
    protected $app, $di, $config;

    public static function setUpBeforeClass()
    {
        $config = new \Phalcon\Config(require APP_ROOT . '/app/config/config.php');

        self::$application = new \Vegas\Mvc\Application(new Di(), $config);
        self::$application->bootstrap();
    }

    public function testInjectClass()
    {
        /** @var InjectorComponent $component */
        $component = $this->di->get(InjectorComponent::class);
        $this->assertInstanceOf('Test\\Service\\FakeService', $component->fakeService);

        /** @var InjectorFoo $foo */
        $foo = self::$application->getDI()->get(InjectorFoo::class);
        $this->assertInstanceOf('Test\\Service\\FakeService', $foo->fakeService);

    }

    public function testPrivateInjectClass()
    {
        /** @var InjectorPrivate $component */
        $component = $this->di->get(InjectorPrivate::class);
        $this->assertInstanceOf('Test\\Service\\FakeService', $component->fakeService);

    }

    public function testPreventLoopInjectionClass()
    {
        $component = self::$application->getDI()->get(Loop::class);
    }

    public function testInjectTwoLevel()
    {
        /** @var Bar $bar */
        $bar = self::$application->getDI()->get(Bar::class);
        $this->assertInstanceOf('Test\\Service\\InjectorFoo', $bar->fooService);
        $this->assertInstanceOf('Test\\Service\\FakeService', $bar->fooService->fakeService);
    }

    public function testInjectLibClass()
    {
        /** @var LibTestClass $testLibClass */
        $testLibClass = self::$application->getDI()->get(LibTestClass::class);
        $this->assertInstanceOf('Lib\\InjectableClass', $testLibClass->testService);

        /** @var LibTestClass $testClass */
        $testClass = self::$application->getDI()->get('testService');
        $this->assertInstanceOf('Lib\\InjectableClass', $testClass->testService);

    }


}