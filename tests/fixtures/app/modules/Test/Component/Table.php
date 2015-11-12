<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 * @homepage http://cmf.vegas
 */

namespace Test\Component;


class Table extends ComponentAbstract
{
    public function datagrid()
    {
        return $this->render('datagrid');
    }
}