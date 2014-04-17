# Bundle APCu

Provide APCu support, see [PECL/APCu](http://pecl.php.net/package/APCu).

## Installation

Via [Composer](https://getcomposer.org/) :

```json
"require": {
    "m6web/apcu-bundle" : "1.0.0"
}
```

Also require the PECL extension APCu :

```shell
# pecl install -f apcu
```

Don't forget to enable the extension in your _php.ini_.

## Configuration

### Example

```yml
m6web_apcu:
    applaunch:
        namespace: 6play-api-applaunch
        ttl: 3600
```

## Tests

If you wish to run Bundle tests, you must enable APCu in CLI environment by defining `apc.enable_cli` option to `1`.

Then you can run the tests :

```shell
$ ./vendor/bin/atoum
```