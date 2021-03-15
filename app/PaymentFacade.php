<?php


namespace LaracastsFacades\App\Utilities;

use Illuminate\Support\Facades\Facade;

class Payment extends Facade {

   protected static function getFacadeAccessor()
    {
        return \App\Utilities\Payment::class;
    }
}
