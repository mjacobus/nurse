# Nurse

Very simple Dependency Injection Container for PHP

Code information:

[![Build Status](https://travis-ci.org/mjacobus/nurse.png?branch=master)](https://travis-ci.org/mjacobus/nurse)
[![Coverage Status](https://coveralls.io/repos/mjacobus/nurse/badge.png?branch=master)](https://coveralls.io/r/mjacobus/nurse?branch=master)
[![Code Climate](https://codeclimate.com/github/mjacobus/nurse.png)](https://codeclimate.com/github/mjacobus/nurse)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mjacobus/nurse/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/mjacobus/nurse/?branch=master)

Package information:

[![Latest Stable Version](https://poser.pugx.org/nurse/di/v/stable.svg)](https://packagist.org/packages/nurse/di)
[![Total Downloads](https://poser.pugx.org/nurse/di/downloads.svg)](https://packagist.org/packages/nurse/di)
[![Latest Unstable Version](https://poser.pugx.org/nurse/di/v/unstable.svg)](https://packagist.org/packages/nurse/di)
[![License](https://poser.pugx.org/nurse/di/license.svg)](https://packagist.org/packages/nurse/di)
[![Dependency Status](https://gemnasium.com/mjacobus/Nurse.png)](https://gemnasium.com/mjacobus/Nurse)

## Installing

### Installing via Composer
Append the lib to your requirements key in your composer.json.

```javascript
{
    // composer.json
    // [..]
    require: {
        // append this line to your requirements
        "nurse/di": "dev-master"
    }
}
```

### Alternative install
- Learn [composer](https://getcomposer.org). You should not be looking for an alternative install. It is worth the time. Trust me ;-)
- Follow [this set of instructions](#installing-via-composer)

## Issues/Features proposals

[Here](https://github.com/mjacobus/nurse/issues) is the issue tracker.

## Usage

Defining a dependency:

```php
$container = new Nurse\Container;

// Defining a dependency

$container->set('connection', function ($container) {
    $params = $container->get('connection_params');
    return new Connection($params);
})
->set('connection_params', function () {
    return array(
        'schema'   => 'someschema',
        'username' => 'root',
        'password' => 's3cr3t',
    );
});

// Retrieving the dependency (lazy loading)
$connection = $container->get('connection');

// alternatively you can use the singleton instance of the container

Nurse\Di::set('connection', function ($container) {
    $params = $container->get('connection_params');
    return new Connection($params);
})
->set('connection_params', function () {
    return array(
        'schema'   => 'someschema',
        'username' => 'root',
        'password' => 's3cr3t',
    );
});

$connection = Nurse\Di::get('connection');
```

## Contributing

Please refer to the [contribuiting guide](https://github.com/mjacobus/nurse/blob/master/CONTRIBUTING.md).


## Lincense
[MIT](MIT-LICENSE)

## Authors

- [Marcelo Jacobus](https://github.com/mjacobus)
- [Maicon Pinto](https://github.com/maiconpinto)
- Anthonny Machado
- Emerson Engroff
- Daniel Caña
- Elisandro Nabienger


