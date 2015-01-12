<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace JsonBuilder\Builder;

use JsonBuilder\JsonObject;

class ObjectTypeDefinition extends ComplexTypeDefinition
{
    public function createType()
    {
        $type = new JsonObject();
        foreach ($this->children as $key => $value) {
            $type->add($key, $value->createType());
        }

        return $type;
    }

    public function append(TypeDefinition $definition)
    {
        $definition->setParent($this);
        $this->children[$definition->key] = $definition;

        return $this;
    }
}
