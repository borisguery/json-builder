<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace JsonBuilder\Builder;

abstract class TypeDefinition implements ParentInterface
{
    /**
     * @var TypeDefinition
     */
    protected $parent;
    protected $key;

    /**
     * @return JsonTypeBuilder
     */
    public function end()
    {
        return $this->parent;
    }

    public function key($keyForObject)
    {
        $this->key = $keyForObject;

        return $this;
    }

    public function setParent(ParentInterface $parent)
    {
        $this->parent = $parent;

        return $this;
    }

    abstract public function createType();
}
