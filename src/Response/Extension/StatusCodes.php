<?php

namespace Zazalt\Coniunctum\Response\Extension;

class StatusCodes
{
    protected function getStatusCodeAsText($statusCode)
    {
        switch($statusCode) {
            case 100:
                return 'Continue';
            case 200:
                return 'OK';
        }
    }
}