<?php
declare(strict_types = 1);

namespace vardumper\FormidableTest\Mapping\Formatter\Exception;

use vardumper\Formidable\Mapping\Formatter\Exception\InvalidTypeException;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @covers vardumper\Formidable\Mapping\Formatter\Exception\InvalidTypeException
 */
class InvalidTypeExceptionTest extends TestCase
{
    public function testFromInvalidTypeWithObject()
    {
        $this->assertSame(
            'Value was expected to be of type foo, but got stdClass',
            InvalidTypeException::fromInvalidType(new stdClass(), 'foo')->getMessage()
        );
    }

    public function testFromInvalidTypeWithScalar()
    {
        $this->assertSame(
            'Value was expected to be of type foo, but got boolean',
            InvalidTypeException::fromInvalidType(true, 'foo')->getMessage()
        );
    }

    public function testFromNonNumericString()
    {
        $this->assertSame(
            'String was expected to be numeric, but got "test"',
            InvalidTypeException::fromNonNumericString('test')->getMessage()
        );
    }
}
