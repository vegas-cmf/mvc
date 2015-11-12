<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 * @homepage http://cmf.vegas
 */

namespace Vegas\Mvc\Router\EventListener;

use Phalcon\Events\Event;
use Vegas\Mvc\Application;
use Vegas\Mvc\Application\BootEventListenerInterface;
use Vegas\Mvc\ModuleManager;
use Vegas\Mvc\Router;

class Boot implements BootEventListenerInterface
{

    /**
     * @param Event $event
     * @param Application $application
     * @return mixed
     */
    public function boot(Event $event, Application $application)
    {
        // Initializes router
        $router = new Router(false);
        // default routes
        if (isset($application->getConfig()->application->defaultRoutes)) {
            $defaultRoutesPath = $application->getConfig()->application->defaultRoutes;
            if (file_exists($defaultRoutesPath)) {
                require($defaultRoutesPath);
            }
        }

        // Modules routes
        (new Router\Loader())->autoload($application->getModules(), $router);
        $application->getDI()->setShared('router', $router);
    }
}