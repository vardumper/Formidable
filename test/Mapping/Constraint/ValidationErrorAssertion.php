<?php
declare(strict_types = 1);

namespace vardumper\FormidableTest\Mapping\Constraint;

use vardumper\Formidable\Mapping\Constraint\ValidationResult;
use PHPUnit\Framework\TestCase;

class ValidationErrorAssertion
{
    public static function assertErrorMessages(
        TestCase $testCase,
        ValidationResult $validationResult,
        array $expectedMessages
    ) {
        $actualMessages = [];

        foreach ($validationResult->getValidationErrors() as $validationError) {
            $actualMessages[$validationError->getMessage()] = $validationError->getArguments();
        }

        $testCase->assertSame($expectedMessages, $actualMessages);
    }
}
