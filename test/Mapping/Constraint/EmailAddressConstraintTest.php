<?php
declare(strict_types = 1);

namespace vardumper\FormidableTest\Mapping\Constraint;

use DASPRiD\Formidable\Mapping\Constraint\EmailAddressConstraint;
use DASPRiD\Formidable\Mapping\Constraint\Exception\InvalidTypeException;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @covers DASPRiD\Formidable\Mapping\Constraint\EmailAddressConstraint
 */
class EmailAddressConstraintTest extends TestCase
{
    public function testAssertionWithInvalidValueType()
    {
        $constraint = new EmailAddressConstraint();
        $this->expectException(InvalidTypeException::class);
        $constraint(1);
    }

    public function testFailureWithEmptyString()
    {
        $constraint = new EmailAddressConstraint();
        $validationResult = $constraint('');
        $this->assertFalse($validationResult->isSuccess());
        ValidationErrorAssertion::assertErrorMessages($this, $validationResult, ['error.email-address' => []]);
    }

    public function testFailureWithInvalidEmailAddress()
    {
        $constraint = new EmailAddressConstraint();
        $validationResult = $constraint('foobar');
        $this->assertFalse($validationResult->isSuccess());
        ValidationErrorAssertion::assertErrorMessages($this, $validationResult, ['error.email-address' => []]);
    }

    public function testSuccessWithValidEmailAddress()
    {
        $constraint = new EmailAddressConstraint();
        $validationResult = $constraint('foo@bar.com');
        $this->assertTrue($validationResult->isSuccess());
    }
}
