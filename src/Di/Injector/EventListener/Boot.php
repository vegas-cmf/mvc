<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 * @homepage http://cmf.vegas
 */

namespace Vegas\Mvc\Di\Injector\EventListener;

use Phalcon\Events\Event;
use Vegas\Di\Injector;
use Vegas\Mvc\Application;
use Vegas\Mvc\Application\BootEventListenerInterface;

/**
 * Class Boot
 * @package Vegas\Mvc\Di\Injector\EventListener
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
        if (isset($config->sharedServices)) {
            $injector = new Injector($application->getDI());
            $injector->inject($config->sharedServices->toArray());
        }
    }
}