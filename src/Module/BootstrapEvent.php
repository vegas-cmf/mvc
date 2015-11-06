<?php
/**
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 */

namespace Vegas\Mvc\Module;

use Phalcon\Events\Event;
use Vegas\Mvc\Application;
use Vegas\Mvc\Application\BootstrapEventInterface;

class BootstrapEvent implements BootstrapEventInterface
{

    /**
     * @param Event $event
     * @param Application $application
     * @return mixed
     */
    public function onBootstrap(Event $event, Application $application)
    {

    }
}