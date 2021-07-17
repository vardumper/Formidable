<?php
declare(strict_types = 1);

namespace vardumper\FormidableTest\Mapping\Exception;

use vardumper\Formidable\Mapping\Exception\InvalidMappingException;
use vardumper\Formidable\Mapping\MappingInterface;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @covers vardumper\Formidable\Mapping\Exception\InvalidMappingException
 */
class InvalidMappingExceptionTest extends TestCase
{
    public function testFromInvalidMappingWithObject()
    {
        $this->assertSame(
            sprintf('Mapping was expected to implement %s, but got stdClass', MappingInterface::class),
            InvalidMappingException::fromInvalidMapping(new stdClass())->getMessage()
        );
    }

    public function testFromInvalidMappingWithScalar()
    {
        $this->assertSame(
            sprintf('Mapping was expected to implement %s, but got boolean', MappingInterface::class),
            InvalidMappingException::fromInvalidMapping(true)->getMessage()
        );
    }
}
