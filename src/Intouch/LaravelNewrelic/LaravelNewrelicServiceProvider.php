<?php
namespace Intouch\LaravelNewrelic;

use Illuminate\Support\ServiceProvider;
use Intouch\Newrelic\Newrelic;

class LaravelNewrelicServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package( 'intouch/laravel-newrelic' );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['newrelic'] = $this->app->share(
            function ( $app )
            {
                return new Newrelic();
            }
        );

        $this->registerNamedTransactions();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array( 'newrelic' );
    }

    /**
     * Registers the named transactions with the NewRelic PHP agent
     */
    protected function registerNamedTransactions()
    {
        if ( true == $this->app['config']['laravel-newrelic::auto_name_transactions'] )
        {
            $app = $this->app;
            $app->after(
                function ( $request, $response ) use ( $app )
                {
                    /** @var \Illuminate\Routing\Router $router */
                    $router = $app['router'];
                    /** @var \Intouch\Newrelic\Newrelic $newrelic */
                    $newrelic = $app['newrelic'];

                    $newrelic->nameTransaction( $router->currentRouteName() );
                }
            );
        }
    }
}