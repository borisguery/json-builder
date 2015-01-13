<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace JsonBuilder;

use JsonBuilder\Builder\JsonBuilder;

class JsonBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildASimpleJsonObject()
    {
        $object = new JsonObject();
        $json = $object->add('Foo', 'Bar')->add('Bar', 'Baz')->toJson();

        $expectedJson = <<<JSON
{"Foo": "Bar", "Bar": "Baz"}
JSON;

        $this->assertJsonAreIdentical($expectedJson, $json);
    }

    public function testBuildASimpleJsonArray()
    {
        $array = new JsonArray();
        $json = $array->add('Foo')->add('Bar')->toJson();

        $expectedJson =<<<JSON
["Foo", "Bar"]
JSON;

        $this->assertJsonAreIdentical($expectedJson, $json);
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

        $this->assertJsonAreIdentical($expectedJson, $json);
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

        $this->assertJsonAreIdentical($expectedJson, $json);
    }

    public function testBuildAComplexObjectWithMixedTypes()
    {
        $object = new JsonObject();
        $object
            ->add(
                "user",
                (new JsonObject())
                    ->add("id", 1)
                    ->add("nickname", "Boris")
                    ->add(
                        "roles",
                        (new JsonArray())
                            ->add("member")
                            ->add("admin")
                    )
            )
            ->add("groups",
                (new JsonObject())
                    ->add(
                        23,
                        (new JsonObject())
                            ->add("name", "Operators")
                    )
            )
            ->add("reference", "1234")
            ->add(
                "friends",
                (new JsonArray())
                    ->add(1)
                    ->add("2")
                    ->add(3)
            )
        ;

        $json = $object->toJson();

        $expectedJson = <<<JSON
{
    "user": {
        "id": 1,
        "nickname": "Boris",
        "roles": ["member", "admin"]
    },
    "groups": {
        "23": { "name": "Operators" }
    },
    "reference": "1234",
    "friends": [1, "2", 3]
}
JSON;

        $this->assertJsonAreIdentical($expectedJson, $json);
    }

    public function testBuildASimpleString()
    {
        $string = new JsonString("Foobar");
        $json = $string->toJson();

        $expectedJson = <<<JSON
"Foobar"
JSON;

        $this->assertJsonAreIdentical($expectedJson, $json);
    }

    public function testBuildASimpleNumber()
    {
        $string = new JsonNumber(3.14);
        $json = $string->toJson();

        $expectedJson = <<<JSON
3.14
JSON;

        $this->assertJsonAreIdentical($expectedJson, $json);
    }

    public function testBuildNullValue()
    {
        $string = new JsonNull();
        $json = $string->toJson();

        $expectedJson = <<<JSON
null
JSON;

        $this->assertJsonAreIdentical($expectedJson, $json);
    }

    public function testJsonObjectMergeWithAnArray()
    {
        $object = new JsonObject();
        $object
            ->add('Foo', 'Bar')
            ->add('Bar', 'Baz');

        $object->merge(["Far" => "Boo"]);

        $json = $object->toJson();

        $expectedJson = <<<JSON
{"Foo": "Bar", "Bar": "Baz", "Far": "Boo"}
JSON;

        $this->assertJsonAreIdentical($expectedJson, $json);
    }

    public function testJsonObjectMergeWithAnotherJsonObject()
    {
        $object = new JsonObject();
        $object
            ->add('Foo', 'Bar')
            ->add('Bar', 'Baz');

        $object2 = new JsonObject();
        $object2
            ->add('Far', 'Boo')
        ;

        $object->merge($object2);

        $json = $object->toJson();

        $expectedJson = <<<JSON
{"Foo": "Bar", "Bar": "Baz", "Far": "Boo"}
JSON;

        $this->assertJsonAreIdentical($expectedJson, $json);
    }

    public function testJsonArrayMergeWithAnArray()
    {
        $array = new JsonArray();
        $array
            ->add("Boris")
            ->add("John")
        ;

        $array->merge(["Jane", "Jack"]);

        $json = $array->toJson();

        $expectedJson = <<<JSON
["Boris", "John", "Jane", "Jack"]
JSON;

        $this->assertJsonAreIdentical($expectedJson, $json);
    }

    public function testJsonArrayMergeWithAnotherJsonArray()
    {
        $array = new JsonArray();
        $array
            ->add("Boris")
            ->add("John")
        ;

        $array2 = new JsonArray();
        $array2
            ->add("Jane")
            ->add("Jack")
        ;

        $array->merge($array2);

        $json = $array->toJson();

        $expectedJson = <<<JSON
["Boris", "John", "Jane", "Jack"]
JSON;

        $this->assertJsonAreIdentical($expectedJson, $json);
    }

    public function testJsonLiteral()
    {
        $literal = new JsonLiteral('{"name": "Boris Guéry", "data": [1, 2, null, 4]}');
        $json = $literal->toJson();

        $expectedJson = <<<JSON
{"name": "Boris Guéry", "data": [1, 2, null, 4]}
JSON;

        $this->assertJsonAreIdentical($expectedJson, $json);
    }

    public function testJsonLiteralThrowsInvalidArgumentExceptionWhenInvalidJsonIsProvided()
    {
        $this->setExpectedException('\InvalidArgumentException');
        new JsonLiteral('["this": "is", "not", "a": {"valid json string"}]');
    }

    public function testMergeJsonObjectWithAJsonLiteral()
    {
        $object = new JsonObject();
        $object
            ->add('Foo', 'Bar')
            ->add('Bar', 'Baz');

        $object->merge('{"name": "Boris Guéry", "data": [1, 2, null, 4]}');

        $json = $object->toJson();

        $expectedJson = <<<JSON
{"Foo": "Bar", "Bar": "Baz", "name": "Boris Guéry", "data": [1, 2, null, 4]}
JSON;

        $this->assertJsonAreIdentical($expectedJson, $json);
    }

    public function testMergeJsonArrayWithAJsonLiteral()
    {
        $object = new JsonArray();
        $object
            ->add('Foo')
            ->add('Bar')
        ;

        $object->merge('["Baz", "Far"]');

        $json = $object->toJson();

        $expectedJson = <<<JSON
["Foo", "Bar", "Baz", "Far"]
JSON;

        $this->assertJsonAreIdentical($expectedJson, $json);
    }

    public function testMergeJsonArrayWithAJsonLiteralContainingAnObject()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $object = new JsonArray();
        $object
            ->add('Foo')
            ->add('Bar')
        ;

        $object->merge('{"Foo": "Bar"}');
    }


    public function testMergeJsonObjectWithAJsonLiteralContainingAnArray()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $object = new JsonObject();
        $object
            ->add('Foo', 'Bar')
            ->add('Bar', 'Foo')
        ;

        $object->merge('["Bli", "Blou", "Bla"]');
    }

    public function testJsonBoolean()
    {
        $boolean = new JsonBoolean(false);
        $json = $boolean->toJson();

        $expectedJson = <<<JSON
false
JSON;

        $this->assertJsonAreIdentical($expectedJson, $json);
    }

    public function testJsonBuilder()
    {
        $builder = new JsonBuilder();
        $root = $builder->root('array');

        $root
            ->children()
                ->number()
                    ->value(3.14)
                ->end()
                ->boolean()
                    ->true()
                ->end()
                ->boolean()
                    ->false()
                ->end()
                ->string()
                    ->value("Foobar")
                ->end()
                ->null()
                ->end()
                ->arr()
                    ->children()
                        ->number()
                            ->value(3.14)
                        ->end()
                        ->boolean()
                            ->true()
                        ->end()
                        ->boolean()
                            ->false()
                        ->end()
                        ->string()
                            ->value("Foobar")
                        ->end()
                        ->null()
                        ->end()
                        ->object()
                            ->children()
                                ->string()
                                    ->key('foo')
                                    ->value('bar')
                                ->end()
                                ->number()
                                    ->key('bar')
                                    ->value(123)
                                ->end()
                                ->literal()
                                    ->key('literal')
                                    ->value('[1, 2, 3]')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        $json = $builder->build()->toJson();

        $expectedJson = <<<JSON
[
    3.14,
    true,
    false,
    "Foobar",
    null,
    [
        3.14,
        true,
        false,
        "Foobar",
        null,
        {
            "foo": "bar",
            "bar": 123,
            "literal": [1, 2, 3]
        }
    ]
]
JSON;

        $this->assertJsonAreIdentical($expectedJson, $json);
    }

    private function assertJsonAreIdentical($expected, $actual)
    {
        @json_decode($actual);
        $this->assertFalse((bool) json_last_error(), json_last_error_msg());
        $this->assertSame(
            json_decode($expected, true),
            json_decode($actual, true)
        );
    }
}
