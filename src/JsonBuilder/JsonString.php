<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace JsonBuilder;

class JsonString implements JsonType
{
    private $value;

    public function __construct($string)
    {
        $this->value = $string;
    }

    public function toJson()
    {
        return json_encode($this->value);
    }
}
