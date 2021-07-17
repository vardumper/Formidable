<?php
declare(strict_types = 1);

namespace vardumper\FormidableTest\Mapping\Constraint;

use vardumper\Formidable\Mapping\Constraint\NotEmptyConstraint;
use vardumper\Formidable\Mapping\Formatter\Exception\InvalidTypeException;
use PHPUnit\Framework\TestCase;

/**
 * @covers vardumper\Formidable\Mapping\Constraint\NotEmptyConstraint
 */
class NotEmptyConstraintTest extends TestCase
{
    public function testAssertionWithInvalidValueType()
    {
        $constraint = new NotEmptyConstraint();
        $this->expectException(InvalidTypeException::class);
        $constraint(1);
    }

    public function testFailureWithEmptyString()
    {
        $constraint = new NotEmptyConstraint();
        $validationResult = $constraint('');
        $this->assertFalse($validationResult->isSuccess());
        ValidationErrorAssertion::assertErrorMessages(
            $this,
            $validationResult,
            ['error.empty' => []]
        );
    }

    public function testSuccessWithValidString()
    {
        $constraint = new NotEmptyConstraint();
        $validationResult = $constraint('a');
        $this->assertTrue($validationResult->isSuccess());
    }
}
