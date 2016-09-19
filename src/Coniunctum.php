<?php

namespace Zazalt\Coniunctum;

class Coniunctum
{
   public $request;
   public $response;

   public function __construct()
   {
       $this->request   = new \Zazalt\Coniunctum\Request\Request();
       $this->response  = new \Zazalt\Coniunctum\Response\Response();
   }
}