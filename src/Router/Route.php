<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 * @homepage http://cmf.vegas
 */

namespace Vegas\Mvc\Router;

use Phalcon\Di\InjectionAwareInterface;
use Vegas\Di\InjectionAwareTrait;

/**
 * Class Route
 * @package Vegas\Mvc\Router
 */
class Route extends \Phalcon\Mvc\Router\Route implements InjectionAwareInterface
{
    use InjectionAwareTrait;

    use PluginCollectorTrait;
}