<?php
/**
 * This file is part of Vegas package
 *
 * @author Mateusz Aniolek <mateusz.aniolek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 * @homepage http://cmf.vegas
 */

namespace Vegas\Tests\Mvc\Router;

use Phalcon\DI;
use Phalcon\Events\Event;
use Vegas\Mvc\Router;
use Vegas\Mvc\Router\EventListener\Boot;

class BootTest extends \PHPUnit_Framework_TestCase
{
    protected $app, $di, $config;

    public function setUp()
    {
        parent::setUp();

        $di = new \Phalcon\DI\FactoryDefault();
        $config = new \Phalcon\Config(require APP_ROOT . '/app/config/config.php');

        $application = new \Vegas\Mvc\Application($di, $config);

        $this->app = $application;
        $this->di = $this->app->getDI();
        $this->config = $this->app->getConfig();

        $bootInstance = new \Vegas\Mvc\ModuleManager\EventListener\Boot();
        $bootInstance->boot(new Event('test', $this,  [], false), $this->app);

        $bootInstance = new \Vegas\Mvc\Autoloader\EventListener\Boot();
        $bootInstance->boot(new Event('test', $this,  [], false), $this->app);
    }

    public function testBootView()
    {
        $bootInstance = new Boot();
        $bootInstance->boot(new Event('test', $this,  [], false), $this->app);

        $fileList = get_included_files();

        $routesList = [];
        foreach($fileList as $file){
            if(strpos($file, 'tests/fixtures/app/modules/Test/Config/routes.php') != false) {
                $routesList[] = $file;
            }
        }

        $this->assertEquals(1, count($routesList));
        $this->assertTrue($this->app->getDI()->has('router'));
    }


}