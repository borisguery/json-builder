<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace JsonBuilder\Builder;

use JsonBuilder\JsonNumber;

class NumberTypeDefinition extends ScalarTypeDefinition
{
    private $value;

    public function value($value)
    {
        $this->value = $value;

        return $this;
    }

    public function createType()
    {
        return new JsonNumber($this->value);
    }
}
