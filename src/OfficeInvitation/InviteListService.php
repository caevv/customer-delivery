<?php

namespace OfficeInvitation;

class InviteListService
{
    /**
     * @var string
     */
    private $officeLatitude;
    /**
     * @var string
     */
    private $officeLongitude;
    /**
     * @var float
     */
    private $minimumDistanceInKm;

    /**
     * InviteListService constructor.
     *
     * @param string $officeLatitude
     * @param string $officeLongitude
     * @param float  $minimumDistanceInKm
     */
    public function __construct(string $officeLatitude, string $officeLongitude, float $minimumDistanceInKm)
    {
        $this->officeLatitude = $officeLatitude;
        $this->officeLongitude = $officeLongitude;
        $this->minimumDistanceInKm = $minimumDistanceInKm;
    }

    /**
     * @param array $customers
     *
     * @return array|Customer[]
     */
    public function getOrderedCustomersWithinRadios(array $customers): array
    {
        $filteredCustomers = array_filter(
            $customers,
            function (Customer $customer) {
                return $customer->getDistanceInKmTo(
                        $this->officeLatitude,
                        $this->officeLongitude
                    ) < $this->minimumDistanceInKm;
            }
        );

        return $this->orderCustomers($filteredCustomers);
    }

    /**
     * @param array|Customer[] $customers
     *
     * @return array|Customer[]
     */
    private function orderCustomers(array $customers): array
    {
        usort(
            $customers,
            function ($first, $second) {
                return $first->getId() > $second->getId();
            }
        );

        return $customers;
    }
}
