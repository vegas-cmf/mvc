<?php
use Vegas\Tests\Mvc\Router\TestAfterPlugin;
use Vegas\Tests\Mvc\Router\TestPlugin;

$router->add('/test', [
    'module' => 'Test',
    'controller' => 'Frontend\Index',
    'action' => 'index'
])
    ->pushFilter(
        new TestPlugin()
    )
    ->pushFilter(new TestAfterPlugin())
    ->beforeMatch(function($uri, $route) {
        echo "BeforeMatch!";
        return true;
    });
