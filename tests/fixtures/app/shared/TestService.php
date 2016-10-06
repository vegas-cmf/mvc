<?php
/**
 * This file is part of Vegas package
 *
 * @author Mateusz Aniolek <mateusz.aniolek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 * @homepage http://cmf.vegas
 */

namespace App\Shared;

use Lib\LibTestClass;
use Vegas\Di\Injector\SharedServiceProviderInterface;

class TestService implements SharedServiceProviderInterface
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'testService';
    }

    /**
     * @param \Phalcon\DiInterface $di
     * @return mixed
     */
    public function getProvider(\Phalcon\DiInterface $di)
    {
        return new LibTestClass();
    }
}