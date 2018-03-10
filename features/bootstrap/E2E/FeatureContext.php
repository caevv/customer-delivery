<?php

namespace E2E;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    use CanRunApplication;

    /**
     * @var string
     */
    private $customerList;
    /**
     * @var \Exception
     */
    private $exception;

    /**
     * @Given I have a wrong format customers list
     */
    public function iHaveAWrongFormatCustomersList()
    {
        $this->customerList = __DIR__.'/bad-list.txt';
    }

    /**
     * @When I prepare my invitation list
     */
    public function iPrepareMyInvitationList()
    {
        try {
            $this->run($this->customerList);
        } catch (\Exception $exception) {
            $this->exception = $exception;
        }
    }

    /**
     * @Then I should receive an error that the format is wrong
     */
    public function iShouldReceiveAnErrorThatTheFormatIsWrong()
    {
        assert(
            $this->exception->getMessage() ===
            'The provided list of customer is invalid: {"latitude": "51.92893" "user_id": 1, "name": "Alice Cahill", "longitude": "-10.27699"}',
            "asserting error message"
        );
    }

    /**
     * @Given I have a wrong file path
     */
    public function iHaveAWrongFilePath()
    {
        $this->customerList = 'non-existent-file.txt';
    }

    /**
     * @Then I should receive an error that the file is not found
     */
    public function iShouldReceiveAnErrorThatTheFileIsNotFound()
    {
        assert(
            $this->exception->getMessage() === "File {$this->customerList} not found",
            "asserting error message"
        );
    }
}
