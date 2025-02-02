<?php
declare(strict_types = 1);

namespace vardumper\Formidable\Mapping;

use vardumper\Formidable\FormError\FormError;
use vardumper\Formidable\FormError\FormErrorSequence;
use vardumper\Formidable\Mapping\Exception\InvalidBindResultException;
use vardumper\Formidable\Mapping\Exception\ValidBindResultException;

final class BindResult
{
    /**
     * @var mixed
     */
    private $value;

    /**
     * @var FormErrorSequence
     */
    private $formErrorSequence;

    private function __construct()
    {
    }

    /**
     * @param mixed $value
     */
    public static function fromValue($value) : self
    {
        $bindResult = new self();
        $bindResult->value = $value;
        return $bindResult;
    }

    public static function fromFormErrors(FormError ...$formErrors) : self
    {
        $bindResult = new self();
        $bindResult->formErrorSequence = new FormErrorSequence(...$formErrors);
        return $bindResult;
    }

    public static function fromFormErrorSequence(FormErrorSequence $formErrorSequence) : self
    {
        $bindResult = new self();
        $bindResult->formErrorSequence = $formErrorSequence;
        return $bindResult;
    }

    public function isSuccess() : bool
    {
        return null === $this->formErrorSequence;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        if (null !== $this->formErrorSequence) {
            throw InvalidBindResultException::fromGetValueAttempt();
        }

        return $this->value;
    }

    public function getFormErrorSequence() : FormErrorSequence
    {
        if (null === $this->formErrorSequence) {
            throw ValidBindResultException::fromGetFormErrorsAttempt();
        }

        return $this->formErrorSequence;
    }
}
