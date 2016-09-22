<?php

namespace Zazalt\Coniunctum\Request\Adapter;

class Delete implements \Zazalt\Coniunctum\Request\Adapter\iRequest
{
    private $method = 'DELETE';
    private $data   = [];

    public function __construct()
    {
        $this->data = [];
    }

    public function isThisMethod()
    {
        return ($_SERVER['REQUEST_METHOD'] == $this->method);
    }

    /**
     * Return the entire data from collection ($_GET)
     *
     * @return  array
     */
    public function getData()
    {
        return $this->data;
    }
}