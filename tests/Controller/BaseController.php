<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BaseController extends WebTestCase
{
    protected ContainerInterface $appContainer;
    protected KernelBrowser      $client;


    protected function setUp(): void
    {
        parent::setUp();

        $this->client       = static::createClient();
        $this->appContainer = $this->client->getContainer();
    }

    public function generateCsrf()
    {
        return $this->client->getContainer()->get('security.csrf.token_manager')->getToken('general_csrf');
    }
}
