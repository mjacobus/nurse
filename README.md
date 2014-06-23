# Nurse

Very simple Dependency Injection Container for PHP

[![Build Status](https://travis-ci.org/mjacobus/nurse.png?branch=master)](https://travis-ci.org/mjacobus/nurse)
[![Coverage Status](https://coveralls.io/repos/mjacobus/nurse/badge.png)](https://coveralls.io/r/mjacobus/nurse)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mjacobus/nurse/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/mjacobus/nurse/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/nurse/di/v/stable.svg)](https://packagist.org/packages/nurse/di)
[![Total Downloads](https://poser.pugx.org/nurse/di/downloads.svg)](https://packagist.org/packages/nurse/di)
[![Latest Unstable Version](https://poser.pugx.org/nurse/di/v/unstable.svg)](https://packagist.org/packages/nurse/di)
[![License](https://poser.pugx.org/nurse/di/license.svg)](https://packagist.org/packages/nurse/di)

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
$container->set('connection', function ($container) {
    return new Connection();
});

$connection = $container->get('connection');


// or you can use the singleton instance of the container

Nurse\Di::set('connection', function ($container) {
    return new Connection();
});

$connection = Nurse\Di::set('connection');
```

## Contributing

Only TDD code will be accepted. Please follow the [PSR-2 code standard](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md).

1. Fork it
2. Create your feature branch (`git checkout -b my-new-feature`)
3. Commit your changes (`git commit -am 'Add some feature'`)
4. Push to the branch (`git push origin my-new-feature`)
5. Create new Pull Request

### How to run the tests:

```bash
phpunit --configuration tests/phpunit.xml
```

### To check the code standard run:

```bash
phpcs --standard=PSR2 lib
phpcs --standard=PSR2 tests

# alternatively

./bin/travis/run_phpcs.sh
```

## Lincense
[MIT](MIT-LICENSE)

## Authors

- [Marcelo Jacobus](https://github.com/mjacobus)
