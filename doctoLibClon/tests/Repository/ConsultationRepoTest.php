<?php

namespace App\tests\Repository;

use App\DataFixtures\ConsultationFixtures;
use App\Repository\ConsultationRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use App\DataFixtures\Consultation2Fixtures;


class ConsultationRepoTest extends KernelTestCase
{
    private $repository;

    use FixturesTrait;

    public function setUp()
    {
        self::bootKernel();
        $this->repository = self::$container->get(ConsultationRepository::class);
    }


    public function testFindAll()
    {
        $this->loadFixtures([ConsultationFixtures::class]);
        $array = $this->repository->findAll();
        $this->assertCount(5, $array);
    }

    public function testFind()
    {
        $this->loadFixtures([ConsultationFixtures::class]);
        $consult = $this->repository->find(["id" => 1]);
        $this->assertEquals(1, $consult->getId());
    }

    public function testFindBy()
    {
        $this->loadFixtures([ConsultationFixtures::class]);
        $consult = $this->repository->findBy(["id" => 1]);
        $this->assertCount(1, $consult);
    }

    protected function tearDown()
    {
        $this->loadFixtures([Consultation2Fixtures::class]);
    }
}
