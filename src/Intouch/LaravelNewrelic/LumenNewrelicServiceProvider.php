<?php

namespace Intouch\LaravelNewrelic;

use Illuminate\Support\ServiceProvider;
use Intouch\Newrelic\Newrelic;

class LumenNewrelicServiceProvider extends ServiceProvider
{
	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->configure('newrelic');

		$this->app['newrelic'] = $this->app->share(
			function ( $app ) {
				return new Newrelic( $app['config']->get( 'newrelic.throw_if_not_installed' ) );
			}
		);
	}
}
