<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace JsonBuilder;

class JsonBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildASimpleJsonObject()
    {
        $object = new JsonObject();
        $json = $object->add('Foo', 'Bar')->add('Bar', 'Baz')->toJson();

        $expectedJson = <<<JSON
{"Foo": "Bar", "Bar": "Baz"}
JSON;

        $this->assertEquals(
            json_decode($expectedJson, true),
            json_decode($json, true)
        );
    }

    public function testBuildASimpleJsonArray()
    {
        $array = new JsonArray();
        $json = $array->add('Foo')->add('Bar')->toJson();

        $expectedJson =<<<JSON
["Foo", "Bar"]
JSON;

        $this->assertEquals(
            json_decode($expectedJson, true),
            json_decode($json, true)
        );
    }

    public function testBuildAnArrayOfObject()
    {
        $array = new JsonArray();
        $object1 = new JsonObject();
        $object1
            ->add('firstname', 'Boris')
            ->add('lastname', 'Guéry')
        ;
        $object2 = new JsonObject();
        $object2
            ->add('firstname', 'John')
            ->add('lastname', 'Doe')
        ;

        $json = $array
            ->add($object1)
            ->add($object2)
        ->toJson();

        $expectedJson = <<<JSON
[{"firstname": "Boris", "lastname": "Guéry"}, {"firstname": "John", "lastname": "Doe"}]
JSON;

        $this->assertEquals(
            json_decode($expectedJson, true),
            json_decode($json, true)
        );
    }

    public function testBuildAnObjectOfArray()
    {
        $object = new JsonObject();
        $object->add('user1', (new JsonArray())->add(1)->add("Boris")->add("Guéry"));
        $object->add('user2', (new JsonArray())->add(2)->add("John")->add("Doe"));
        $object->add('user3', (new JsonArray())->add(3)->add("Jane")->add("Doe"));

        $json = $object->toJson();

        $expectedJson = <<<JSON
{"user1": [1, "Boris", "Guéry"], "user2": [2, "John", "Doe"], "user3": [3, "Jane", "Doe"]}
JSON;

        $this->assertEquals(
            json_decode($expectedJson, true),
            json_decode($json, true)
        );
    }

    public function testBuildASimpleString()
    {
        $string = new JsonString("Foobar");
        $json = $string->toJson();

        $expectedJson = <<<JSON
"Foobar"
JSON;

        $this->assertEquals(
            json_decode($expectedJson, true),
            json_decode($json)
        );
    }

    public function testBuildASimpleNumber()
    {
        $string = new JsonNumber(3.14);
        $json = $string->toJson();

        $expectedJson = <<<JSON
3.14
JSON;

        $this->assertEquals(
            json_decode($expectedJson, true),
            json_decode($json)
        );
    }

    public function testBuildNullValue()
    {
        $string = new JsonNull();
        $json = $string->toJson();

        $expectedJson = <<<JSON
null
JSON;

        $this->assertEquals(
            json_decode($expectedJson, true),
            json_decode($json)
        );
    }
}
