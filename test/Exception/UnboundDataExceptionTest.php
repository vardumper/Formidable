<?php
declare(strict_types = 1);

namespace vardumper\FormidableTest\Exception;

use vardumper\Formidable\Exception\UnboundDataException;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @covers DASPRiD\Formidable\Exception\UnboundDataException
 */
class UnboundDataExceptionTest extends TestCase
{
    public function testFromGetValueAttempt()
    {
        $this->assertSame(
            'No data have been bound to the form',
            UnboundDataException::fromGetValueAttempt()->getMessage()
        );
    }
}
