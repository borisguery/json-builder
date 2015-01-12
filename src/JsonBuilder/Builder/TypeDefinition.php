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

    public function __construct($optionalKey)
    {
        $this->key = $optionalKey;
    }

    /**
     * @return JsonTypeBuilder
     */
    public function end()
    {
        return $this->parent;
    }

    public function setParent(ParentInterface $parent)
    {
        $this->parent = $parent;

        return $this;
    }

    abstract public function createType();
}
