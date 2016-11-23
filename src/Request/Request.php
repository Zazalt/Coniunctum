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
            case 'PATCH':
                $this->patch = new \Zazalt\Coniunctum\Request\Adapter\Patch();
                break;
            case 'PUT':
                $this->put = new \Zazalt\Coniunctum\Request\Adapter\Put();
                break;
            case 'DELETE':
                $this->delete = new \Zazalt\Coniunctum\Request\Adapter\Delete();
                break;
        }
    }

    public function fromData()
    {
        if($this->isGet()) {
            return $this->get->getData();

        } else if($this->isPost()) {
            return $this->post->getData();

        } else if($this->isPatch()) {
            return $this->patch->getData();

        } else if($this->isPut()) {
            return $this->put->getData();
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

    public function isPatch()
    {
        return ($this->patch && $this->patch->isThisMethod());
    }

    public function isPut()
    {
        return ($this->put && $this->put->isThisMethod());
    }

    public function isDelete()
    {
        return ($this->delete && $this->delete->isThisMethod());
    }

    public function header($headerName)
    {
        if(isset($_SERVER['HTTP_'. strtoupper($headerName)])) {
            return $_SERVER['HTTP_'. strtoupper($headerName)];
        }

        return null;
    }

    public function getFile($url)
    {
        $curl = curl_init();
        curl_setopt ($curl, CURLOPT_URL, $url);
        curl_setopt ($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
}