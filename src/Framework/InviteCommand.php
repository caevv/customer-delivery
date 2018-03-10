<?php

namespace Framework;

use OfficeInvitation\InviteListService;
use Infrastructure\FileCustomerRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InviteCommand extends Command
{
    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    /**
     * @var InviteListService
     */
    private $inviteListService;

    public function __construct(array $config)
    {
        parent::__construct();

        $this->customerRepository = new FileCustomerRepository();
        $this->inviteListService = new InviteListService(
            $config['dublin_office']['latitude'],
            $config['dublin_office']['longitude'],
            $config['minimum_distance_in_km']
        );
    }

    protected function configure()
    {
        $this
            ->setName('prepare-invite')
            ->setDescription('Get a list of customers within 100km')
            ->addArgument('customers', InputArgument::REQUIRED, 'text file list of customers')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $customers = $this->customerRepository->fetchCustomersFromFile($input->getArgument('customers'));
        $customers = $this->inviteListService->getOrderedCustomersWithinRadios($customers);

        if (empty($customers)) {
            $output->writeln("No customers within range");

            return;
        }

        foreach ($customers as $customer) {
            $output->writeln(sprintf("Id: %s, Name: %s", $customer->getId(), $customer->getName()));
        }
    }
}
