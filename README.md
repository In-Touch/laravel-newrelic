#Laravel 4 NewRelic package

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
* this will automatically name all transactions by their route name
    * ex: Route::get('foo/{id}/bar/{name}', ...) will be named: 'get foo/{id}/bar/{name}'
    * the uri parameters will not be replaced, it will be the string literal

=> **throw_if_not_installed**

* type: bool
* default: false
* if true, will throw an exception if NewRelic PHP agent is not found / installed

###Basic Use
The registered Service Provider includes a Facade to the [Intouch/Newrelic](http://github.com/In-Touch/newrelic) class.  Any of its methods may be accessed as any other Facade is accessed, for example:

    Newrelic::setAppName( 'MyApp' );

... would set the NewRelic App Name to 'MyApp'