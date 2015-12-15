<?php
use Vegas\Tests\Mvc\Router\TestAfterPlugin;
use Vegas\Tests\Mvc\Router\TestPlugin;
/** @var \Vegas\Mvc\Router $router */
$router->add('/test', [
    'module' => 'Test',
    'controller' => 'Frontend\Index',
    'action' => 'index'
])
    ->pushFilter(
        new \Test\Filter\TestFilter()
    )
    ->beforeMatch(function($uri, $route) {
        echo "BeforeMatch!";
        return true;
    });
