<?php

namespace Nikola\HelloWorld;

class HelloWorld
{
    public function hi($firstName): string
    {
        return "Hello $firstName";
    }
}
