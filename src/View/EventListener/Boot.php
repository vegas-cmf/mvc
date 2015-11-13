<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 * @homepage http://cmf.vegas
 */

namespace Vegas\Mvc\View\EventListener;

use Phalcon\Events\Event;
use Phalcon\Mvc\View;
use Vegas\Mvc\Application;
use Vegas\Mvc\Application\BootEventListenerInterface;

/**
 * Class Boot
 * @package Vegas\Mvc\View\EventListener
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
        $config = $application->getConfig()->application;

        if (isset($config->view) && $config->view !== false) {
            $view = new View();
            $view->setViewsDir($config->view->viewsDir);
            $view->setLayoutsDir($config->view->layoutsDir);
            $view->setLayout($config->view->layout);
            $application->getDI()->setShared('view', $view);
        }
    }
}