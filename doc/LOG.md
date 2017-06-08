## Logging
ePaisa PHP SDK library features [Monolog](https://github.com/Seldaek/monolog) to store logs.

Logs are divided into the following streams:

### Error

Collects all the exceptions thrown by the library:

```php
Log::initErrorLog($path . '/' . '_error.log');
```

### Debug

Stores requests made to the ePaisa 2.0 API, useful for debugging:

```php
Log::initDebugLog($path . '/' . '_debug.log');
```

## Stream and external sources
Error and Debug streams rely on the `log` instance that can be provided from an external source:
```php
Log::initialize($monolog);
```