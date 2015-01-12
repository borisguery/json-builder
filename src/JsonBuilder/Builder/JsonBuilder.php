<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace JsonBuilder\Builder;

use JsonBuilder\JsonType;

class JsonBuilder implements ParentInterface
{
    protected $builder;
    /**
     * @var ComplexTypeDefinition
     */
    public $root;

    public function __construct()
    {
    }

    public function root($rootType)
    {
        $builder = new JsonTypeBuilder();
        $this->root = $builder->type($rootType)->setParent($this);

        return $this->root;
    }

    /**
     * @return JsonType
     */
    public function build()
    {
        return $this->root->createType();
    }
}
