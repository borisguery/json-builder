<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace JsonBuilder\Builder;

use JsonBuilder\JsonNull;

class NullTypeDefinition extends ScalarTypeDefinition
{
    public function createType()
    {
        return new JsonNull();
    }
}
