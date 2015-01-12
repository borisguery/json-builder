<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace JsonBuilder;

class JsonArray implements JsonType
{
    /**
     * @var JsonType[]
     */
    private $array = [];

    public function add($value)
    {
        if (!$value instanceof JsonType) {
            $value = JsonValueTypeFactory::fromPhpType($value);
        }

        $this->array[] = $value;

        return $this;
    }

    public function merge($array)
    {
        if (is_string($array)) {
            $array = new JsonLiteral($array);
        }
        if ($array instanceof JsonLiteral) {
            $array = json_decode($array->toJson(), true);
        }
        if (is_array($array)) {
            $array = JsonValueTypeFactory::fromPhpType($array);
            if (!$array instanceof JsonArray) {
                throw new \InvalidArgumentException(
                    sprintf(
                        "Unable to merge %s with %s, it must be an instance of %s",
                        __CLASS__,
                        get_class($array),
                        __CLASS__
                    )
                );
            }
        }
        if ($array instanceof JsonArray) {
            $this->array = array_merge_recursive($this->array, $array->array);
        } else {
            throw new \InvalidArgumentException('$array must be either an array or a JsonArray instance');
        }
    }

    public function toJson()
    {
        $jsonString = '[';
        foreach ($this->array as $value) {
            $jsonString .= sprintf('%s,', $value->toJson());
        }

        $jsonString = rtrim($jsonString, ',');
        $jsonString .= ']';

        return $jsonString;
    }
}
