<?php
declare(strict_types = 1);

namespace vardumper\FormidableTest\Mapping\Exception;

use vardumper\Formidable\Mapping\Exception\BindFailureException;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * @covers vardumper\Formidable\Mapping\Exception\BindFailureException
 * @covers vardumper\Formidable\Mapping\Exception\NestedMappingExceptionTrait
 */
class BindFailureExceptionTest extends TestCase
{
    public function testFromBindExceptionWithGenericException()
    {
        $previous = new Exception('test');
        $exception = BindFailureException::fromBindException('foo', $previous);

        $this->assertSame(
            'Failed to bind foo: test',
            $exception->getMessage()
        );
        $this->assertSame($previous, $exception->getPrevious());
    }

    public function testFromBindExceptionWithNestedBindFailureException()
    {
        $previous = BindFailureException::fromBindException(
            'bar',
            BindFailureException::fromBindException('baz', new Exception('test'))
        );
        $exception = BindFailureException::fromBindException('foo', $previous);

        $this->assertSame(
            'Failed to bind foo.bar.baz: test',
            $exception->getMessage()
        );
        $this->assertSame($previous, $exception->getPrevious());
    }
}
