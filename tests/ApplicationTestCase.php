<?php
/**
 * This file is part of Vegas package
 *
 * @author Radosław Fąfara <radek@amsterdamstandard.com>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage http://cmf.vegas
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vegas\Tests;


/**
 * Class ApplicationTestCase
 * Allows to use /fixtures directory resources by autoloading & bootstrapping the application
 * @package Vegas\Tests
 */
abstract class ApplicationTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Vegas\Mvc\Application
     */
    private static $application;

    /**
     * @var \Vegas\Mvc\Application
     */
    protected $app;

    /**
     * @var \Phalcon\Config
     */
    protected $config;

    /**
     * @var \Phalcon\DiInterface
     */
    protected $di;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        $di = new \Phalcon\DI\FactoryDefault();
        $config = new \Phalcon\Config(require APP_ROOT . '/app/config/config.php');

        self::$application = new \Vegas\Mvc\Application($di, $config);
        self::$application->bootstrap();
    }

    public function setUp()
    {
        parent::setUp();

        $this->app = self::$application;
        $this->di = $this->app->getDI();
        $this->config = $this->app->getConfig();
    }

}