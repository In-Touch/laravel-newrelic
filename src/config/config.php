<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Default NewRelic Integration Settings
    |--------------------------------------------------------------------------
    */

    /*
     * Will automatically name transactions in NewRelic,
     * using the Laravel route name
     */
    'auto_name_transactions' => true,

    /*
     * Will cause an exception to be thrown if the NewRelic
     * PHP agent is not found / installed
     */
    'throw_if_not_installed' => false,

);