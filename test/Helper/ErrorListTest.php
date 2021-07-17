<?php
declare(strict_types = 1);

namespace vardumper\FormidableTest\Helper;

use vardumper\Formidable\FormError\FormError;
use vardumper\Formidable\FormError\FormErrorSequence;
use vardumper\Formidable\Helper\ErrorFormatter;
use vardumper\Formidable\Helper\ErrorList;
use vardumper\Formidable\Helper\Exception\InvalidHtmlAttributeKeyException;
use vardumper\Formidable\Helper\Exception\InvalidHtmlAttributeValueException;
use PHPUnit\Framework\TestCase;

/**
 * @covers vardumper\Formidable\Helper\ErrorList
 * @covers vardumper\Formidable\Helper\AttributeTrait
 */
class ErrorListTest extends TestCase
{
    public function testRenderEmptyErrorSequence()
    {
        $helper = new ErrorList(new ErrorFormatter());
        $html = $helper(new FormErrorSequence());

        $this->assertSame('', $html);
    }

    public function testRenderMultipleErrors()
    {
        $helper = new ErrorList(new ErrorFormatter());
        $html = $helper(new FormErrorSequence(new FormError('', 'error.required'), new FormError('', 'error.integer')));

        $this->assertXmlStringEqualsXmlString(
            '<ul><li>This field is required</li><li>Integer value expected</li></ul>',
            $html
        );
    }

    public function testRenderWithCustomAttributes()
    {
        $helper = new ErrorList(new ErrorFormatter());
        $html = $helper(
            new FormErrorSequence(new FormError('', 'error.required')),
            ['class' => 'errors', 'data-foo' => 'bar']
        );

        $this->assertXmlStringEqualsXmlString(
            '<ul class="errors" data-foo="bar"><li>This field is required</li></ul>',
            $html
        );
    }

    public function testExceptionOnInvalidAttributeKey()
    {
        $helper = new ErrorList(new ErrorFormatter());
        $this->expectException(InvalidHtmlAttributeKeyException::class);
        $helper(
            new FormErrorSequence(new FormError('', 'error.required')),
            [1 => 'test']
        );
    }

    public function testExceptionOnInvalidAttributeValue()
    {
        $helper = new ErrorList(new ErrorFormatter());
        $this->expectException(InvalidHtmlAttributeValueException::class);
        $helper(
            new FormErrorSequence(new FormError('', 'error.required')),
            ['test' => 1]
        );
    }
}
