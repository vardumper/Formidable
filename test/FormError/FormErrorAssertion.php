<?php
declare(strict_types = 1);

namespace vardumper\FormidableTest\FormError;

use vardumper\Formidable\FormError\FormErrorSequence;
use PHPUnit\Framework\TestCase;

class FormErrorAssertion
{
    public static function assertErrorMessages(
        TestCase $testCase,
        FormErrorSequence $formErrorSequence,
        array $expectedMessages
    ) {
        $actualMessages = [];

        foreach ($formErrorSequence as $formError) {
            $actualMessages[$formError->getKey()] = $formError->getMessage();
        }

        $testCase->assertSame($expectedMessages, $actualMessages);
    }
}
