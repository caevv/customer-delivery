<?php

namespace E2E;

use Framework\InviteCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Config\FileLocator;


trait CanRunApplication
{
    public function run(string $filePath)
    {
        $configDirectory = array(__DIR__.'/../../../config');

        $fileLocator = new FileLocator($configDirectory);
        $yamlUserFiles = $fileLocator->locate('config.yml', null, true);

        $configValues = Yaml::parse(file_get_contents($yamlUserFiles));

        $application = new Application();
        $application->add(new InviteCommand($configValues));

        $command = $application->find('prepare-invite');

        $commanderTest = new CommandTester($command);
        $commanderTest->execute(['customers' => $filePath]);
    }
}
