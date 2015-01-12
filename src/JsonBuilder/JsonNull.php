<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace JsonBuilder;

class JsonNull implements JsonType
{
    public function toJson()
    {
        return json_encode(null);
    }
}
