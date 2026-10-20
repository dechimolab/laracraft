<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\View;
use Hashids\Hashids;

abstract class Controller
{
    public function __construct()
    {
        $this->hashids = new Hashids('LARAGEN' . date('Ymd'), 12);
        View::share('hashids', $this->hashids);
    }
}
