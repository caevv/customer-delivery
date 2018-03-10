<?php

namespace Framework;

interface CustomerRepository
{
    public function fetchCustomersFromFile(string $filePath): array;
}
