<?php
declare(strict_types = 1);

namespace vardumper\FormidableTest\Mapping\Exception;

use vardumper\Formidable\Mapping\Exception\InvalidMappingKeyException;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @covers vardumper\Formidable\Mapping\Exception\InvalidMappingKeyException
 */
class InvalidMappingKeyExceptionTest extends TestCase
{
    public function testFromInvalidMappingKey()
    {
        $this->assertSame(
            'Mapping key must be of type string, but got object',
            InvalidMappingKeyException::fromInvalidMappingKey(new stdClass())->getMessage()
        );
    }
}
