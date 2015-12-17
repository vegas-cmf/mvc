<?php
/**
 * This file is part of Vegas package
 *
 * @author Mateusz Aniolek <mateusz.aniolek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 * @homepage http://cmf.vegas
 */

namespace Vegas\Tests\Mvc\Application;

use Phalcon\DI;
use Phalcon\Events\Event;
use Phalcon\Mvc\View;
use Vegas\Mvc\Application\EventListener\Boot;
use Vegas\Mvc\Router;

class BootTest extends \PHPUnit_Framework_TestCase
{
    protected $app, $di, $config;

    public function setUp()
    {
        parent::setUp();

        $di = new \Phalcon\DI\FactoryDefault();
        $config = new \Phalcon\Config(require APP_ROOT . '/app/config/config.php');

        $application = new \Vegas\Mvc\Application($di, $config);
        $application->bootstrap();

        $this->app = $application;
        $this->di = $this->app->getDI();
        $this->config = $this->app->getConfig();
    }

    public function testBootView()
    {
        /** @var View $view */
        $view = $this->di->get('view');
        $engineList = $view->getRegisteredEngines();

        $this->assertCount(3, $engineList);
    }


}