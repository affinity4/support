<?php declare(strict_types=1);

namespace Affinity4\Support\Facades;

use Affinity4\Support\Facade;
use Affinity4\Support\Pipeline as PipelineBase;

/**
 * @method \Affinity4\Support\Pipeline send(mixed $passable)
 * @method \Affinity4\Support\Pipeline through(array|mixed $pipes)
 * @method \Affinity4\Support\Pipeline pipe(array|mixed $pipes)
 * @method \Affinity4\Support\Pipeline via(string $method)
 * @method \Affinity4\Support\Pipeline then(\Closure $destination)
 * @method mixed thenReturn()
 * @method \Affinity4\Support\PipelineBase getContainer()
 * @method \Affinity4\Support\PipelineBase setContainer(ContainerInterface $container)
 */
class Pipeline extends Facade
{
    /**
     * @inheritDoc
     */
    public static function getFacadeRoot()
    {
        return new PipelineBase(static::$container);
    }

    /**
     * @inheritDoc
     */
    protected static function getFacadeAccessor(): string
    {
        return 'pipeline';
    }
}
