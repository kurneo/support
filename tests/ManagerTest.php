<?php

namespace Kurneo\Support\Tests;

use Kurneo\Support\Exceptions\ManagerException;
use Kurneo\Support\Manager;
use PHPUnit\Framework\TestCase;

class ManagerTest extends TestCase
{
    public function testManager()
    {
        $manager = new class extends Manager {

            public function defaultDriver(): string
            {
                return 'foo';
            }

            public function createFooDriver()
            {
                return new class {
                    function testCall()
                    {
                        return 'foo';
                    }

                    function testCallForward()
                    {
                        return 'foo-forward';
                    }
                };
            }

            public function createBarDriver()
            {
                return new class {
                    function testCall()
                    {
                        return 'bar';
                    }

                    function testCallForward()
                    {
                        return 'bar-forward';
                    }
                };
            }

            protected function forwardToDriver(): array
            {
                return [
                    'testCallForward' => 'bar'
                ];
            }
        };


        $this->assertEquals('foo', $manager->testCall());
        $this->assertEquals('bar-forward', $manager->testCallForward());
    }

    public function testManagerWithWrongDriver()
    {
        $manager = new class extends Manager {

            public function defaultDriver(): string
            {
                return 'foo';
            }

            public function createBarDriver()
            {
                return new class {
                    function testCall()
                    {
                        return 'bar';
                    }

                    function testCallForward()
                    {
                        return 'bar-forward';
                    }
                };
            }
        };
        $this->expectException(ManagerException::class);
        $this->expectExceptionMessage("Creator function for driver [foo] is not define");
        $manager->testCall();
    }
}
