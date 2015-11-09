<?php
/**
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 */

namespace Test\Controller\Frontend;

use Test\Model\Test;

class IndexController extends \Phalcon\Mvc\Controller
{
    public function indexAction()
    {
        $test = new Test();
    }

    public function ipAction()
    {
        $this->response->setHeader('Content-Type', 'application/json');
        $this->response->setJsonContent(['test' => 1]);
        return $this->response;
    }
}