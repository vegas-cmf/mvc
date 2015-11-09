<?php
/**
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 */

namespace Vegas\Mvc\ModuleManager\EventListener;

use Phalcon\Events\Event;
use Vegas\Mvc\Application;
use Vegas\Mvc\Application\BootEventListenerInterface;
use Vegas\Mvc\ModuleManager;

class Boot implements BootEventListenerInterface
{

    /**
     * @param Event $event
     * @param Application $application
     * @return mixed
     */
    public function boot(Event $event, Application $application)
    {
        $moduleManager = new ModuleManager($application);
        $moduleManager->setModulesDirectory($application->getConfig()->application->modulesDirectory);

        $modules = $application->getConfig()->application->modules;
        $moduleManager->registerModules($modules ? $modules->toArray() : []);

        // Setup configs
        $application->getConfig()->merge($moduleManager->getConfigs($application->getModules()));
    }
}