<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 * @homepage http://cmf.vegas
 */

namespace Vegas\Mvc\Autoloader\EventListener;

use Phalcon\Events\Event;
use Phalcon\Loader;
use Vegas\Mvc\Application;
use Vegas\Mvc\Application\BootEventListenerInterface;

/**
 * Class Boot
 * @package Vegas\Mvc\Autoloader\EventListener
 */
class Boot implements BootEventListenerInterface
{

    /**
     * @param Event $event
     * @param Application $application
     * @return mixed
     */
    public function boot(Event $event, Application $application)
    {
        $loader = new Loader();

        $namespaces = [];
        foreach ($application->getModules() as $module) {
            $namespaces[$module['name']] = $module['dir'];
        }

        $config = $application->getConfig();
        if (isset($config->application->autoload)) {
            $namespaces = array_merge($namespaces, $config->application->autoload->toArray());
        }

        $loader->registerNamespaces($namespaces);
        $loader->register();
    }
}