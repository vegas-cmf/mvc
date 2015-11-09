<?php
/**
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 */

namespace Vegas\Mvc\View\EventListener;

use Phalcon\Events\Event;
use Phalcon\Mvc\View;
use Vegas\Mvc\Application;
use Vegas\Mvc\Application\BootEventListenerInterface;

class Boot implements BootEventListenerInterface
{

    /**
     * @param Event $event
     * @param Application $application
     * @return mixed
     */
    public function boot(Event $event, Application $application)
    {
        $view = new View();
        $view->setViewsDir(APP_ROOT . '/app/');
        $view->setLayoutsDir('layouts/');
        $view->setLayout('main');
        $application->getDI()->setShared('view', $view);
    }
}