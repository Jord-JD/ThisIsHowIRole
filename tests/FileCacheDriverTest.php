<?php

namespace JordJD\ThisIsHowIRole\Tests;

use JordJD\ThisIsHowIRole\CacheDrivers\FileCacheDriver;
use PHPUnit\Framework\TestCase;

class FileCacheDriverTest extends TestCase
{
    public function testFalseyValuesRoundTripWithoutBecomingCacheMisses()
    {
        $directory = $this->newDirectory();
        $cache = new FileCacheDriver($directory);

        $this->assertTrue($cache->set('zero', 0));
        $this->assertSame(0, $cache->get('zero'));
        $this->assertTrue($cache->set('false', false));
        $this->assertFalse($cache->get('false'));

        $this->removeDirectory($directory);
    }

    public function testDeleteRemovesCachedValue()
    {
        $directory = $this->newDirectory();
        $cache = new FileCacheDriver($directory);
        $cache->set('key', 'value');

        $this->assertTrue($cache->delete('key'));
        $this->assertFalse($cache->get('key'));

        $this->removeDirectory($directory);
    }

    private function newDirectory()
    {
        return sys_get_temp_dir().'/tihir-test-'.uniqid('', true);
    }

    private function removeDirectory($directory)
    {
        foreach (glob($directory.'/*') ?: array() as $file) {
            unlink($file);
        }

        if (is_dir($directory)) {
            rmdir($directory);
        }
    }
}
