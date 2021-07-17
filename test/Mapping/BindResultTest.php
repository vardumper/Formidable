<?php
declare(strict_types = 1);

namespace vardumper\FormidableTest\Mapping;

use vardumper\Formidable\FormError\FormError;
use vardumper\Formidable\FormError\FormErrorSequence;
use vardumper\Formidable\Mapping\BindResult;
use vardumper\Formidable\Mapping\Exception\InvalidBindResultException;
use vardumper\Formidable\Mapping\Exception\ValidBindResultException;
use vardumper\FormidableTest\FormError\FormErrorAssertion;
use PHPUnit\Framework\TestCase;

/**
 * @covers vardumper\Formidable\Mapping\BindResult
 */
class BindResultTest extends TestCase
{
    public function testBindResultFromValue()
    {
        $bindResult = BindResult::fromValue('foo');
        $this->assertTrue($bindResult->isSuccess());
        $this->assertSame('foo', $bindResult->getValue());
        $this->expectException(ValidBindResultException::class);
        $bindResult->getFormErrorSequence();
    }

    public function testBindResultFromFormErrors()
    {
        $bindResult = BindResult::fromFormErrors(new FormError('foo', 'bar'));
        $this->assertFalse($bindResult->isSuccess());
        FormErrorAssertion::assertErrorMessages(
            $this,
            $bindResult->getFormErrorSequence(),
            [
                'foo' => 'bar',
            ]
        );
        $this->expectException(InvalidBindResultException::class);
        $bindResult->getValue();
    }

    public function testBindResultFromFormErrorSequence()
    {
        $bindResult = BindResult::fromFormErrorSequence(new FormErrorSequence(new FormError('foo', 'bar')));
        $this->assertFalse($bindResult->isSuccess());
        FormErrorAssertion::assertErrorMessages(
            $this,
            $bindResult->getFormErrorSequence(),
            [
                'foo' => 'bar',
            ]
        );
        $this->expectException(InvalidBindResultException::class);
        $bindResult->getValue();
    }
}
