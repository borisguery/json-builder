<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace JsonBuilder\Builder;

use JsonBuilder\JsonArray;

class ArrayTypeDefinition extends ComplexTypeDefinition
{
    public function createType()
    {
        $type = new JsonArray();
        foreach ($this->children as $value)
        {
            $type->add($value->createType());
        }

        return $type;
    }
}
