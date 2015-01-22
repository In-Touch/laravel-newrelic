#Laravel 4 NewRelic package

###Note
This package has been updated to support the new router methods in Laravel 4.1: thank you @altrim and @PhiloNL.

For Laravel 4.0.x support, please use 1.0.x as your composer requirement.  We will continue to accept pulls for Laravel 4.0-compatible features on the 1.0.x tags.

###Installation
Add `intouch/laravel-newrelic` to your composer requirements:

    "require": {
        "intouch/laravel-newrelic": "*"
    }

Now, run `composer update`

Once the package is installed, open your `app/config/app.php` configuration file and locate the `providers` key.  Add the following line to the end:

    'Intouch\LaravelNewrelic\LaravelNewrelicServiceProvider',

Next, locate the `aliases` key and add the following line:

    'Newrelic'        => 'Intouch\LaravelNewrelic\Facades\Newrelic',

Finally, publish the default configuration (it will end up in `app/config/packages/intouch/laravel-newrelic/config.php`):

    $ php artisan config:publish intouch/laravel-newrelic

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

    Newrelic::setAppName( 'MyApp' );

... would set the NewRelic App Name to 'MyApp'
