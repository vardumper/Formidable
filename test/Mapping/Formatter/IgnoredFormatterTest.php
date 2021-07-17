<?php
declare(strict_types = 1);

namespace vardumper\FormidableTest\Mapping\Formatter;

use vardumper\Formidable\Data;
use vardumper\Formidable\Mapping\Formatter\IgnoredFormatter;
use PHPUnit\Framework\TestCase;

/**
 * @covers vardumper\Formidable\Mapping\Formatter\IgnoredFormatter
 */
class IgnoredFormatterTest extends TestCase
{
    public function testBindValue()
    {
        $this->assertSame(
            'foo',
            (new IgnoredFormatter('foo'))->bind('foo', Data::fromFlatArray(['foo' => 'baz']))->getValue()
        );
    }

    public function testUnbindValue()
    {
        $data = (new IgnoredFormatter('foo'))->unbind('foo', 'bar');
        $this->assertTrue($data->isEmpty());
    }
}
