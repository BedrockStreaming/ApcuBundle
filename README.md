# Bundle APCu [![Build Status](https://github.com/BedrockStreaming/apcuBundle/actions/workflows/ci.yml/badge.svg)](https://github.com/BedrockStreaming/apcuBundle/actions/workflows/ci.yml) [![Total Downloads](https://poser.pugx.org/m6web/apcu-bundle/downloads.svg)](https://packagist.org/packages/m6web/apcu-bundle) [![License](http://poser.pugx.org/m6web/apcu-bundle/license)](https://packagist.org/packages/m6web/apcu-bundle) [![PHP Version Require](http://poser.pugx.org/m6web/apcu-bundle/require/php)](https://packagist.org/packages/m6web/apcu-bundle)

Provide APCu support, see [PECL/APCu](http://pecl.php.net/package/APCu).

## Installation

Via [Composer](https://getcomposer.org/) :

```json
"require": {
    "m6web/apcu-bundle" : "^1.4"
}
```

Also require the PECL extension APCu :

```shell
# pecl install -f apcu
```

Don't forget to enable the extension in your _php.ini_.

*NB: due to an update in APCu API, from ApcuBundle v1.1.1, you must install APCu v4.0.7 or higher*

## Configuration

The main configuration key is `m6web_apcu`. Each subkey defines a new Apcu cache service. These services are named `m6web_apcu + subkey`. For each service, several parameters can be set :

- `namespace` (string, optional) : Empty by default. Namespace for all keys stored in APCu cache via this instance.
- `ttl` (integer, optionnal) : 3600 (seconds) by default. Define the default TTL used when no TTL is given to store data.
- `class` (string, optionnal) : You can override the default cache class. It should extends `M6Web\Bundle\ApcuBundle\Apcu\Apcu`.

### Example

```yml
m6web_apcu:
    myCache:
        namespace: 6play-api-applaunch
        ttl: 3600
    otherCache: ~
```

## Usage

```php
$cache = $container->get('m6web_apcu.myCache');
$key   = 'myCacheKey';

var_dump($cache->exists($key)); // boolean, false

$cache->store($key, 'Hello', 3600)

var_dump($cache->exists($key)); // boolean, true
var_dump($cache->fetch($key)); // string, Hello

$cache->delete($key);

var_dump($cache->exists($key)); // boolean, false
var_dump($cache->fetch($key)); // bolean, false
```

## Tests

If you wish to run Bundle tests, you must enable APCu in CLI environment by defining `apc.enable_cli` option to `1`.

Then you can run the tests :

```shell
$ ./vendor/bin/phpunit tests
```
