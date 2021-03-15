<?php

namespace App\Utilities;

class Container
{

    /**
     * @var array
     */
    protected $bindings = [];

    /**
     * @param $key
     * @param $value
     */
    public function bind($key, $value)
    {
        $this->bindings[$key] = $value;
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function resolve($key)
    {
        if (isset($key)) {
            return call_user_func($this->bindings[$key]);
        }
    }
}
