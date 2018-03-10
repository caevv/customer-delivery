<?php

namespace Infrastructure;

class InvalidFileException extends \InvalidArgumentException
{
    public function __construct(string $line)
    {
        parent::__construct("The provided list of customer is invalid: {$line}");
    }
}
