<?php
declare(strict_types = 1);

namespace vardumper\Formidable\Mapping\Formatter;

use vardumper\Formidable\Data;
use vardumper\Formidable\FormError\FormError;
use vardumper\Formidable\Mapping\BindResult;
use vardumper\Formidable\Mapping\Formatter\Exception\InvalidTypeException;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;

final class DateFormatter implements FormatterInterface
{
    /**
     * @var DateTimeZone
     */
    private $timeZone;

    public function __construct(DateTimeZone $timeZone)
    {
        $this->timeZone = $timeZone;
    }

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

        $dateTime = DateTimeImmutable::createFromFormat(
            '!Y-m-d',
            $data->getValue($key),
            $this->timeZone
        );

        if (false === $dateTime) {
            return BindResult::fromFormErrors(new FormError(
                $key,
                'error.date'
            ));
        }

        return BindResult::fromValue($dateTime);
    }

    /**
     * {@inheritdoc}
     */
    public function unbind(string $key, $value) : Data
    {
        if (!$value instanceof DateTimeInterface) {
            throw InvalidTypeException::fromInvalidType($value, 'DateTimeInterface');
        }

        $dateTime = $value->setTimezone($this->timeZone);

        return Data::fromFlatArray([$key => $dateTime->format('Y-m-d')]);
    }
}
