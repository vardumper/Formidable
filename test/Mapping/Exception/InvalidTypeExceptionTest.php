<?php
declare(strict_types = 1);

namespace vardumper\FormidableTest\Mapping\Exception;

use vardumper\Formidable\Mapping\Exception\InvalidTypeException;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @covers vardumper\Formidable\Mapping\Exception\InvalidTypeException
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
}
