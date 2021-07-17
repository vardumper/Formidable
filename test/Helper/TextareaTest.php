<?php
declare(strict_types = 1);

namespace vardumper\FormidableTest\Helper;

use vardumper\Formidable\Data;
use vardumper\Formidable\Field;
use vardumper\Formidable\FormError\FormErrorSequence;
use vardumper\Formidable\Helper\Textarea;
use PHPUnit\Framework\TestCase;

/**
 * @covers vardumper\Formidable\Helper\Textarea
 * @covers vardumper\Formidable\Helper\AttributeTrait
 */
class TextareaTest extends TestCase
{
    public function testDefaultTextarea()
    {
        $helper = new Textarea();
        $this->assertSame(
            '<textarea id="input.foo" name="foo">bar&amp;</textarea>',
            $helper(new Field('foo', 'bar&', new FormErrorSequence(), Data::none()))
        );
    }

    public function testEmptyTextarea()
    {
        $helper = new Textarea();
        $this->assertSame(
            '<textarea id="input.foo" name="foo"></textarea>',
            $helper(new Field('foo', '', new FormErrorSequence(), Data::none()))
        );
    }

    public function testCustomAttribute()
    {
        $helper = new Textarea();
        $this->assertSame(
            '<textarea data-foo="bar" id="input.foo" name="foo">bar&amp;</textarea>',
            $helper(new Field('foo', 'bar&', new FormErrorSequence(), Data::none()), ['data-foo' => 'bar'])
        );
    }
}
