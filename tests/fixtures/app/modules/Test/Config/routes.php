<?php
$group = $router->createGroup([
    'module' => 'Test',
]);
$group->pushFilterBefore(new \Test\Filter\IPPlugin());
$group->setPrefix('/test');
$group->add('/ip', [
    'controller' => 'Index',
    'action' => 'ip'
]);

$router->mount($group);