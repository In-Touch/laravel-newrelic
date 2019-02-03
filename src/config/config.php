<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Default NewRelic Integration Settings
	|--------------------------------------------------------------------------
	*/

	/*
	 * Will automatically name transactions in NewRelic,
	 * using the Laravel route name, action or request.
	 *
	 * Set this to false to use the NewRelic default naming
	 * scheme, or to set your own in your application.
	 */
	'auto_name_transactions' => env('NEWRELIC_AUTO_NAME_TRANSACTION', true),

	/*
	 * Will automatically name queued jobs in NewRelic,
	 * using the Laravel job class, data, or connection name.
	 *
	 * Set this to false to use the NewRelic default naming
	 * scheme, or to set your own in your application.
	 */
	'auto_name_jobs' => env('NEWRELIC_AUTO_NAME_JOB', true),

	/*
	 * Define the name used when automatically naming transactions.
	 * a token string:
	 *      a pattern you define yourself, available tokens:
	 *          {controller} = Controller@action or Closure@path
	 *          {method} = GET / POST / etc.
	 *          {route} = route name if named, otherwise same as {controller}
	 *          {path} = the registered route path (includes variable names)
	 *          {uri} = the actual URI requested
	 *      anything that is not a matched token will remain a string literal
	 *      example:
	 *          "GET /world" with pattern 'hello {path} you really {method} me' would return:
	 *          'hello /world you really GET me'
	 */
	'name_provider' => env('NEWRELIC_NAME_PROVIDER', '{uri} {route}'),

	/*
	 * Define the name used when automatically naming queued jobs.
	 * a token string:
	 *      a pattern you define yourself, available tokens:
	 *          {connection} = The name of the queue connection
	 *          {class} = The name of the job class
	 *      anything that is not a matched token will remain a string literal
	 *      example:
	 *          Given a job named App\MyJob, with data {"subject":"hello","to":"world"},
	 *			the pattern 'I say {input} when I run {class}' would return:
	 *			'I say hello, world when I run App\MyJob'
	 */
	'job_name_provider' => env('NEWRELIC_JOB_NAME_PROVIDER', '{class}'),

	/*
	 * Will cause an exception to be thrown if the NewRelic
	 * PHP agent is not found / installed
	 */
	'throw_if_not_installed' => env('NEWRELIC_THROW_IF_NOT_INSTALLED', false),

);
