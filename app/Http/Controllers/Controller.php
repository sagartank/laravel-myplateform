<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $only_request_currency = ['USD', 'PYGH', 'PYG','GS', 'GS.', 'Gs', 'Gs.'];  /* use for valid url query string */

    public $payment_options = [];

    public function __construct()
    {
        $this->payment_options = config('constants.PAYMENT_OPTIONS');
    }
}
