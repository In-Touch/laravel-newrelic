<?php

namespace Intouch\LaravelNewrelic;

use Illuminate\Http\Request as Request;
use Closure;

class LumenNewrelicMiddleware
{
		public function handle(Request $request, Closure $next)
	{
		$config = app()['config'];

		if (true == $config->get('newrelic.auto_name_transactions')) {
			app('newrelic')->nameTransaction($this->getTransactionName());
		}
		$response = $next($request);

		return $response;
	}

	/**
	 * Build the transaction name
	 *
	 * @return string
	 */
	public function getTransactionName()
	{
		return str_replace(
			[
				'{controller}',
				'{method}',
				'{route}',
				'{path}',
				'{uri}',
			],
			[
				$this->getController(),
				app('request')->getMethod(),
				$this->getRoute(),
				app('request')->getPathInfo(),
				app('request')->getUri(),
			],
			app('config')->get('newrelic.name_provider')
		);
	}

	/**
	 * Get the current route name, or controller if not named
	 *
	 * @return string
	 */
	protected function getRoute()
	{
		$request = app('request');

		$method = $request->getMethod();
		$pathInfo = $request->getPathInfo();

		return app()->getRoutes()[$method.$pathInfo]['uri'];
	}

	/**
	 * Get the current controller / action
	 *
	 * @return string
	 */
	protected function getController()
	{
		$request = app('request');

		$method = $request->getMethod();
		$pathInfo = $request->getPathInfo();

		return app()->getRoutes()[$method.$pathInfo]['action']['uses'];
	}
}

