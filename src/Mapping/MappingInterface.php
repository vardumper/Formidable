<?php
declare(strict_types = 1);

namespace vardumper\Formidable\Mapping;

use vardumper\Formidable\Data;
use vardumper\Formidable\Mapping\Constraint\ConstraintInterface;

interface MappingInterface
{
    public function bind(Data $data) : BindResult;

    public function unbind($value) : Data;

    public function withPrefixAndRelativeKey(string $prefix, string $relativeKey) : MappingInterface;

    public function verifying(ConstraintInterface ...$constraints) : MappingInterface;
}
