<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhotoController extends Controller
{
    protected $int;

    /**
     * @param $int
     */
    public function __construct($int)
    {
        $this->int = $int;
    }

    public function handle()
    {
        dump('hoho');
    }

}
