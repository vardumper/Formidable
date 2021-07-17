<?php
declare(strict_types = 1);

namespace vardumper\FormidableTest\Mapping;

use vardumper\Formidable\Transformer\CallbackTransformer;
use PHPUnit\Framework\TestCase;

/**
 * @covers vardumper\Formidable\Transformer\CallbackTransformer
 */
class CallbackTransformerTest extends TestCase
{
    public function testTransform()
    {
        $transformer = new CallbackTransformer(function (string $value, string $key) : string {
            return $key . $value;
        });
        $this->assertSame('foobar', $transformer('bar', 'foo'));
    }
}
