<?php

namespace Intouch\LaravelNewrelic;

use Illuminate\Http\Request as Request;
use Closure;

class LumenNewrelicMiddleware
{
	/**
	 * @param Request $request
	 * @param Closure $next
	 */
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
		return $this->getRouteObject()['uri'];
	}

	/**
	 * Get the current controller / action
	 *
	 * @return string
	 */
	protected function getController()
	{
		return $this->getRouteObject()['action']['uses'];
	}

	/**
	 * Get current route object
	 * @date   2016-02-10
	 * @return array
	 */
	protected function getRouteObject() {
		$request = app('request');

		$verbs = 'GET|POST|PUT|DELETE|PATCH';

		$routeToRegex = function ($string) use ($verbs) {
			$string = preg_replace("/^({$verbs})/", '', $string);
			$string = preg_replace('/\{\w+\}/', '[^/]+', $string);
			$string = preg_replace('/\{(\w+):(.+?)\}/', '\2', $string);
			return '#^'.$string.'$#';
		};

		$routeToMethod = function ($string) use ($verbs) {
			return preg_replace("/^({$verbs}).+$/", '\1', $string);
		};

		$routes = [];
		foreach (app()->getRoutes() as $routeName => $route) {
			$regex = $routeToRegex($routeName);
			$method = $routeToMethod($routeName);
			$routes[$method.$regex] = compact('route', 'method', 'regex');
		}

		uksort($routes, function ($a, $b) {
			return strlen($b) - strlen($a);
		});

		$method = $request->getMethod();
		$path = rtrim($request->getPathInfo(), '/');
		$foundRoute = null;

		foreach ($routes as $regex => $details) {
			$regex = substr($regex, strlen($details['method']));
			if (true == preg_match($regex, $path) && $method == $details['method']) {
				$foundRoute = $details['route'];
				break;
			}
		}

		return $foundRoute;
	}
}

