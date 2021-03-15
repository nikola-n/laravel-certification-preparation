<?php

namespace App\Utilities;

class Transistor
{
    /**
     * @var \App\Utilities\PodcastParser
     */
    public $parser;

    /**
     * @param \App\Utilities\PodcastParser $parser
     */
    public function __construct(PodcastParser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @return string
     */
    public function handle()
    {
        return 'It works!';
    }
}
