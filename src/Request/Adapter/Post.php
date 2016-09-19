<?php

namespace Zazalt\Coniunctum\Request\Adapter;

class Post implements \Zazalt\Coniunctum\Request\Adapter\iRequest
{
    private $method = 'POST';
    private $data   = [];

    public function __construct()
    {
        if($_SERVER['HTTP_CONTENT_TYPE'] == 'application/json') {
            $this->data = json_decode(file_get_contents('php://input'), true);
        } else {
            $this->data = $_POST;
        }
    }

    public function isThisMethod()
    {
        return ($_SERVER['REQUEST_METHOD'] == $this->method);
    }

    /**
     * Return the entire data from collection ($_POST or php://input)
     *
     * @return  array
     */
    public function getData()
    {
        return $this->data;
    }
}