<?php

namespace Infrastructure;

use Framework\CustomerRepository;
use OfficeInvitation\Customer;

class FileCustomerRepository implements CustomerRepository
{
    /**
     * @param string $filePath
     *
     * @return array|Customer[]
     */
    public function fetchCustomersFromFile(string $filePath): array
    {
        try {
            $file = file_get_contents($filePath);
        } catch (\Exception $throwable) {
            throw new FileNotFoundException($filePath);
        }

        $customerRow = explode("\n", $file);
        array_shift($customerRow);

        $customers = [];

        foreach ($customerRow as $row => $data) {
            //get row data
            $customerData = json_decode($data);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new InvalidFileException($data);
            }

            $customers[] = new Customer(
                $customerData->user_id,
                $customerData->name,
                (float) $customerData->latitude,
                (float) $customerData->longitude
            );
        }

        return $customers;
    }
}
