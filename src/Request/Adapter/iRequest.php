<?php

namespace Zazalt\Coniunctum\Request\Adapter;

interface iRequest
{
    public function isThisMethod();
    public function getData();
}