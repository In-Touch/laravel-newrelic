<?php
/**
 * Copyright (c)2015 In-Touch Insight Systems Inc.  All rights reserved.
 *
 * Date: 15-03-11
 * Time: 11:28 AM
 *
 * @author  pleckey
 * @project laravel-newrelic
 */

namespace Intouch\LaravelNewrelic\Observers;

class NewrelicTimingObserver
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
	 * The list of observable events we are able to care about
	 *
	 * @var array
	 */
	protected $valid = [
		'created',
		'saved',
		'deleted',
		'updated',
		'restored',
	];

	/**
	 * Static storage for the timing values
	 *
	 * @var array
	 */
	protected static $times = [ ];

	/**
	 * @param string|null $name
	 * @param array       $care
	 */
	public function __construct( $name = null, array $care = [ ] )
	{
		$this->name = $name;
		if (count( $care ) > 0) {
			$this->care = array_intersect( $this->valid, $care );
		}
	}

	protected function getMetricName( $model, $event )
	{
		return 'Custom/Timing/' . trim( str_replace( '\\', '/', $this->name ?: get_class( $model ) ), '/' ) . '/' . $event;
	}

	/**
	 * Grab the time creating started
	 *
	 * @param Illuminate\Database\Eloquent\Model $model
	 */
	public function creating( $model )
	{
		static::$times['create'] = -microtime( true );
	}

	/**
	 * Grab the time saving started
	 *
	 * @param Illuminate\Database\Eloquent\Model $model
	 */
	public function saving( $model )
	{
		static::$times['save'] = -microtime( true );
	}

	/**
	 * Grab the time deleting started
	 *
	 * @param Illuminate\Database\Eloquent\Model $model
	 */
	public function deleting( $model )
	{
		static::$times['delete'] = -microtime( true );
	}

	/**
	 * Grab the time updating started
	 *
	 * @param Illuminate\Database\Eloquent\Model $model
	 */
	public function updating( $model )
	{
		static::$times['update'] = -microtime( true );
	}

	/**
	 * Grab the time restoring started
	 *
	 * @param Illuminate\Database\Eloquent\Model $model
	 */
	public function restoring( $model )
	{
		static::$times['restore'] = -microtime( true );
	}

	/**
	 * Record the time it took to create
	 *
	 * @param Illuminate\Database\Eloquent\Model $model
	 */
	public function created( $model )
	{
		if ( !in_array( 'created', $this->care ) ) return;
		$ms = round( static::$times['create'] + microtime( true ), 3 ) * 1000;
		\Newrelic::customMetric( $this->getMetricName( $model, 'created' ), $ms );
	}

	/**
	 * Record the time it took to save
	 *
	 * @param Illuminate\Database\Eloquent\Model $model
	 */
	public function saved( $model )
	{
		if ( !in_array( 'saved', $this->care ) ) return;
		$ms = round( static::$times['save'] + microtime( true ), 3 ) * 1000;
		\Newrelic::customMetric( $this->getMetricName( $model, 'saved' ), $ms );
	}

	/**
	 * Record the time it took to delete
	 *
	 * @param Illuminate\Database\Eloquent\Model $model
	 */
	public function deleted( $model )
	{
		if ( !in_array( 'deleted', $this->care ) ) return;
		$ms = round( static::$times['delete'] + microtime( true ), 3 ) * 1000;
		\Newrelic::customMetric( $this->getMetricName( $model, 'deleted' ), $ms );
	}

	/**
	 * Record the time it took to update
	 *
	 * @param Illuminate\Database\Eloquent\Model $model
	 */
	public function updated( $model )
	{
		if ( !in_array( 'updated', $this->care ) ) return;
		$ms = round( static::$times['update'] + microtime( true ), 3 ) * 1000;
		\Newrelic::customMetric( $this->getMetricName( $model, 'updated' ), $ms );
	}

	/**
	 * Record the time it took to restore
	 *
	 * @param Illuminate\Database\Eloquent\Model $model
	 */
	public function restored( $model )
	{
		if ( !in_array( 'restored', $this->care ) ) return;
		$ms = round( static::$times['restore'] + microtime( true ), 3 ) * 1000;
		\Newrelic::customMetric( $this->getMetricName( $model, 'restored' ), $ms );
	}
}