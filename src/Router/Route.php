<?php
/**
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
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