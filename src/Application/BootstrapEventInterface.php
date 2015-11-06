<?php
/**
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 */

namespace Vegas\Mvc\Application;

use Phalcon\Events\Event;
use Vegas\Mvc\Application;

/**
 * Interface BootstrapEventInterface
 * @package Vegas\Mvc\Application
 */
interface BootstrapEventInterface
{
    /**
     * @param Event $event
     * @param Application $application
     * @return mixed
     */
    public function onBootstrap(Event $event, Application $application);
}