<?php
declare(strict_types = 1);

namespace vardumper\Formidable\Mapping\Formatter;

use vardumper\Formidable\Data;
use vardumper\Formidable\FormError\FormError;
use vardumper\Formidable\Mapping\BindResult;
use vardumper\Formidable\Mapping\Formatter\Exception\InvalidTypeException;

final class BooleanFormatter implements FormatterInterface
{
    /**
     * {@inheritdoc}
     */
    public function bind(string $key, Data $data) : BindResult
    {
        switch ($data->getValue($key, 'false')) {
            case 'true':
                return BindResult::fromValue(true);

            case 'false':
                return BindResult::fromValue(false);
        }

        return BindResult::fromFormErrors(new FormError(
            $key,
            'error.boolean'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function unbind(string $key, $value) : Data
    {
        if (!is_bool($value)) {
            throw InvalidTypeException::fromInvalidType($value, 'bool');
        }

        return Data::fromFlatArray([$key => $value ? 'true' : 'false']);
    }
}
