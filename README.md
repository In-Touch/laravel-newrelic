#Laravel NewRelic package

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

```php
'Intouch\LaravelNewrelic\NewrelicServiceProvider',
```

Optionally, locate the `aliases` key and add the following line:

```php
'Newrelic' => 'Intouch\LaravelNewrelic\Facades\Newrelic',
```

Finally, publish the default configuration (it will end up in `config/newrelic.php`):

    php artisan vendor:publish

### Configuration

Once the configuration from the package if published, see `config/newrelic.php` for configuration options and 
descriptions.

### Eloquent Model Observers

There are two observer classes for monitoring your Eloquent models, the `NewrelicCountingObserver` and the
`NewrelicTimingObserver`.  As their names suggest, one counts the number of times observable model events happen and the
other gathers their timings (in milliseconds).  These recorded metrics will show up in your NewRelic Custom Metrics.

The `NewrelicCountingObserver` can be used for any observable model events, including your custom events.  The 
`NewrelicTimingObserver` currently only supports the built-in Eloquent observable events (see 
[Model Events](http://laravel.com/docs/5.0/eloquent#model-events) in the Laravel documentation).

Using the observers is simple - wherever you choose to register your model observers, simply add:

```php
User::observe(new \Intouch\LaravelNewrelic\Observers\NewrelicTimingObserver() );
User::observe(new \Intouch\LaravelNewrelic\Observers\NewrelicCountingObserver() );
```
    
... assuming you want to observe the `User` model.

Both observers take two optional parameters to their constructors: `$name` and `$care`.  `$name` is the name you want
to give to your custom metric, and if unset will default to the class name of the model object it is observing.  If you
want to change the `$care` array without changing the naming, simply pass `null` as the first constructor argument.

`$care` is an array of event names you want to care about.  This differs slightly between the ___Counting___ and
___Timing___ observers.  For the ___Counting___ observer, any event can be counted independently.  For the ___Timing___
observer, it uses the difference in time between `saving` and `saved` to submit the metric, so only the after-operation
events can be observed: `created`, `saved`, `updated`, `deleted`, `restored`.  This is also why custom observable events
are not supported for the ___Timing___ observer (yet ... working on it, we're happy to take PRs).

Per NewRelic's "best practice" suggestions, all metric names are prefaced with 'Custom/'.  The ___Counting___ observer 
also adds 'Counts/' to the name, while the ___Timing___ observer adds 'Timing/' to the name.  Both observers append
the event name to the end of the metric name.  Take as an example, using the ___Counting___ observer on the `User` model
monitoring the `created` event - the name would be: `Custom/Counts/App/User/created` (where `App/User` is the namespaced
class named of the observed model, or will be whatever you set in `$name` if supplied).

**NOTE:** To use the observers, the `Newrelic` Facade must be loaded in your application configuration, not just the 
Service Provider.

It is safe to run these observers in integration tests or interactive test environments as long as 
`newrelic.throw_if_not_installed` is set to `false`.  Then if the NewRelic PHP Agent is not installed in that 
environment, the custom metrics will simply not be recorded.

The default events both observers care about are: `created`, `saved`, `updated`, `deleted`, `restored`.

### Basic Use

This package includes a Facade to the [Intouch/Newrelic](http://github.com/In-Touch/newrelic) class.  
Any of its methods may be accessed as any other Facade is accessed, for example:

    App::after( function() {
        Newrelic::setAppName( 'MyApp' );
    } );

... would set the NewRelic App Name to 'MyApp'

### Issues

Before opening an issues for data not reporting in the format you have configured, please check your NewRelic PHP Agent 
logs and please see:
[https://discuss.newrelic.com/t/php-agent-4-19-0-disabled-3rd-party-service-provider-incorrectly/1666](https://discuss.newrelic.com/t/php-agent-4-19-0-disabled-3rd-party-service-provider-incorrectly/16667)

If that hasn't cleared things up, please open an issue here or send us a PR. 
