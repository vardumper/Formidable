<?php
declare(strict_types = 1);

namespace vardumper\FormidableTest\Mapping\Formatter;

use vardumper\Formidable\Data;
use vardumper\Formidable\Mapping\Formatter\Exception\InvalidTypeException;
use vardumper\Formidable\Mapping\Formatter\FloatFormatter;
use PHPUnit\Framework\TestCase;

/**
 * @covers vardumper\Formidable\Mapping\Formatter\FloatFormatter
 */
class FloatFormatterTest extends TestCase
{
    public function testBindValidPositiveValue()
    {
        $this->assertSame(42.12, (new FloatFormatter())->bind(
            'foo',
            Data::fromFlatArray(['foo' => '42.12'])
        )->getValue());
    }

    public function testBindValidNegativeValue()
    {
        $this->assertSame(-42.12, (new FloatFormatter())->bind(
            'foo',
            Data::fromFlatArray(['foo' => '-42.12'])
        )->getValue());
    }

    public function testBindEmptyStringValue()
    {
        $bindResult = (new FloatFormatter())->bind('foo', Data::fromFlatArray(['foo' => '']));
        $this->assertFalse($bindResult->isSuccess());
        $this->assertCount(1, $bindResult->getFormErrorSequence());

        $error = iterator_to_array($bindResult->getFormErrorSequence())[0];
        $this->assertSame('foo', $error->getKey());
        $this->assertSame('error.float', $error->getMessage());
    }

    public function testThrowErrorOnBindNonExistentKey()
    {
        $bindResult = (new FloatFormatter())->bind('foo', Data::fromFlatArray([]));
        $this->assertFalse($bindResult->isSuccess());
        $this->assertCount(1, $bindResult->getFormErrorSequence());

        $error = iterator_to_array($bindResult->getFormErrorSequence())[0];
        $this->assertSame('foo', $error->getKey());
        $this->assertSame('error.required', $error->getMessage());
    }

    public function testUnbindValidPositiveValue()
    {
        $data = (new FloatFormatter())->unbind('foo', 42.12);
        $this->assertSame('42.12', $data->getValue('foo'));
    }

    public function testUnbindValidNegativeValue()
    {
        $data = (new FloatFormatter())->unbind('foo', -42.12);
        $this->assertSame('-42.12', $data->getValue('foo'));
    }

    public function testUnbindInvalidStringValue()
    {
        $this->expectException(InvalidTypeException::class);
        (new FloatFormatter())->unbind('foo', '1.1');
    }
}
