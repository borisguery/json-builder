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
     * @return NumberTypeDefinition
     */
    public function number()
    {
        return $this->type('number');
    }

    /**
     * @return StringTypeDefinition
     */
    public function string()
    {
        return $this->type('string');
    }

    /**
     * @return BooleanTypeDefinition
     */
    public function boolean()
    {
        return $this->type('boolean');
    }

    /**
     * @return NullTypeDefinition
     */
    public function null()
    {
        return $this->type('null');
    }

    /**
     * @return ArrayTypeDefinition
     */
    public function arr()
    {
        return $this->type('array');
    }

    /**
     * @return ObjectTypeDefinition
     */
    public function object()
    {
        return $this->type('object');
    }

    /**
     * @return LiteralTypeDefinition
     */
    public function literal()
    {
        return $this->type('literal');
    }

    public function type($type)
    {
        switch ($type) {
            case 'array':
                $type = new ArrayTypeDefinition();
                break;
            case 'object':
                $type = new ObjectTypeDefinition();
                break;
            case 'bool':
            case 'boolean':
                $type = new BooleanTypeDefinition();
                break;
            case 'number':
                $type = new NumberTypeDefinition();
                break;
            case 'null':
                $type = new NullTypeDefinition();
                break;
            case 'string':
                $type = new StringTypeDefinition();
                break;
            case 'literal':
                $type = new LiteralTypeDefinition();
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
