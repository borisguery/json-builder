<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace JsonBuilder\Builder;

class JsonTypeBuilder implements ParentInterface
{
    /**
     * @var ComplexTypeDefinition
     */
    protected $parent;

    /**
     * @param string $optionalKey
     * @return NumberTypeDefinition
     */
    public function number($optionalKey = null)
    {
        return $this->type('number', $optionalKey);
    }

    /**
     * @param string $optionalKey
     * @return StringTypeDefinition
     */
    public function string($optionalKey = null)
    {
        return $this->type('string', $optionalKey);
    }

    /**
     * @param string $optionalKey
     * @return BooleanTypeDefinition
     */
    public function boolean($optionalKey = null)
    {
        return $this->type('boolean', $optionalKey);
    }

    /**
     * @param string $optionalKey
     * @return NullTypeDefinition
     */
    public function null($optionalKey = null)
    {
        return $this->type('null', $optionalKey);
    }

    /**
     * @param string $optionalKey
     * @return ArrayTypeDefinition
     */
    public function arr($optionalKey = null)
    {
        return $this->type('array', $optionalKey);
    }

    /**
     * @param string $optionalKey
     * @return ObjectTypeDefinition
     */
    public function object($optionalKey = null)
    {
        return $this->type('object', $optionalKey);
    }

    /**
     * @param string $optionalKey
     * @return LiteralTypeDefinition
     */
    public function literal($optionalKey = null)
    {
        return $this->type('literal', $optionalKey);
    }

    public function type($type, $optionalKey = null)
    {
        switch ($type) {
            case 'array':
                $type = new ArrayTypeDefinition($optionalKey);
                break;
            case 'object':
                $type = new ObjectTypeDefinition($optionalKey);
                break;
            case 'bool':
            case 'boolean':
                $type = new BooleanTypeDefinition($optionalKey);
                break;
            case 'number':
                $type = new NumberTypeDefinition($optionalKey);
                break;
            case 'null':
                $type = new NullTypeDefinition($optionalKey);
                break;
            case 'string':
                $type = new StringTypeDefinition($optionalKey);
                break;
            case 'literal':
                $type = new LiteralTypeDefinition($optionalKey);
                break;
        }

        if ($type instanceof ComplexTypeDefinition) {
            $builder = clone $this;
            $builder->setParent(null);
            $type->setBuilder($builder);
        }

        if (null !== $this->parent) {
            $this->parent->append($type);
            $type->setParent($this);
        }

        return $type;
    }

    public function setParent(ComplexTypeDefinition $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return ComplexTypeDefinition
     */
    public function end()
    {
        return $this->parent;
    }
}
