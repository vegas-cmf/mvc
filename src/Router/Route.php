<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 * @homepage http://cmf.vegas
 */

namespace Vegas\Mvc\Router;

/**
 * Class Route
 * @package Vegas\Mvc\Router
 */
class Route extends \Phalcon\Mvc\Router\Route
{
    use PluginCollectorTrait;
}