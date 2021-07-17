<?php
declare(strict_types = 1);

namespace vardumper\FormidableTest\Mapping\Exception;

use vardumper\Formidable\Mapping\Constraint\Exception\InvalidLengthException;
use PHPUnit\Framework\TestCase;

/**
 * @covers vardumper\Formidable\Mapping\Constraint\Exception\InvalidLengthException
 */
class InvalidLengthExceptionTest extends TestCase
{
    public function testFromNegativeLength()
    {
        $this->assertSame(
            'Length must be greater than or equal to zero, but got -1',
            InvalidLengthException::fromNegativeLength(-1)->getMessage()
        );
    }
}
