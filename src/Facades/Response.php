<?php declare(strict_types=1);

namespace Affinity4\Support\Facades;

use Affinity4\Support\Http\Response as HttpResponse;
use Affinity4\Support\Facade;

/**
 * @method static \Psr\Http\Message\ResponseInterface get()
 * @method static \Affinity4\Support\Http\Response json(array $data)
 */
class Response extends Facade
{
    /**
     * @inheritDoc
     */
    public static function getFacadeRoot()
    {
        return new HttpResponse();
    }

    /**
     * @inheritDoc
     */
    protected static function getFacadeAccessor(): string
    {
        return 'response';
    }
}
