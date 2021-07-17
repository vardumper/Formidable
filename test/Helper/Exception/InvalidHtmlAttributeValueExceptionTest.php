<?php
declare(strict_types = 1);

namespace vardumper\FormidableTest\Helper\Exception;

use vardumper\Formidable\Helper\Exception\InvalidHtmlAttributeValueException;
use PHPUnit\Framework\TestCase;

/**
 * @covers vardumper\Formidable\Helper\Exception\InvalidHtmlAttributeValueException
 */
class InvalidHtmlAttributeValueExceptionTest extends TestCase
{
    public function testFromInvalidValue()
    {
        $this->assertSame(
            'HTML attribute value must be of type string, but got integer',
            InvalidHtmlAttributeValueException::fromInvalidValue(1)->getMessage()
        );
    }
}
