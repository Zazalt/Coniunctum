<?php

namespace Zazalt\Coniunctum\Request\Adapter;

class Get implements \Zazalt\Coniunctum\Request\Adapter\iRequest
{
    private $method = 'GET';
    private $data   = [];

    public function __construct()
    {
        $this->data = $_GET;
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