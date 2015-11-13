<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 * @homepage http://cmf.vegas
 */

namespace Vegas\Mvc\Application\EventListener;

use Phalcon\Events\Event;
use Phalcon\Loader;
use Vegas\Mvc\Application;
use Vegas\Mvc\Application\BootEventListenerInterface;

/**
 * Class Boot
 * @package Vegas\Mvc\Application\EventListener
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
        $config = $application->getConfig();
        if (isset($config->application->initializers)) {
            foreach ($config->application->initializers as $initializer) {
                $reflection = new \ReflectionClass($initializer);
                $initializerInstance = $reflection->newInstance();
                if ($initializerInstance instanceof Application\InitializerInterface) {
                    $initializerInstance->initialize($application->getDI());
                }
            }
        }
    }
}