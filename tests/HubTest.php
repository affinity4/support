<?php declare(strict_types=1);

namespace Affinity4\Support\Tests;

use Affinity4\Support\Hub;
use DI\Container;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

final class HubTest extends TestCase
{
    protected ContainerInterface $container;

    public function setUp(): void
    {
        $this->container = new Container;
    }

    public function tearDown(): void
    {
        unset($this->container);
    }

    public function testGetContainer()
    {
        $hub = new Hub($this->container);
        $this->assertInstanceOf(ContainerInterface::class, $hub->getContainer());
    }

    public function testHubReceivesDefault()
    {
        $hub = new Hub($this->container);
        $hub->defaults(function ($pipeline, $passable) {
            return $pipeline->send($passable)
                ->through(PipelineEmpty::class)
                ->thenReturn();
        });

        $this->assertTrue($hub->pipe(true));
    }

    public function testHubReceivesNamedPipe()
    {
        $hub = new Hub($this->container);

        $hub->pipeline('test-pipeline', function ($pipeline, $passable) {
            return $pipeline->send($passable)
                ->through(PipelineEmpty::class)
                ->thenReturn();
        });

        $hub->defaults(function ($pipeline, $passable) {
            return $pipeline->send($passable)
                ->through(PipelineFoo::class)
                ->thenReturn();
        });

        $this->assertEquals('foo', $hub->pipe('foo', 'test-pipeline'));
        $this->assertEquals('foo', $hub->pipe('bar'));
    }
}

class PipelineEmpty
{
    public function handle($piped, $next)
    {
        return $next($piped);
    }
}

class PipelineFoo
{
    public function handle($piped, $next)
    {
        return $next('foo');
    }
}
