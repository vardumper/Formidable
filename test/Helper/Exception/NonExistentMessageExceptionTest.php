<?php
declare(strict_types = 1);

namespace vardumper\FormidableTest\Helper\Exception;

use vardumper\Formidable\Helper\Exception\NonExistentMessageException;
use PHPUnit\Framework\TestCase;

/**
 * @covers vardumper\Formidable\Helper\Exception\NonExistentMessageException
 */
class NonExistentMessageExceptionTest extends TestCase
{
    public function testFromNonExistentMessageKey()
    {
        $this->assertSame(
            'Non-existent message key "foo" provided',
            NonExistentMessageException::fromNonExistentMessageKey('foo')->getMessage()
        );
    }
}
