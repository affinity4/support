<?php

namespace Affinity4\Support\Tests;

use Affinity4\Support\Traits\ForwardsCalls;
use PHPUnit\Framework\TestCase;

class ForwardsCallsTest extends TestCase
{
    public function testForwardsCalls()
    {
        $results = (new ForwardsCallsOne)->forwardedTwo('foo', 'bar');

        $this->assertEquals(['foo', 'bar'], $results);
    }

    public function testNestedForwardCalls()
    {
        $results = (new ForwardsCallsOne)->forwardedBase('foo', 'bar');

        $this->assertEquals(['foo', 'bar'], $results);
    }

    public function testMissingForwardedCallThrowsCorrectError()
    {
        $this->expectException(\BadMethodCallException::class);
        $this->expectExceptionMessage('Call to undefined method Affinity4\Support\Tests\ForwardsCallsOne::missingMethod()');

        (new ForwardsCallsOne)->missingMethod('foo', 'bar');
    }

    public function testMissingAlphanumericForwardedCallThrowsCorrectError()
    {
        $this->expectException(\BadMethodCallException::class);
        $this->expectExceptionMessage('Call to undefined method Affinity4\Support\Tests\ForwardsCallsOne::this1_shouldWork_too()');

        (new ForwardsCallsOne)->this1_shouldWork_too('foo', 'bar');
    }

    public function testNonForwardedErrorIsNotTamperedWith()
    {
        $this->expectException(\Error::class);
        $this->expectExceptionMessage('Call to undefined method Affinity4\Support\Tests\ForwardsCallsBase::missingMethod()');

        (new ForwardsCallsOne)->baseError('foo', 'bar');
    }

    public function testThrowBadMethodCallException()
    {
        $this->expectException(\BadMethodCallException::class);
        $this->expectExceptionMessage('Call to undefined method Affinity4\Support\Tests\ForwardsCallsOne::test()');

        (new ForwardsCallsOne)->throwTestException('test');
    }
}

class ForwardsCallsOne
{
    use ForwardsCalls;

    public function __call($method, $parameters)
    {
        return $this->forwardCallTo(new ForwardsCallsTwo, $method, $parameters);
    }

    public function throwTestException($method)
    {
        static::throwBadMethodCallException($method);
    }
}

class ForwardsCallsTwo
{
    use ForwardsCalls;

    public function __call($method, $parameters)
    {
        return $this->forwardCallTo(new ForwardsCallsBase, $method, $parameters);
    }

    public function forwardedTwo(...$parameters)
    {
        return $parameters;
    }
}

/**
 * @method void missingMethod() // just stop the red squiggly
 */
class ForwardsCallsBase
{
    public function forwardedBase(...$parameters)
    {
        return $parameters;
    }

    public function baseError()
    {
        return $this->missingMethod();
    }
}
