<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace JsonBuilder\Builder;

use JsonBuilder\JsonString;

class StringTypeDefinition extends ScalarTypeDefinition
{
    private $value;

    public function value($string)
    {
        $this->value = $string;

        return $this;
    }

    public function createType()
    {
        return new JsonString($this->value);
    }
}
