<?php

/**
 * CLI COnfig holds the CLI configuration and exposes a few useful methods for accessing it
 *
 * @author Mateusz P <bananq@gmail.com>
 */

namespace Glicerine\core;

class CliConfig
{
    private $config = [];
    private $cachedConfig = [];

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function getParam($key)
    {
        if(isset($this->cachedConfig[$key])){
            return $this->cachedConfig[$key];
        }
        $keys = explode('.', $key);
        $value = $this->config;
        $keyLength = count($keys);
        for ($ii = 0; $ii < $keyLength; $ii++) {
            if (!isset($value[$keys[$ii]])) {
                throw new \Glicerine\exceptions\GlicerineException("Config key <$keys[$ii]> incorrect");
            }
            $value = $value[$keys[$ii]];
        }
        $this->cachedConfig[$key] = $value;
        return $value;
    }

    public function hasParam($key)
    {
        try {
            $this->getParam($key);
        } catch (\Glicerine\exceptions\GlicerineException $ex) {
            return false;
        }
        return true;
    }
}
