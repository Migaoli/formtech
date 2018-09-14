<?php


namespace App;


class Theme
{

    private $config = [];

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function name(): string {
        return $this->config['name'];
    }
}