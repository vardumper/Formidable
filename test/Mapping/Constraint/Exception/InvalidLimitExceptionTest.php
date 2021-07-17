<?php
declare(strict_types = 1);

namespace vardumper\FormidableTest\Mapping\Exception;

use vardumper\Formidable\Mapping\Constraint\Exception\InvalidLimitException;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @covers vardumper\Formidable\Mapping\Constraint\Exception\InvalidLimitException
 */
class InvalidLimitExceptionTest extends TestCase
{
    public function testFromNonNumericValueWithString()
    {
        $this->assertSame(
            'Limit was expected to be numeric, but got "test"',
            InvalidLimitException::fromNonNumericValue('test')->getMessage()
        );
    }

    public function testFromNonNumericValueWithObject()
    {
        $this->assertSame(
            'Limit was expected to be numeric, but got object',
            InvalidLimitException::fromNonNumericValue(new stdClass())->getMessage()
        );
    }
}
