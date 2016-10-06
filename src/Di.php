<?php
/**
 * This file is part of Vegas package
 *
 * @author Mateusz Aniołek <mateusz.aniolek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 * @homepage http://cmf.vegas
 */

namespace Vegas\Mvc;

use Phalcon\DI\FactoryDefault;
use Phalcon\Events\Manager;
use Vegas\Di\Injector;
use Vegas\Mvc\Application;

/**
 * Class Di
 * @package Vegas\Mvc
 */
class Di extends FactoryDefault
{
    public function get($alias, $parameters = null)
    {
        $result = parent::get($alias, $parameters);

        $injector = new \Vegas\Mvc\Di\Manager;
        $injector->setDI($this);
        $injector->inject($result);

        return $result;
    }
}