<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace JsonBuilder;

class JsonLiteral implements JsonType
{
    private $jsonString;

    public function __construct($jsonString, $check = true)
    {
        if ($check && false !== @json_decode($jsonString) && (bool) json_last_error()) {

            throw new \InvalidArgumentException(sprintf("Invalid JSON provided: %s", json_last_error_msg()));
        }

        $this->jsonString = $jsonString;
    }

    public function toJson()
    {
        return $this->jsonString;
    }
}
