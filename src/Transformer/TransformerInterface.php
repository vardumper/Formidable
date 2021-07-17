<?php
declare(strict_types = 1);

namespace vardumper\Formidable\Transformer;

interface TransformerInterface
{
    public function __invoke(string $value, string $key) : string;
}
