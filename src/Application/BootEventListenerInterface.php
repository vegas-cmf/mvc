<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 * @homepage http://cmf.vegas
 */

namespace Vegas\Mvc\Application;

use Phalcon\Events\Event;
use Vegas\Mvc\Application;

/**
 * Interface BootstrapEventListenerInterface
 * @package Vegas\Mvc\Application
 */
interface BootEventListenerInterface
{
    /**
     * @param Event $event
     * @param Application $application
     * @return mixed
     */
    public function boot(Event $event, Application $application);
}