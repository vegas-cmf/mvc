<?php

namespace Lib;

class LibTestClass
{
    /**
     * @var InjectableClass
     * @inject(class=\Lib\InjectableClass)
     */
    public $testService;
}