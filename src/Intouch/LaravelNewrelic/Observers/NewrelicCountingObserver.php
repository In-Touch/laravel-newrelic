<?php
/**
 * Copyright (c)2015 In-Touch Insight Systems Inc.  All rights reserved.
 *
 * Date: 15-03-11
 * Time: 8:55 AM
 *
 * @author  pleckey
 * @project laravel-newrelic
 */

namespace Intouch\LaravelNewrelic\Observers;

class NewrelicCountingObserver
{

	/**
	 * Custom Metric name
	 *
	 * @var string|null
	 */
	protected $name;

	/**
	 * The list of observable events we care about
	 *
	 * @var array
	 */
	protected $care = [
		'created',
		'saved',
		'deleted',
		'updated',
		'restored',
	];

	/**
	 * @param null  $name
	 * @param array $care
	 */
	public function __construct( $name = null, array $care = [ ] )
	{
		$this->name = $name;
		$this->care = $care ?: $this->care;
	}

	/**
	 * Handle the observable events we get passed
	 *
	 * @param string $event
	 * @param array  $args
	 */
	public function __call( $event, array $args )
	{
		// ignore it if we don't care about this event
		if (!in_array( $event, $this->care )) {
			return;
		}

		$model = array_shift( $args );
		$metric = trim( str_replace( '\\', '/', $this->name ?: get_class( $model ) ), '/' );
		$name  = 'Custom/Counts/' . $metric . '/' . $event;

		/**
		 * NewRelic assumes custom metrics to be in milliseconds, so 4 gets interpreted as
		 * .004.  So each "count" increment is 1000 to display properly in custom dashboards.
		 */
		\Newrelic::customMetric( $name, 1000 );
	}
}