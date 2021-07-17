<?php
declare(strict_types = 1);

namespace vardumper\FormidableTest\Exception;

use vardumper\Formidable\Exception\NonExistentKeyException;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * @covers DASPRiD\Formidable\Exception\NonExistentKeyException
 */
class NonExistentKeyExceptionTest extends TestCase
{
    public function testFromNonExistentKey()
    {
        $this->assertSame(
            'Non-existent key "foo" provided',
            NonExistentKeyException::fromNonExistentKey('foo')->getMessage()
        );
    }
}
