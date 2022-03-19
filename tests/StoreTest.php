<?php


namespace Kurneo\Support\Tests;

use Kurneo\Support\Contracts\Store as StoreContract;
use Kurneo\Support\Store;
use PHPUnit\Framework\TestCase;

class StoreTest extends TestCase
{
    protected StoreContract $store;

    protected function setUp(): void
    {
        parent::setUp();
        $this->store = new Store();
    }

    public function testSet()
    {
        $this->assertNotEmpty($this->store->set('test-key', 'test'));
    }

    public function testSetWithArray()
    {
        $this->assertNotEmpty($this->store->set(['test-key' => 'test', 'test-key-2' => 'test']));
    }

    public function testGet()
    {
        $this->store->set('test-key', 'test');
        $this->assertEquals('test', $this->store->get('test-key'));
    }

    public function testGetWithWrongKey()
    {
        $this->store->set('test-key', 'test');
        $this->assertEquals(null, $this->store->get('test-key-1'));
    }

    public function testHas()
    {
        $this->store->set('test-key', 'test');
        $this->assertTrue($this->store->has('test-key'));
        $this->assertFalse($this->store->has('test-key-1'));
    }

    public function testAll()
    {
        $this->store->set('test-key', 'test');
        $this->store->set('test-key-1', 'test 1');
        $this->assertSame([
            'test-key' => 'test',
            'test-key-1' => 'test 1'
        ], $this->store->all());
    }

    public function testForget()
    {
        $this->store->set('test-key', 'test');
        $this->store->set('test-key-1', 'test 1');
        $this->assertTrue($this->store->forget('test-key-1'));
        $this->assertFalse($this->store->has('test-key-1'));
        $this->assertNotNull($this->store->get('test-key'));
    }

    public function testForgetAll()
    {
        $this->store->set('test-key', 'test');
        $this->store->set('test-key-1', 'test 1');
        $this->store->forgetAll();
        $this->assertSame([], $this->store->all());
    }
}
