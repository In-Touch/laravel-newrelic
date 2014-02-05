<?php
/**
 * Copyright 2013 In-Touch Insight Systems
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
namespace Intouch\LaravelNewrelic;

use Illuminate\Support\Facades\Log;
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
                return new Newrelic( $app['config']['laravel-newrelic::throw_if_not_installed'] );
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
        $me = $this;
        $app = $this->app;
        $app->after(
            function ( $request, $response ) use ( $me, $app )
            {
                if ( true == $app['config']['laravel-newrelic::auto_name_transactions'] )
                {
                    /** @var \Intouch\Newrelic\Newrelic $newrelic */
                    $newrelic = $app['newrelic'];

                    $newrelic->nameTransaction( $me->getTransactionName( $request, $response, $app ) );
                }
            }
        );
    }

    /**
     * Build the transaction name
     *
     * @param  \Illuminate\Http\Request           $request
     * @param  \Illuminate\Http\Response          $response
     * @param  \Illuminate\Foundation\Application $app
     * @return string
     */
    public function getTransactionName( $request, $response, $app )
    {
        $nameProvider = $app['config']['laravel-newrelic::name_provider'];

        if ( is_callable( $nameProvider ) ) {
            $name = $nameProvider( $request, $response, $app );
        } else {
            /** @var \Illuminate\Routing\Router $router */
            $router = $app['router'];

            $name = $router->currentRouteName()
                ?: $router->currentRouteAction()
                ?: $request->getMethod() . ' ' . $request->getPathInfo();
        }

        return $name;
    }
}
