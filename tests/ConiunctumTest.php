<?php

namespace Zazalt\Coniunctum\Tests;

use Zazalt\Coniunctum\Coniunctum;

class ConiunctumTest extends \Zazalt\Coniunctum\Tests\ZazaltTest
{
    protected $that;

    public function __construct()
    {
        parent::loader(Coniunctum::class);
    }

    public function testGet()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_GET = [
            'firstParam' => 'lorem'
        ];

        $Coniunctum = new \Zazalt\Coniunctum\Coniunctum();
        foreach($_GET as $param => $value) {
            $this->assertEquals($value, $Coniunctum->request->fromGet()[$param]);
        }
    }
}