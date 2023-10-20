<?php

namespace config;

class EnvironmentVariables
{
    private $envFile;
    private $envVariables;

    public function __construct($envFile)
    {
        $this->envFile = $envFile;
        $this->envVariables = parse_ini_file($envFile);
    }

    public function getVariable($name)
    {
        if (isset($this->envVariables[$name])) {
            return $this->envVariables[$name];
        } else {
            return null;
        }
    }
}