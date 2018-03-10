<?php

namespace Infrastructure;

class FileNotFoundException extends \InvalidArgumentException
{
    public function __construct(string $filePath)
    {
        parent::__construct("File {$filePath} not found");
    }
}
