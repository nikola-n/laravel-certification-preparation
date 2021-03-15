<?php

namespace App\Utilities;

use App\Contracts\EventPusher;

class RedisEventPusher
{

    /**
     * @var \App\Contracts\EventPusher
     */
    public $pusher;

    public function __construct(EventPusher $pusher)
    {
        $this->pusher = $pusher;
    }
}
