<?php declare(strict_types=1);

namespace Affinity4\Support;

use Psr\Container\ContainerInterface;

abstract class Facade
{
    /**
     * The resolved object instances.
     *
     * @var mixed
     */
    protected static $resolvedInstance;

    /**
     * PSR-11 Container application instance.
     *
     * @var \Psr\Container\ContainerInterface|null;
     */
    protected static ?ContainerInterface $container;

    /**
     * Set the container instance.
     *
     * @param \Psr\Container\ContainerInterface|null $app
     *
     * @return void
     */
    public static function setFacadeApplication(?ContainerInterface $container)
    {
        static::$container = $container;
    }

    /**
     * Get the root object behind the facade.
     *
     * @return Psr\Container\ContainerInterface
     */
    public static function getFacadeApplication(): ContainerInterface
    {
        return static::$container;
    }

    /**
     * Get the get the resolved instance or set and then get the resolved instance.
     *
     * @param string $name
     *
     * @return mixed
     */
    public static function resolveFacadeInstance(string $name): mixed
    {
        if (isset(static::$resolvedInstance[$name])) {
            return static::$resolvedInstance[$name];
        }

        return static::$resolvedInstance[$name] = static::$container->get($name);
    }

    /**
     * Clear all of the resolved instances.
     *
     * @param string $name
     *
     * @return void
     */
    public static function clearResolvedInstance(string $name)
    {
        unset(static::$resolvedInstance[$name]);
    }

    /**
     * Clear all of the resolved instances.
     *
     * @return void
     */
    public static function clearResolvedInstances()
    {
        static::$resolvedInstance = [];
    }

    /**
     * Get the root object behind the facade.
     *
     * @return mixed
     */
    public static function getFacadeRoot()
    {
        return static::resolveFacadeInstance(static::getFacadeAccessor());
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor(): string
    {
        throw new \RuntimeException('Facade does not implement getFacadeAccessor method.');
    }

    /**
     * Handle dynamic, static calls to the object.
     *
     * @param string $method
     * @param array  $args
     *
     * @return mixed
     */
    public static function __callStatic(string $method, array $args): mixed
    {
        $instance = static::getFacadeRoot();

        if (! $instance) {
            throw new \RuntimeException('A facade root has not been set.');
        }

        return $instance->$method(...$args);
    }
}
