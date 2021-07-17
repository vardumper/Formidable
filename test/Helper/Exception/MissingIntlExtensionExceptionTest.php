<?php
declare(strict_types = 1);

namespace vardumper\FormidableTest\Helper\Exception;

use vardumper\Formidable\Helper\Exception\MissingIntlExtensionException;
use PHPUnit\Framework\TestCase;

/**
 * @covers vardumper\Formidable\Helper\Exception\MissingIntlExtensionException
 */
class MissingIntlExtensionExceptionTest extends TestCase
{
    public function testFromMissingExtension()
    {
        $this->assertSame(
            'You must install the PHP intl extension for this helper to work',
            MissingIntlExtensionException::fromMissingExtension()->getMessage()
        );
    }
}
