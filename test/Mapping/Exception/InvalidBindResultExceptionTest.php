<?php
declare(strict_types = 1);

namespace vardumper\FormidableTest\Mapping\Exception;

use vardumper\Formidable\Mapping\Exception\InvalidBindResultException;
use PHPUnit\Framework\TestCase;

/**
 * @covers vardumper\Formidable\Mapping\Exception\InvalidBindResultException
 */
class InvalidBindResultExceptionTest extends TestCase
{
    public function testFromGetValueAttempt()
    {
        $this->assertSame(
            'Value can only be retrieved when bind result was successful',
            InvalidBindResultException::fromGetValueAttempt()->getMessage()
        );
    }
}
