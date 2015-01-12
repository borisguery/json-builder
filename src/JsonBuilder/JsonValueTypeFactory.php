<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace JsonBuilder;

class JsonValueTypeFactory
{
    static public function fromPhpType($phpValue)
    {
        if (is_numeric($phpValue)) {

            return new JsonNumber($phpValue);
        }

        if (is_string($phpValue)) {

            return new JsonString($phpValue);
        }

        if (is_array($phpValue)) {
            if (0 !== key($phpValue)) {
                $type = new JsonObject();
                foreach ($phpValue as $key => $value) {
                    $type->add($key, self::fromPhpType($value));
                }
            } else {
                $type = new JsonArray();
                foreach ($phpValue as $key => $value) {
                    $type->add(self::fromPhpType($value));
                }
            }

            return $type;
        }

        if (is_null($phpValue)) {

            return new JsonNull();
        }

        if (is_bool($phpValue)) {

            return new JsonBoolean($phpValue);
        }

        throw new \InvalidArgumentException('Unknown value type');
    }
}
