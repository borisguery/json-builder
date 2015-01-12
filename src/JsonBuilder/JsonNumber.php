<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace JsonBuilder;


class JsonNumber implements JsonType
{
    private $value;

    public function __construct($number)
    {
        $this->value = $number;
    }

    public function toJson()
    {
        return json_encode($this->value);
    }
}
