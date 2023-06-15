<?php

namespace App\Tests\Unit;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BaseUnit extends KernelTestCase
{

    protected ContainerInterface $appContainer;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    protected function setUp(): void
    {
        parent::bootKernel();

        $this->appContainer = self::$kernel->getContainer();

        $this->em = $this->appContainer
            ->get('doctrine')
            ->getManager();
    }


}
