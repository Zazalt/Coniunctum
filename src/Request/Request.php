<?php

namespace Zazalt\Coniunctum\Request;

class Request
{
    public $get     = null;
    public $post    = null;
    public $put     = null;
    public $patch   = null;
    public $delete  = null;

    //$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));

    public function __construct()
    {

        $method = (isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : getenv('REQUEST_METHOD'));

        switch($method) {
            case 'GET':
                $this->get = new \Zazalt\Coniunctum\Request\Adapter\Get();
                break;
            case 'POST':
                $this->post = new \Zazalt\Coniunctum\Request\Adapter\Post();
                break;
        }
    }

    public function fromData()
    {

        if($this->isGet()) {
            return $this->get->getData();

        } else if($this->isPost()) {
            return $this->post->getData();
        }
    }

    /** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  **/
    /** GET **/

    public function fromGet()
    {
        return $this->get->getData();
    }

    public function isGet()
    {
        return ($this->get && $this->get->isThisMethod());
    }

    public function isPost()
    {
        return ($this->post && $this->post->isThisMethod());
    }

    public function isPut()
    {

    }

    public function isPatch()
    {

    }

    public function isDelete()
    {

    }
}