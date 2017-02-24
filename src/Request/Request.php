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

    public function isPost(): bool
    {
        return ($this->post && $this->post->isThisMethod());
    }

    public function isPatch(): bool
    {
        return ($this->patch && $this->patch->isThisMethod());
    }

    public function isPut(): bool
    {
        return ($this->put && $this->put->isThisMethod());
    }

    public function isDelete(): bool
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

    /** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *  **/

    public function getFile(string $url)
    {
        $curl = curl_init();
        curl_setopt ($curl, CURLOPT_URL, $url);
        curl_setopt ($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }

    public function request(string $url, string $method, array $headers, array $data)
    {
        $httpRequest = curl_init();

        curl_setopt($httpRequest, CURLOPT_RETURNTRANSFER, 1);

        if(count($headers) > 0) {
            curl_setopt($httpRequest, CURLOPT_HTTPHEADER, array("Content-Type:  text/xml"));
        }

        if(strtoupper($method) == 'POST') {
            curl_setopt($httpRequest, CURLOPT_POST, 1);
            if(count($data) > 0) {
                curl_setopt($httpRequest, CURLOPT_POSTFIELDS, http_build_query($data));
            }
        }

        curl_setopt($httpRequest, CURLOPT_HEADER, 1);

        curl_setopt($httpRequest, CURLOPT_URL, $url);

        $response = curl_exec($httpRequest);

        curl_close($httpRequest);

        return $response;
    }

    /**
     * Return the request URL
     *
     * @param	boolean	$urlEncode
     * @param	boolean	$base64encode
     * @return	string
     */
    public function url(bool $urlEncode = false, bool $base64encode = false, $webRoot = null)
    {
        if($webRoot) {
            $whereIAm = $webRoot . $_SERVER['REQUEST_URI'];

        } else {
            $port = (($_SERVER['SERVER_PORT'] != 80) ? ':'.$_SERVER['SERVER_PORT'] : '');

            // If no HTTPS
            if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == '' || $_SERVER['HTTPS'] == 'off') {
                $whereIAm = 'http://'. $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];

                // If HTTPS
            } else {
                $whereIAm = 'https://'. $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];
            }
        }


        if($urlEncode) {
            $whereIAm = urlencode($whereIAm);
        }

        if($base64encode) {
            $whereIAm = base64_encode($whereIAm);
        }

        return $whereIAm;
    }
}