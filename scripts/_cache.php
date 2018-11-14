<?php

trait Cache
{
    protected $_cacheEnable = false;
    /**
     * @var Redis
     */
    protected $_cache = null;

    protected function _cacheInit()
    {
        if (is_null($this->_cache)) {
            $this->_cache = new Redis();
            $this->_cache->connect('127.0.0.1');
        }
    }

    protected function _cacheRead($key)
    {
        if (empty($this->_cacheEnable)) {
            return null;
        }
        $this->_cacheInit();

        $data = $this->_cache->get($this->_cacheKey($key));

        $testArray = json_decode($data, true);

        if(is_array($testArray)){
            $data = $testArray;
        }

        return $data;
    }

    protected function _cacheWrite($key, $data)
    {
        if (empty($this->_cacheEnable)) {
            return false;
        }
        $this->_cacheInit();

        if(is_array($data)){
            $data = json_encode($data);
        }

        return $this->_cache->set($this->_cacheKey($key), $data, 3600);
    }

    protected function _cacheKey($key)
    {
        return 'scripts_' . $key;
    }
}