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
        if (is_string($number)) {
            // Check if it is a float in a string
            if ($number === (string)(float) $number) {
                $number = (float) $number;
            } else {
                $number = (int) $number;
            }
        }

        $this->value = $number;
    }

    public function toJson()
    {
        return json_encode($this->value);
    }
}
