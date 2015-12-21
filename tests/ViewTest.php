<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 * @homepage http://cmf.vegas
 */

namespace Vegas\Tests;

use Phalcon\DI;
use Phalcon\Loader;
use Phalcon\Mvc\Router\Exception;
use Phalcon\Mvc\View;
use Vegas\Mvc\Router;

class ViewTest extends ApplicationTestCase
{

    public function testShouldRunApp()
    {
        ob_start();
        $response = $this->app->handle('/test-view');
        $responseContent = ob_get_clean();

        $this->assertNotEmpty($response->getContent());
    }

}