<?php

namespace Kurneo\Support\Tests;

use Kurneo\Support\Contracts\Hook as HookContract;
use Kurneo\Support\Hook;
use PHPUnit\Framework\TestCase;

class HookTest extends TestCase
{
    protected HookContract $hook;

    protected function setUp(): void
    {
        parent::setUp();

        $this->hook = new class extends Hook {
            public function fire(string $name, ...$args)
            {
            }
        };
    }

    public function testAddAndGetAndDelete()
    {
        $this->assertTrue($this->hook->add('test-hook', function () {
            echo 'test';
        }, 1, 0));

        $this->assertCount(1, $this->hook->get('test-hook'));
        $this->hook->remove('test-hook');
        $this->assertEmpty($this->hook->get('test-hook'));
    }
}