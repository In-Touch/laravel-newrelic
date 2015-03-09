#Laravel NewRelic package

## Laravel 5

Please see the following issue, open with NewRelic:

[https://discuss.newrelic.com/t/php-agent-4-19-0-disabled-3rd-party-service-provider-incorrectly/1666](https://discuss.newrelic.com/t/php-agent-4-19-0-disabled-3rd-party-service-provider-incorrectly/16667)

###Note
**dev-master is currently undergoing updates to support Laravel 5**

    For **Laravel 4.1/4.2** support, please use the latest 1.1.x tag.
    For **Laravel 4.0** support, please use the latest 1.0.x tag.  Laravel 4.0 support is deprecated and will not be
    updated.

###Installation

Using `composer`, run:

    composer require intouch/laravel-newrelic:~2.0

Or add `intouch/laravel-newrelic` to your composer requirements:

    "require": {
        "intouch/laravel-newrelic": "~2.0"
    }

... and then run `composer install`

Once the package is installed, open your `app/config/app.php` configuration file and locate the `providers` key.  Add the following line to the end:

    'Intouch\LaravelNewrelic\LaravelNewrelicServiceProvider',

Optionally, locate the `aliases` key and add the following line:

    'Newrelic'        => 'Intouch\LaravelNewrelic\Facades\Newrelic',

Finally, publish the default configuration (it will end up in `app/config/packages/intouch/laravel-newrelic/config.php`):

    $ php artisan vendor:publish

###Configuration

=> **auto_name_transactions**

* type: bool
* default: true
* this will automatically name all transactions with the following precedence
    1. Route name (e.g. "home")
    2. Controller and method (e.g. "HomeController@showWelcome")
    3. HTTP verb + path (e.g. "GET /")

=> **name_provider**

* type: closure or null
* default: null
* if a closure is provided, this allows for full customization of the transaction name with access to \Illuminate\Http\Request, \Illuminate\Http\Response and \Illuminate\Foundation\Application as parameters for convenience.

=> **throw_if_not_installed**

* type: bool
* default: false
* if true, will throw an exception if NewRelic PHP agent is not found / installed

###Basic Use
The registered Service Provider includes a Facade to the [Intouch/Newrelic](http://github.com/In-Touch/newrelic) class.  Any of its methods may be accessed as any other Facade is accessed, for example:

    App::before( function() {
        Newrelic::setAppName( 'MyApp' );
    } );

... would set the NewRelic App Name to 'MyApp'
