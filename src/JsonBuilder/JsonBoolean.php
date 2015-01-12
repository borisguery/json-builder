<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace JsonBuilder;

class JsonBoolean implements JsonType
{

    private $boolean;

    public function __construct($bool)
    {
        if (is_string($bool)) {
            "true" === $bool ? true : false;
        }

        $this->boolean = (bool) $bool;
    }

    public function toJson()
    {
        return json_encode($this->boolean);
    }
}
