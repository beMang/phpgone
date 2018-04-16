<?php

namespace phpGone\Core;

class Config{
    protected $config = [];
    protected $configFiles;

    public function getConfig(){
        return $this->config;
    }

    public function getConfigFile(){
        return $this->configFiles;
    }

    public function get($key){
        if(!empty($this->config[$key])){
            return $this->config[$key];
        } else{
            return false;
        }
    }

    public function define($file){
        if(is_file($file)){
            $this->config = array_merge($this->config, require($file));
        } else{
            return false;
        }
    }
}