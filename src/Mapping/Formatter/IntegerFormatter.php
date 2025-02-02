<?php
declare(strict_types = 1);

namespace vardumper\Formidable\Mapping\Formatter;

use vardumper\Formidable\Data;
use vardumper\Formidable\FormError\FormError;
use vardumper\Formidable\Mapping\BindResult;
use vardumper\Formidable\Mapping\Formatter\Exception\InvalidTypeException;

final class IntegerFormatter implements FormatterInterface
{
    /**
     * {@inheritdoc}
     */
    public function bind(string $key, Data $data) : BindResult
    {
        if (!$data->hasKey($key)) {
            return BindResult::fromFormErrors(new FormError(
                $key,
                'error.required'
            ));
        }

        $value = $data->getValue($key);

        if (!preg_match('(^-?[1-9]*\d+$)', $value)) {
            return BindResult::fromFormErrors(new FormError(
                $key,
                'error.integer'
            ));
        }

        return BindResult::fromValue((int) $data->getValue($key));
    }

    /**
     * {@inheritdoc}
     */
    public function unbind(string $key, $value) : Data
    {
        if (!is_int($value)) {
            throw InvalidTypeException::fromInvalidType($value, 'int');
        }

        return Data::fromFlatArray([$key => (string) $value]);
    }
}
