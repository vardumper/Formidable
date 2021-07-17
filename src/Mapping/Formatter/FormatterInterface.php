<?php
declare(strict_types = 1);

namespace vardumper\Formidable\Mapping\Formatter;

use vardumper\Formidable\Data;
use vardumper\Formidable\Mapping\BindResult;

interface FormatterInterface
{
    public function bind(string $key, Data $data) : BindResult;

    public function unbind(string $key, $value) : Data;
}
