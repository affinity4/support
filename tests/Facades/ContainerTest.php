<?php declare(strict_types=1);

namespace Affinity4\Support\Tests\Facades;

use PHPUnit\Framework\TestCase;
use Affinity4\Support\Facades\App;
use Affinity4\Support\Facades\Container;
use Affinity4\Support\Facade;
use DI\Container as DIContainer;
use Psr\Container\ContainerInterface;

final class ContainerTest extends TestCase
{
    protected ?ContainerInterface $container;

    public function setUp(): void
    {
        $this->container = new DIContainer;
        Facade::setFacadeApplication($this->container);
    }

    public function tearDown(): void
    {
        $this->container = null;
        Facade::setFacadeApplication($this->container);
    }

    public function testContainer()
    {
        Container::set('test-container-set', function () {
            return 'test-container-set';
        });

        $this->assertTrue($this->container->has('test-container-set'));
        $this->assertEquals('test-container-set', $this->container->get('test-container-set'));
    }
}
