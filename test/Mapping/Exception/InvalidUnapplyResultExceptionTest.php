<?php
declare(strict_types = 1);

namespace vardumper\FormidableTest\Mapping\Exception;

use vardumper\Formidable\Mapping\Exception\InvalidUnapplyResultException;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @covers vardumper\Formidable\Mapping\Exception\InvalidUnapplyResultException
 */
class InvalidUnapplyResultExceptionTest extends TestCase
{
    public function testFromInvalidUnapplyResult()
    {
        $this->assertSame(
            'Unapply was expected to return an array, but returned object',
            InvalidUnapplyResultException::fromInvalidUnapplyResult(new stdClass())->getMessage()
        );
    }
}
