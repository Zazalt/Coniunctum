<?php

namespace Zazalt\Coniunctum\Response;

class Response extends \Zazalt\Coniunctum\Response\Extension\StatusCodes
{
    private $content;
    private $contentType = 'text/html';
    private $xmlRootName = 'Root';

    public function __construct()
    {
    }

    public function setStatus($statusCode)
    {
        header(trim("HTTP/1.1 {$statusCode} {$this->getStatusCodeAsText($statusCode)}"));
        return $this;
    }

    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public function setContentTypeAsJson()
    {
        $this->contentType = 'application/json';
        header('Content-Type: application/json');
        return $this;
    }

    public function setContentTypeAsXML($xmlRootName = null)
    {
        $this->contentType = 'application/xml';
        $this->xmlRootName = ($xmlRootName ? $xmlRootName : $this->xmlRootName);
        header('Content-Type: application/xml');

        return $this;
    }

    public function send()
    {
        // Json
        if($this->contentType == 'application/json') {
            echo json_encode($this->content);

        // XML
        } else if($this->contentType == 'application/xml') {
            echo \Zazalt\Coniunctum\Extension\Array2XML::createXML($this->xmlRootName, $this->content)->saveXML();

        // Default content
        } else {
            echo $this->content;
        }

        exit(0);
    }
}