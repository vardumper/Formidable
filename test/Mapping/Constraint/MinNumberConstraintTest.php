<?php
declare(strict_types = 1);

namespace vardumper\FormidableTest\Mapping\Constraint;

use vardumper\Formidable\Mapping\Constraint\Exception\InvalidLimitException;
use vardumper\Formidable\Mapping\Constraint\Exception\InvalidTypeException;
use vardumper\Formidable\Mapping\Constraint\MinNumberConstraint;
use PHPUnit\Framework\TestCase;

/**
 * @covers vardumper\Formidable\Mapping\Constraint\MinNumberConstraint
 */
class MinNumberConstraintTest extends TestCase
{
    public function validValueProvider() : array
    {
        return [
            [0, 0],
            [0, 1],
            [0., 0.],
            [0., 0.1],
            ['0', '0'],
            ['0', '0.1'],
        ];
    }

    /**
     * @dataProvider validValueProvider
     * @param int|float|string $limit
     * @param int|float|string $value
     */
    public function testValidValues($limit, $value)
    {
        $constraint = new MinNumberConstraint($limit);
        $validationResult = $constraint($value);
        $this->assertTrue($validationResult->isSuccess());
    }

    public function invalidValueProvider() : array
    {
        return [
            [0, -1],
            [0., -1.],
            ['0', '-1'],
        ];
    }

    /**
     * @dataProvider invalidValueProvider
     * @param int|float|string $limit
     * @param int|float|string $value
     */
    public function testInvalidValues($limit, $value)
    {
        $constraint = new MinNumberConstraint($limit);
        $validationResult = $constraint($value);
        $this->assertFalse($validationResult->isSuccess());
        ValidationErrorAssertion::assertErrorMessages(
            $this,
            $validationResult,
            ['error.min-number' => ['limit' => (string) $limit]]
        );
    }

    public function testAssertionWithInvalidLimitType()
    {
        $this->expectException(InvalidLimitException::class);
        new MinNumberConstraint('test');
    }

    public function testAssertionWithNonNumericValueType()
    {
        $constraint = new MinNumberConstraint(0);
        $this->expectException(InvalidTypeException::class);
        $constraint('test');
    }
}
