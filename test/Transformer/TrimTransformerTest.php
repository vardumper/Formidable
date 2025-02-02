<?php
declare(strict_types = 1);

namespace vardumper\FormidableTest\Mapping;

use vardumper\Formidable\Transformer\TrimTransformer;
use PHPUnit\Framework\TestCase;

/**
 * @covers vardumper\Formidable\Transformer\TrimTransformer
 */
class TrimTransformerTest extends TestCase
{
    public function testTransform()
    {
        $transformer = new TrimTransformer();
        $this->assertSame('foo', $transformer("\0\r\n foo\0\r\n ", ''));
    }
}
