<?php
declare(strict_types = 1);

namespace vardumper\FormidableTest\Mapping;

use vardumper\Formidable\Data;
use vardumper\Formidable\FormError\FormError;
use vardumper\Formidable\Mapping\BindResult;
use vardumper\Formidable\Mapping\Constraint\ConstraintInterface;
use vardumper\Formidable\Mapping\Constraint\ValidationError;
use vardumper\Formidable\Mapping\Constraint\ValidationResult;
use vardumper\Formidable\Mapping\MappingInterface;
use vardumper\Formidable\Mapping\OptionalMapping;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * @covers vardumper\Formidable\Mapping\OptionalMapping
 * @covers vardumper\Formidable\Mapping\MappingTrait
 */
class OptionalMappingTest extends TestCase
{
    use MappingTraitTestTrait;

    public function testBindNonExistentSingleValue()
    {
        $wrappedMapping = $this->prophesize(MappingInterface::class);
        $wrappedMapping->bind(Argument::any())->shouldNotBeCalled();
        $wrappedMapping->withPrefixAndRelativeKey('', 'foo')->shouldBeCalled();

        $mapping = (new OptionalMapping($wrappedMapping->reveal()))->withPrefixAndRelativeKey('', 'foo');
        $this->assertNull($mapping->bind(Data::fromFlatArray([]))->getValue());
    }

    public function testBindEmptySingleValue()
    {
        $wrappedMapping = $this->prophesize(MappingInterface::class);
        $wrappedMapping->bind(Argument::any())->shouldNotBeCalled();
        $wrappedMapping->withPrefixAndRelativeKey('', 'foo')->shouldBeCalled();

        $mapping = (new OptionalMapping($wrappedMapping->reveal()))->withPrefixAndRelativeKey('', 'foo');
        $this->assertNull($mapping->bind(Data::fromFlatArray(['foo' => '']))->getValue());
    }

    public function testBindNonEmptySingleValue()
    {
        $data = Data::fromFlatArray(['foo' => 'bar']);

        $wrappedMapping = $this->prophesize(MappingInterface::class);
        $wrappedMapping->bind($data)->willReturn(BindResult::fromValue('bar'));
        $wrappedMapping->withPrefixAndRelativeKey('', 'foo')->willReturn(clone $wrappedMapping->reveal());

        $mapping = (new OptionalMapping($wrappedMapping->reveal()))->withPrefixAndRelativeKey('', 'foo');
        $this->assertSame('bar', $mapping->bind($data)->getValue());
    }

    public function testBindFullyEmptyMultiValue()
    {
        $wrappedMapping = $this->prophesize(MappingInterface::class);
        $wrappedMapping->bind(Argument::any())->shouldNotBeCalled();
        $wrappedMapping->withPrefixAndRelativeKey('', 'foo')->shouldBeCalled();

        $mapping = (new OptionalMapping($wrappedMapping->reveal()))->withPrefixAndRelativeKey('', 'foo');
        $this->assertNull($mapping->bind(Data::fromFlatArray(['foo[bar]' => '', 'foo[baz]' => '']))->getValue());
    }

    public function testBindPartiallyEmptyMultiValue()
    {
        $data = Data::fromFlatArray(['foo[bar]' => '', 'foo[baz]' => 'bat']);

        $wrappedMapping = $this->prophesize(MappingInterface::class);
        $wrappedMapping->bind($data)->willReturn(BindResult::fromValue(['bar' => '', 'baz' => 'bat']));
        $wrappedMapping->withPrefixAndRelativeKey('', 'foo')->willReturn($wrappedMapping->reveal());

        $mapping = (new OptionalMapping($wrappedMapping->reveal()))->withPrefixAndRelativeKey('', 'foo');
        $this->assertSame(['bar' => '', 'baz' => 'bat'], $mapping->bind($data)->getValue());
    }

    public function testBindInvalidValue()
    {
        $data = Data::fromFlatArray(['foo' => 'bar']);

        $wrappedMapping = $this->prophesize(MappingInterface::class);
        $wrappedMapping->bind($data)->willReturn(BindResult::fromFormErrors(new FormError('foo', 'bar')));
        $wrappedMapping->withPrefixAndRelativeKey('', 'foo')->willReturn($wrappedMapping->reveal());

        $mapping = (new OptionalMapping($wrappedMapping->reveal()))->withPrefixAndRelativeKey('', 'foo');
        $this->assertSame('bar', $mapping->bind($data)->getFormErrorSequence()->getIterator()->current()->getMessage());
    }

    public function testConstraintIsAppliedToNullReturn()
    {
        $constraint = $this->prophesize(ConstraintInterface::class);
        $constraint->__invoke(null)->willReturn(new ValidationResult())->shouldBeCalled();

        $mapping = (new OptionalMapping($this->prophesize(MappingInterface::class)->reveal()))->verifying(
            $constraint->reveal()
        );
        $this->assertNull($mapping->bind(Data::fromFlatArray([]))->getValue());
    }

    public function testConstraintIsAppliedToValueReturn()
    {
        $data = Data::fromFlatArray(['foo' => 'bar']);

        $constraint = $this->prophesize(ConstraintInterface::class);
        $constraint->__invoke('bar')->willReturn(new ValidationResult(new ValidationError('bar')));

        $wrappedMapping = $this->prophesize(MappingInterface::class);
        $wrappedMapping->bind($data)->willReturn(BindResult::fromValue('bar'));
        $wrappedMapping->withPrefixAndRelativeKey('', 'foo')->will(function () use ($wrappedMapping) {
            return $wrappedMapping->reveal();
        });

        $mapping = (new OptionalMapping($wrappedMapping->reveal()))->verifying(
            $constraint->reveal()
        )->withPrefixAndRelativeKey('', 'foo');
        $bindResult = $mapping->bind($data);
        $this->assertFalse($bindResult->isSuccess());
        $this->assertSame('bar', $bindResult->getFormErrorSequence()->getIterator()->current()->getMessage());
    }

    public function testUnbindNullValue()
    {
        $wrappedMapping = $this->prophesize(MappingInterface::class);
        $wrappedMapping->unbind(Argument::any())->shouldNotBeCalled();

        $mapping = new OptionalMapping($wrappedMapping->reveal());
        $this->assertTrue($mapping->unbind(null)->isEmpty());
    }

    public function testUnbindNotNullValue()
    {
        $wrappedMapping = $this->prophesize(MappingInterface::class);
        $wrappedMapping->unbind('foo')->willReturn(Data::fromFlatArray(['foo' => 'bar']));

        $mapping = new OptionalMapping($wrappedMapping->reveal());
        $this->assertSame('bar', $mapping->unbind('foo')->getValue('foo'));
    }

    public function testCreatePrefixedKey()
    {
        $wrappedMapping = $this->prophesize(MappingInterface::class);
        $wrappedMapping->withPrefixAndRelativeKey('foo', 'bar')->shouldBeCalled();

        $mapping = (new OptionalMapping($wrappedMapping->reveal()))->withPrefixAndRelativeKey('foo', 'bar');
        $this->assertAttributeSame('foo[bar]', 'key', $mapping);
    }

    /**
     * {@inheritdoc}
     */
    protected function getInstanceForTraitTests() : MappingInterface
    {
        return new OptionalMapping($this->prophesize(MappingInterface::class)->reveal());
    }
}
