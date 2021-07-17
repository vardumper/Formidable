<?php
declare(strict_types = 1);

namespace vardumper\FormidableTest\Helper;

use vardumper\Formidable\Data;
use vardumper\Formidable\Field;
use vardumper\Formidable\FormError\FormErrorSequence;
use vardumper\Formidable\Helper\InputCheckbox;
use PHPUnit\Framework\TestCase;

/**
 * @covers vardumper\Formidable\Helper\InputCheckbox
 * @covers vardumper\Formidable\Helper\AttributeTrait
 */
class InputCheckboxTest extends TestCase
{
    public function testDefaultInputWithEmptyValue()
    {
        $helper = new InputCheckbox();
        $this->assertSame(
            '<input type="checkbox" id="input.foo" name="foo" value="true">',
            $helper(new Field('foo', '', new FormErrorSequence(), Data::none()))
        );
    }

    public function testDefaultInputWithTrueValue()
    {
        $helper = new InputCheckbox();
        $this->assertSame(
            '<input type="checkbox" id="input.foo" name="foo" value="true" checked>',
            $helper(new Field('foo', 'true', new FormErrorSequence(), Data::none()))
        );
    }

    public function testCustomAttribute()
    {
        $helper = new InputCheckbox();
        $this->assertSame(
            '<input data-foo="bar" type="checkbox" id="input.foo" name="foo" value="true">',
            $helper(new Field('foo', '', new FormErrorSequence(), Data::none()), ['data-foo' => 'bar'])
        );
    }
}
