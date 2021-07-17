<?php
declare(strict_types = 1);

namespace vardumper\FormidableTest\Mapping\Exception;

use vardumper\Formidable\Mapping\Exception\ValidBindResultException;
use PHPUnit\Framework\TestCase;

/**
 * @covers vardumper\Formidable\Mapping\Exception\ValidBindResultException
 */
class ValidBindResultExceptionTest extends TestCase
{
    public function testFromGetFormErrorsAttempt()
    {
        $this->assertSame(
            'Form errors can only be retrieved when bind result was not successful',
            ValidBindResultException::fromGetFormErrorsAttempt()->getMessage()
        );
    }
}
