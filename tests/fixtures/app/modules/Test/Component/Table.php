<?php
/**
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 */


namespace Test\Component;


class Table extends ComponentAbstract
{
    public function datagrid()
    {
        return $this->render('datagrid');
    }
}