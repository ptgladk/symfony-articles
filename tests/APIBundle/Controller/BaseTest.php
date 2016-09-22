<?php

namespace Tests\APIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;

abstract class BaseTest extends WebTestCase
{
    /**
     * Set up
     */
    public function setUp()
    {
        $client = static::createClient();
        $application = new Application($client->getKernel());
        $application->setAutoExit(false);
        $application->run(new StringInput('doctrine:database:drop --force --quiet'));
        $application->run(new StringInput('doctrine:database:create --quiet'));
        $application->run(new StringInput('doctrine:schema:update --force --quiet'));
        $application->run(new StringInput('doctrine:fixtures:load --no-interaction --quiet'));
    }

    /**
     * Get token
     *
     * @param string $username
     * @param string $password
     * @return string|null
     */
    protected function getToken($username, $password)
    {
        $client = static::createClient();
        $client->request('POST', '/auth', array('username' => $username, 'password' => $password));
        $content = json_decode($client->getResponse()->getContent(), true);
        if ($content['status'] == 'success') {
            return $content['token'];
        }

        return null;
    }
}
