<?php
declare(strict_types = 1);

namespace vardumper\FormidableTest\Helper\Exception;

use vardumper\Formidable\Helper\Exception\InvalidSelectLabelException;
use PHPUnit\Framework\TestCase;

/**
 * @covers vardumper\Formidable\Helper\Exception\InvalidSelectLabelException
 */
class InvalidSelectLabelExceptionTest extends TestCase
{
    public function testFromInvalidLabel()
    {
        $this->assertSame(
            'Label must either be a string or an array of child values, but got integer',
            InvalidSelectLabelException::fromInvalidLabel(1)->getMessage()
        );
    }
}
