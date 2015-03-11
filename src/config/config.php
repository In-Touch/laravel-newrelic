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
	'auto_name_transactions' => true,

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
	'name_provider' => '{uri} {route}',

	/*
	 * Will cause an exception to be thrown if the NewRelic
	 * PHP agent is not found / installed
	 */
	'throw_if_not_installed' => false,

);
