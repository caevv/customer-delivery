<?php

namespace Domain;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use OfficeInvitation\Customer;
use OfficeInvitation\InviteListService;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /**
     * @var array|Customer[]
     */
    private $customers;
    /**
     * @var float
     */
    private $minimumDistance;
    /**
     * @var float
     */
    private $officeLatitude;
    /**
     * @var float
     */
    private $officeLongitude;
    /**
     * @var array|Customer[]
     */
    private $customerList;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given the minimum distance to the office in km for the invitation is :distance
     */
    public function theMinimumDistanceToTheOfficeInKmForTheInvitationIs(float $distance)
    {
        $this->minimumDistance = $distance;
    }

    /**
     * @Given the dublin office is on latitude :latitude and longitude :longitude
     */
    public function theDublinOfficeIsOnLatitudeAndLongitude(float $latitude, float $longitude)
    {
        $this->officeLatitude = $latitude;
        $this->officeLongitude = $longitude;
    }

    /**
     * @Given I have the following customers:
     */
    public function iHaveTheFollowingCustomers(TableNode $table)
    {
        $customersData = $table->getColumnsHash();

        foreach ($customersData as $customerData) {
            $this->customers[] = new Customer(
                (int) $customerData['User id'],
                $customerData['Name'],
                (float) $customerData['Latitude'],
                (float) $customerData['Longitude']
            );
        }
    }

    /**
     * @When I prepare my invitation list
     */
    public function iPrepareMyInvitationList()
    {
        $inviteListService = new InviteListService(
            $this->officeLatitude,
            $this->officeLongitude,
            $this->minimumDistance
        );

        $this->customerList = $inviteListService->getOrderedCustomersWithinRadios($this->customers);
    }

    /**
     * @Then I should see the following list for invitation:
     */
    public function iShouldSeeTheFollowingListForInvitation(TableNode $table)
    {
        $customersData = $table->getColumnsHash();

        foreach ($customersData as $customerData) {
           $customer = array_shift($this->customerList);
            assert((int) $customerData['user id'] === $customer->getId(), 'user id');
            assert($customerData['name'] === $customer->getName(), 'name');
        }
    }

    /**
     * @Given I have a list with customers with distance more than 100km
     */
    public function iHaveAListWithCustomersWithDistanceMoreThanKm()
    {
        $this->customers[] = new Customer(1, 'some name', 111, -111);
        $this->customers[] = new Customer(2, 'other name', 222, -222);
    }

    /**
     * @Then I should receive no customer
     */
    public function iShouldReceiveNoCustomer()
    {
        assert(empty($this->customerList), 'empty list');
    }
}
