# JSON Builder

Allow to build a JSON string programmatically

[![Build Status](https://travis-ci.org/borisguery/json-builder.svg?branch=master)](https://travis-ci.org/borisguery/json-builder)

Table of contents
-----------------

1. [Overview](#overview)
2. [Installation](#installation)
3. [Usage](#usage)
4. [Known limitations](#known-limitations)
5. [Testing](#testing)
6. [Contributing](#contributing)
7. [Authors](#authors)
8. [License](#license)

## Overview

```PHP
<?php

require __DIR__ . '/vendor/autoload.php';

use JsonBuilder\Builder\JsonBuilder;

$jb = new JsonBuilder();
$root = $jb->root('array');
$root
    ->children()
        ->string()
            ->value('Foo')
        ->end()
        ->number()
            ->value(123)
        ->end()
    ->end()
->end();

$json = $jb->build()->toJson();

echo $json;
```

The above code will return
```JSON
["Foo", 123]

```

## Installation

Install the library package with composer:

```bash
$ php composer.phar require borisguery/json-builder
```

## Usage

## Known limitations

## Testing

Install development dependencies

```bash
$ composer install --dev
```

Run the test suite

```bash
$ vendor/bin/phpunit
```

## Contributing

1. Take a look at the [list of issues](http://github.com/borisguery/json-builder/issues).
2. Fork
3. Write a test (for either new feature or bug)
4. Make a PR

## Authors

Boris Guéry - guery.b@gmail.com - http://borisguery.com - [@borisguery](https://twitter.com/borisguery)

## License

This library is under the MIT license - see the LICENSE file for details
