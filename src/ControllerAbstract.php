<?php
/**
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 */

namespace Vegas\Mvc;

abstract class ControllerAbstract extends \Phalcon\Mvc\Controller
{
    /**
     * Renders JSON response
     * Disables view
     *
     * @param array|\Phalcon\Http\ResponseInterface $data
     * @return null|\Phalcon\Http\ResponseInterface
     */
    protected function jsonResponse($data = array())
    {
        $this->view->disable();
        $this->response->setContentType('application/json', 'UTF-8');

        return $this->response->setJsonContent($data);
    }
}