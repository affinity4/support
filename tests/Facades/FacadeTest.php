<?php declare(strict_types=1);

namespace Affinity4\Support\Tests\Facades;

use DI\Container;
use PHPUnit\Framework\TestCase;
use Affinity4\Support\Facade;
use Psr\Container\ContainerInterface;
use Slim\Factory\AppFactory;

final class FacadeTest extends TestCase
{
    public function setUp(): void
    {
        Facade::clearResolvedInstances();
        Facade::setFacadeApplication(null);
    }

    public function testSetFacadeApplication()
    {
        Facade::setFacadeApplication(new Container);
        $this->assertInstanceOf(ContainerInterface::class, Facade::getFacadeApplication());
    }

    public function testFacadeCallsUnderlyingObject()
    {
        $container = new Container;
        $container->set('foo', function () {
            return new StubClass();
        });
        Facade::setFacadeApplication($container);

        $this->assertInstanceOf(StubClass::class, FacadeStub::resolveFacadeInstance('foo'));
        $this->assertTrue(method_exists(FacadeStub::resolveFacadeInstance('foo'), 'bar'));
        $this->assertEquals('baz', FacadeStub::bar());
    }
}

class FacadeStub extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'foo';
    }
}

class StubClass
{
    public function bar()
    {
        return 'baz';
    }
}
