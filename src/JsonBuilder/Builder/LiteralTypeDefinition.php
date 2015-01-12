<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace JsonBuilder\Builder;

use JsonBuilder\JsonLiteral;

class LiteralTypeDefinition extends TypeDefinition
{
    private $value;

    public function value($string)
    {
        $this->value = $string;

        return $this;
    }

    public function createType()
    {
        return new JsonLiteral($this->value, false);
    }
}
