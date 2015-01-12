<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace JsonBuilder\Builder;

use JsonBuilder\JsonBoolean;

class BooleanTypeDefinition extends ScalarTypeDefinition
{
    private $value;

    public function true()
    {
        $this->value = true;

        return $this;
    }

    public function false()
    {
        $this->value = false;

        return $this;
    }

    public function createType()
    {
        return new JsonBoolean($this->value);
    }
}
