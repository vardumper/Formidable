<?php
declare(strict_types = 1);

namespace vardumper\Formidable\Mapping\Formatter;

use vardumper\Formidable\Data;
use vardumper\Formidable\FormError\FormError;
use vardumper\Formidable\Mapping\BindResult;
use vardumper\Formidable\Mapping\Formatter\Exception\InvalidTypeException;

final class TextFormatter implements FormatterInterface
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

        return BindResult::fromValue($data->getValue($key));
    }

    /**
     * {@inheritdoc}
     */
    public function unbind(string $key, $value) : Data
    {
        if (!is_string($value)) {
            throw InvalidTypeException::fromInvalidType($value, 'string');
        }

        return Data::fromFlatArray([$key => $value]);
    }
}
