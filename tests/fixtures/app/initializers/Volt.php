<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 * @homepage http://cmf.vegas
 */

namespace App\Initializer;

use App\View\Extension\ToStringFilter;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Vegas\Mvc\Application\InitializerInterface;

class Volt implements InitializerInterface
{

    /**
     * @param \Phalcon\DiInterface $di
     * @return mixed
     */
    public function initialize(\Phalcon\DiInterface $di)
    {
        /** @var \Phalcon\Config $config */
        $config = $di->get('config');
        $viewConfig = isset($config->application->view) ? $config->application->view->toArray() : [];

        if ($di->has('view')) {
            /** @var \Phalcon\Mvc\View $view */
            $view = $di->get('view');

            $viewEngines = $view->getRegisteredEngines();
            if (!$viewEngines) {
                $viewEngines = [];
            }

            $viewEngines['.volt'] = function ($ctx, $di) use ($viewConfig) {
                $volt = new VoltEngine($ctx, $di);
                $volt->setOptions($viewConfig);

                $volt->getCompiler()->addFilter('toString', (new ToStringFilter())->getFilter());
                return $volt;
            };

            $view->registerEngines($viewEngines);
        }
    }
}