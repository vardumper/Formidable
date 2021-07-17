<?php
declare(strict_types = 1);

namespace vardumper\FormidableTest\Mapping;

use vardumper\Formidable\Data;
use vardumper\Formidable\Mapping\BindResult;
use vardumper\Formidable\Mapping\Constraint\ConstraintInterface;
use vardumper\Formidable\Mapping\Constraint\ValidationError;
use vardumper\Formidable\Mapping\Constraint\ValidationResult;
use vardumper\Formidable\Mapping\FieldMapping;
use vardumper\Formidable\Mapping\Formatter\FormatterInterface;
use vardumper\Formidable\Mapping\MappingInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers vardumper\Formidable\Mapping\FieldMapping
 * @covers vardumper\Formidable\Mapping\MappingTrait
 */
class FieldMappingTest extends TestCase
{
    use MappingTraitTestTrait;

    public function testBindReturnsFailureResult()
    {
        $data = Data::fromFlatArray(['foo' => 'bar']);
        $bindResult = BindResult::fromFormErrors();

        $binder = $this->prophesize(FormatterInterface::class);
        $binder->bind('foo', $data)->willReturn($bindResult);

        $mapping = (new FieldMapping($binder->reveal()))->withPrefixAndRelativeKey('', 'foo');
        $this->assertSame($bindResult, $mapping->bind($data));
    }

    public function testBindReturnsSuccessResult()
    {
        $data = Data::fromFlatArray(['foo' => 'bar']);

        $binder = $this->prophesize(FormatterInterface::class);
        $binder->bind('foo', $data)->willReturn(BindResult::fromValue('bar'));

        $mapping = (new FieldMapping($binder->reveal()))->withPrefixAndRelativeKey('', 'foo');
        $bindResult = $mapping->bind($data);
        $this->assertTrue($bindResult->isSuccess());
        $this->assertSame('bar', $bindResult->getValue());
    }

    public function testBindAppliesConstraints()
    {
        $data = Data::fromFlatArray(['foo' => 'bar']);

        $binder = $this->prophesize(FormatterInterface::class);
        $binder->bind('foo', $data)->willReturn(BindResult::fromValue('bar'));

        $constraint = $this->prophesize(ConstraintInterface::class);
        $constraint->__invoke('bar')->willReturn(new ValidationResult(new ValidationError('bar')));

        $mapping = (new FieldMapping($binder->reveal()))->withPrefixAndRelativeKey('', 'foo')->verifying(
            $constraint->reveal()
        );
        $bindResult = $mapping->bind($data);
        $this->assertFalse($bindResult->isSuccess());
        $this->assertSame('bar', $bindResult->getFormErrorSequence()->getIterator()->current()->getMessage());
        $this->assertSame('foo', $bindResult->getFormErrorSequence()->getIterator()->current()->getKey());
    }

    public function testUnbind()
    {
        $data = Data::fromFlatArray(['foo' => 'bar']);

        $binder = $this->prophesize(FormatterInterface::class);
        $binder->unbind('foo', 'bar')->willReturn($data);

        $mapping = (new FieldMapping($binder->reveal()))->withPrefixAndRelativeKey('', 'foo');
        $this->assertSame($data, $mapping->unbind('bar'));
    }

    public function testCreatePrefixedKey()
    {
        $binder = $this->prophesize(FormatterInterface::class);

        $mapping = (new FieldMapping($binder->reveal()))->withPrefixAndRelativeKey('foo', 'bar');
        $this->assertAttributeSame('foo[bar]', 'key', $mapping);
    }

    /**
     * {@inheritdoc}
     */
    protected function getInstanceForTraitTests() : MappingInterface
    {
        return new FieldMapping($this->prophesize(FormatterInterface::class)->reveal());
    }
}
