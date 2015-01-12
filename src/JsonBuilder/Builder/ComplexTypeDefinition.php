<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace JsonBuilder\Builder;

abstract class ComplexTypeDefinition extends TypeDefinition
{
    /**
     * @var JsonTypeBuilder
     */
    protected $builder;

    /**
     * @var TypeDefinition[]
     */
    protected $children = [];

    /**
     * @return JsonTypeBuilder
     */
    public function children()
    {
        if (null === $this->builder) {
            $this->builder = new JsonTypeBuilder();
        }

        return $this->builder->setParent($this);
    }

    public function append(TypeDefinition $definition)
    {
        $definition->setParent($this);
        $this->children[] = $definition;

        return $this;
    }

    public function setBuilder($builder)
    {
        $this->builder = $builder;
    }
}
