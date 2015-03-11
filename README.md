#Laravel NewRelic package

## Laravel 5

Please see the following issue, open with NewRelic:

[https://discuss.newrelic.com/t/php-agent-4-19-0-disabled-3rd-party-service-provider-incorrectly/1666](https://discuss.newrelic.com/t/php-agent-4-19-0-disabled-3rd-party-service-provider-incorrectly/16667)

### Note

**`master` is currently undergoing updates to support Laravel 5**

    For **Laravel 4.1/4.2** support, please use the latest 1.1.x tag.
    For **Laravel 4.0** support, please use the latest 1.0.x tag.  Laravel 4.0 support is deprecated and will not be
    updated.

### Installation

Using `composer`, run:

    composer require intouch/laravel-newrelic:dev-master

Or add `intouch/laravel-newrelic` to your composer requirements:

    "require": {
        "intouch/laravel-newrelic": "dev-master"
    }

... and then run `composer install`

Once the package is installed, open your `app/config/app.php` configuration file and locate the `providers` key.  Add 
the following line to the end:

    'Intouch\LaravelNewrelic\NewrelicServiceProvider',

Optionally, locate the `aliases` key and add the following line:

    'Newrelic'        => 'Intouch\LaravelNewrelic\Facades\Newrelic',

Finally, publish the default configuration (it will end up in `config/newrelic.php`):

    $ php artisan vendor:publish

### Configuration

Once the configuration from the package if published, see `config/newrelic.php` for configuration options and 
descriptions.

### Basic Use

The registered Service Provider includes a Facade to the [Intouch/Newrelic](http://github.com/In-Touch/newrelic) class.  
Any of its methods may be accessed as any other Facade is accessed, for example:

    App::before( function() {
        Newrelic::setAppName( 'MyApp' );
    } );

... would set the NewRelic App Name to 'MyApp'
