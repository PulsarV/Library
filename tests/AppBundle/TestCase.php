<?php

namespace Tests\AppBundle;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;

abstract class TestCase extends WebTestCase
{
    /** @var Client */
    protected $client;

    public function setUp()
    {
        parent::setUp();

        $this->client = static::createClient();
        $this->client->setServerParameters(['HTTP_HOST' => $this->client->getContainer()->getParameter('server_name')]);

        $this->runCommand(['command' => 'doctrine:database:drop', '--force' => true]);
        $this->runCommand(['command' => 'doctrine:database:create']);
        $this->runCommand(['command' => 'doctrine:schema:update', '--force' => true]);
        $this->runCommand(['command' => 'hautelook:doctrine:fixtures:load', '--no-interaction' => true]);
    }

    public function tearDown()
    {
        $this->runCommand(['command' => 'doctrine:database:drop', '--force' => true]);
        $this->client = null;

        parent::tearDown();
    }

    /**
     * @param array $arguments
     */
    protected function runCommand(array $arguments = [])
    {
        $kernel = $this->client->getKernel();
        $application = new Application($kernel);
        $application->setAutoExit(false);
        $arguments['--quiet'] = true;
        $arguments['-e'] = 'test';
        $input = new ArrayInput($arguments);
        $output = new ConsoleOutput();
        try {
            $application->run($input, $output);
        } catch (\Exception $e) {
            $output->write($e->getMessage());
        }
    }
}
