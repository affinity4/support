<?php declare(strict_types=1);

namespace Affinity4\Support\Tests;

use DI\Container;
use GuzzleHttp\Psr7\Response as Psr7Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Affinity4\Support\Http\Response;
use Affinity4\Support\Facade;
use Affinity4\Support\HigherOrderTapProxy;

final class HelperFunctionsTest extends TestCase
{
    public function setUp(): void
    {
        Facade::setFacadeApplication(new Container);
    }

    public function tearDown(): void
    {
        Facade::setFacadeApplication(null);
    }
    
    public function testResponseIsInstanceOfHttpResponse()
    {
        $this->assertInstanceOf(Response::class, response('Test'));
    }

    /**
     * @depends testResponseIsInstanceOfHttpResponse
     */
    public function testResponseJsonIsInstanceOfHttpResponse()
    {
        $this->assertInstanceOf(Response::class, response()->json(['foo' => 'bar']));
    }

    /**
     * @depends testResponseIsInstanceOfHttpResponse
     */
    public function testResponseGetIsInstanceOfPsrHttpResponse()
    {
        $this->assertInstanceOf(ResponseInterface::class, response()->get());
    }

    /**
     * @depends testResponseGetIsInstanceOfPsrHttpResponse
     */
    public function testResponseJsonSetsJsonHeaders()
    {
        $response = response()->json(['foo' => 'bar'])->get();
        $this->assertSame('application/json', $response->getHeaderLine('Content-Type'));
    }

    public function testTapReturnsInstanceOfValueWhenCallbackIsNotNull()
    {
        $this->assertInstanceOf(Response::class, tap(new Response(), function () {}));
    }

    public function testTapReturnsInstanceOfHigherOrderTapProxyWhenCallbackIsNull()
    {
        $this->assertInstanceOf(HigherOrderTapProxy::class, tap(new Response(), null));
    }

    public function testTapModifiesValueWhenCallbackIsNotNull()
    {
        $response = tap(new Psr7Response(), function ($response) {
            $response->getBody()->write('foo');
        });
        $this->assertSame('foo', $response->getBody()->__toString());
    }
}
