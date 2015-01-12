<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace JsonBuilder;

class JsonObject implements JsonType
{
    /**
     * @var JsonType[]
     */
    private $object = [];

    public function add($key, $value)
    {
        if (!$value instanceof JsonType) {
            $value = JsonValueTypeFactory::fromPhpType($value);
        }

        $this->object[$key] = $value;

        return $this;
    }

    public function merge($object)
    {
        if (is_array($object)) {
            $object = JsonValueTypeFactory::fromPhpType($object);
        }
        if ($object instanceof JsonObject) {
            $this->object = array_merge_recursive($this->object, $object->object);
        } else {
            throw new \InvalidArgumentException('$array must be either an array or a JsonObject instance');
        }
    }

    public function toJson()
    {
        $jsonString = '{';
        foreach ($this->object as $key => $value) {
            // force string cast as a json object key must always be a string
            $jsonString .= sprintf('%s: %s,', json_encode((string) $key), $value->toJson());
        }

        $jsonString = rtrim($jsonString, ',');
        $jsonString .= '}';

        return $jsonString;
    }
}
