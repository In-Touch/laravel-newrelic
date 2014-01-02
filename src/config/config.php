<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Default NewRelic Integration Settings
    |--------------------------------------------------------------------------
    */

    /*
     * Will automatically name transactions in NewRelic,
     * using the Laravel route name, action or request
     */
    'auto_name_transactions' => true,

    /*
     * Define the name provider used when automatically naming transactions.
     * Accepts either a closure or null to use the package default.
     */
    'name_provider' => null,

    // 'name_provider' => function ($request, $response, $app) {
    //     return $app['router']->currentRouteAction()
    //         ?: $request->getMethod() . ' ' . $request->getPathInfo();
    // },

    /*
     * Will cause an exception to be thrown if the NewRelic
     * PHP agent is not found / installed
     */
    'throw_if_not_installed' => false,

);
