<?php

namespace JordJD\ThisIsHowIRole\CacheDrivers;

use JordJD\ThisIsHowIRole\Interfaces\CacheDriverInterface;

class FileCacheDriver implements CacheDriverInterface
{
    private $cacheDirectory;

    public function __construct($cacheDirectory = null)
    {
        $this->cacheDirectory = $cacheDirectory ?: sys_get_temp_dir().'/thisishowirole-cache';
    }

    public function set($key, $value)
    {
        if (!$this->ensureCacheDirectory()) {
            return false;
        }

        $item = array(
            'expires' => strtotime('+1 month'),
            'value' => $value,
        );

        return file_put_contents($this->path($key), serialize($item), LOCK_EX) !== false;
    }

    public function get($key)
    {
        $path = $this->path($key);

        if (!is_file($path)) {
            return false;
        }

        $item = @unserialize(file_get_contents($path));

        if (!is_array($item) || !array_key_exists('expires', $item) || !array_key_exists('value', $item)) {
            $this->delete($key);

            return false;
        }

        if ($item['expires'] < time()) {
            $this->delete($key);

            return false;
        }

        return $item['value'];
    }

    public function delete($key)
    {
        $path = $this->path($key);

        return !is_file($path) || unlink($path);
    }

    private function ensureCacheDirectory()
    {
        return is_dir($this->cacheDirectory)
            || @mkdir($this->cacheDirectory, 0777, true)
            || is_dir($this->cacheDirectory);
    }

    private function path($key)
    {
        return $this->cacheDirectory.'/'.sha1($key).'.cache';
    }
}
