<?php
declare(strict_types = 1);

namespace vardumper\FormidableTest\Mapping;

use vardumper\Formidable\Data;
use vardumper\Formidable\FormError\FormError;
use vardumper\Formidable\Mapping\BindResult;
use vardumper\Formidable\Mapping\Constraint\ConstraintInterface;
use vardumper\Formidable\Mapping\Constraint\ValidationError;
use vardumper\Formidable\Mapping\Constraint\ValidationResult;
use vardumper\Formidable\Mapping\Exception\InvalidTypeException;
use vardumper\Formidable\Mapping\MappingInterface;
use vardumper\Formidable\Mapping\RepeatedMapping;
use PHPUnit\Framework\TestCase;

/**
 * @covers vardumper\Formidable\Mapping\RepeatedMapping
 * @covers vardumper\Formidable\Mapping\MappingTrait
 */
class RepeatedMappingTest extends TestCase
{
    use MappingTraitTestTrait;

    public function testBindValidArray()
    {
        $data = Data::fromNestedArray([
            'foo' => [
                'bar' => [
                    'baz',
                ],
            ],
        ]);

        $wrappedMapping = $this->prophesize(MappingInterface::class);
        $wrappedMapping->withPrefixAndRelativeKey('foo[bar]', '0')->willReturn($wrappedMapping->reveal());
        $wrappedMapping->bind($data)->willReturn(BindResult::fromValue('baz'));

        $mapping = (new RepeatedMapping($wrappedMapping->reveal()))->withPrefixAndRelativeKey('foo', 'bar');
        $bindResult = $mapping->bind($data);
        $this->assertTrue($bindResult->isSuccess());
        $this->assertSame(['baz'], $bindResult->getValue());
    }

    public function testBindPartiallyValidArray()
    {
        $data = Data::fromNestedArray([
            'foo' => [
                'bar' => [
                    'baz',
                    'bat',
                ],
            ],
        ]);

        $bazMapping = $this->prophesize(MappingInterface::class);
        $bazMapping->bind($data)->willReturn(BindResult::fromValue('baz'));
        $batMapping = $this->prophesize(MappingInterface::class);
        $batMapping->bind($data)->willReturn(BindResult::fromFormErrors(new FormError('', 'bar')));

        $wrappedMapping = $this->prophesize(MappingInterface::class);
        $wrappedMapping->withPrefixAndRelativeKey('foo[bar]', '0')->willReturn($bazMapping->reveal());
        $wrappedMapping->withPrefixAndRelativeKey('foo[bar]', '1')->willReturn($batMapping->reveal());

        $mapping = (new RepeatedMapping($wrappedMapping->reveal()))->withPrefixAndRelativeKey('foo', 'bar');
        $bindResult = $mapping->bind($data);
        $this->assertFalse($bindResult->isSuccess());
        $this->assertSame('bar', $bindResult->getFormErrorSequence()->getIterator()->current()->getMessage());
    }

    public function testBindAppliesConstraintsToValidResult()
    {
        $data = Data::fromNestedArray([
            'foo' => [
                'bar' => [
                    'baz',
                ],
            ],
        ]);

        $wrappedMapping = $this->prophesize(MappingInterface::class);
        $wrappedMapping->withPrefixAndRelativeKey('foo[bar]', '0')->willReturn($wrappedMapping->reveal());
        $wrappedMapping->bind($data)->willReturn(BindResult::fromValue('baz'));

        $constraint = $this->prophesize(ConstraintInterface::class);
        $constraint->__invoke(['baz'])->willReturn(new ValidationResult(new ValidationError('bar', [], '0')));

        $mapping = (new RepeatedMapping($wrappedMapping->reveal()))->withPrefixAndRelativeKey('foo', 'bar')->verifying(
            $constraint->reveal()
        );
        $bindResult = $mapping->bind($data);
        $this->assertFalse($bindResult->isSuccess());
        $this->assertSame('bar', $bindResult->getFormErrorSequence()->getIterator()->current()->getMessage());
        $this->assertSame('foo[bar][0]', $bindResult->getFormErrorSequence()->getIterator()->current()->getKey());
    }

    public function testUnbindInvalidValue()
    {
        $mapping = new RepeatedMapping($this->prophesize(MappingInterface::class)->reveal());
        $this->expectException(InvalidTypeException::class);
        $mapping->unbind('test');
    }

    public function testUnbindValidValues()
    {
        $wrappedMapping = $this->prophesize(MappingInterface::class);
        $wrappedMapping->unbind('baz')->willReturn(Data::fromFlatArray(['foo[bar][0]' => 'baz']));
        $wrappedMapping->unbind('bat')->willReturn(Data::fromFlatArray(['foo[bar][1]' => 'bat']));
        $wrappedMapping->withPrefixAndRelativeKey('foo[bar]', '0')->willReturn($wrappedMapping->reveal());
        $wrappedMapping->withPrefixAndRelativeKey('foo[bar]', '1')->willReturn($wrappedMapping->reveal());

        $mapping = (new RepeatedMapping($wrappedMapping->reveal()))->withPrefixAndRelativeKey('foo', 'bar');
        $data = $mapping->unbind(['baz', 'bat']);
        $this->assertSame('baz', $data->getValue('foo[bar][0]'));
        $this->assertSame('bat', $data->getValue('foo[bar][1]'));
    }

    public function testCreatePrefixedKey()
    {
        $wrappedMapping = $this->prophesize(MappingInterface::class);

        $mapping = (new RepeatedMapping($wrappedMapping->reveal()))->withPrefixAndRelativeKey('foo', 'bar');
        $this->assertAttributeSame('foo[bar]', 'key', $mapping);
    }

    /**
     * {@inheritdoc}
     */
    protected function getInstanceForTraitTests() : MappingInterface
    {
        return new RepeatedMapping($this->prophesize(MappingInterface::class)->reveal());
    }
}
