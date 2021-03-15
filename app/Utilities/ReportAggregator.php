<?php

namespace App\Utilities;

use Illuminate\Support\Facades\Config;

class ReportAggregator
{
    /**
     * @var \Illuminate\Support\Facades\Config
     */
    public $timezone;

    public function __construct($timezone)
    {

        $this->timezone = $timezone;
    }
}
