<?php declare(strict_types=1);

namespace Affinity4\Support\Tests\Facades;

use PHPUnit\Framework\TestCase;
use Affinity4\Support\Contracts\Pipeline as PipelineContract;
use Affinity4\Support\Facades\Pipeline;
use Affinity4\Support\Facade;
use DI\Container;

final class PipelineTest extends TestCase
{
    protected $app;

    public function setUp(): void
    {
        Facade::setFacadeApplication(new Container);
    }

    public function tearDown(): void
    {
        unset($this->app);
    }
    

    public function testIsInstanceOfPipeline()
    {
        $this->assertInstanceOf(PipelineContract::class, Pipeline::getFacadeRoot());
    }
}
