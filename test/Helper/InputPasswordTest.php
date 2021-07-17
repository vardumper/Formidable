<?php
declare(strict_types = 1);

namespace vardumper\FormidableTest\Helper;

use vardumper\Formidable\Data;
use vardumper\Formidable\Field;
use vardumper\Formidable\FormError\FormErrorSequence;
use vardumper\Formidable\Helper\InputPassword;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @covers DASPRiD\Formidable\Helper\InputPassword
 * @covers DASPRiD\Formidable\Helper\AttributeTrait
 */
class InputPasswordTest extends TestCase
{
    public function testDefaultInput()
    {
        $helper = new InputPassword();
        $this->assertSame(
            '<input type="password" id="input.foo" name="foo">',
            $helper(new Field('foo', 'bar&', new FormErrorSequence(), Data::none()))
        );
    }

    public function testInputTypeCannotBeOverriden()
    {
        $helper = new InputPassword();
        $this->assertSame(
            '<input type="password" id="input.foo" name="foo">',
            $helper(new Field('foo', 'bar&', new FormErrorSequence(), Data::none()), ['type' => 'text'])
        );
    }

    public function testCustomAttribute()
    {
        $helper = new InputPassword();
        $this->assertSame(
            '<input data-foo="bar" type="password" id="input.foo" name="foo">',
            $helper(new Field('foo', 'bar&', new FormErrorSequence(), Data::none()), ['data-foo' => 'bar'])
        );
    }
}
