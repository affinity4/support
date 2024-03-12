<?php declare(strict_types=1);

namespace Affinity4\Support\Facades;

use Affinity4\Support\Facade;
use GuzzleHttp\Psr7\Response;

/**
 * @method static \Psr\Http\Message\ResponseFactoryInterface createResponse(int $code = 200, string $reasonPhrase = '')
 */
class ResponseFactory extends Facade
{
    /**
     * @inheritDoc
     */
    public static function getFacadeRoot()
    {
        return new Response();
    }

    public static function createResponse()
    {
        return self::getFacadeRoot();
    }

    /**
     * @inheritDoc
     */
    protected static function getFacadeAccessor(): string
    {
        return 'response-factory';
    }
}
