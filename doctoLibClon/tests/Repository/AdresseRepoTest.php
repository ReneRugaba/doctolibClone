<?php

namespace App\tests\Repository;

use App\DataFixtures\AdresseFixtures;
use App\Repository\AdresseRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use App\DataFixtures\AppFixtures;

class  AdresseRepoTest extends KernelTestCase
{

    use FixturesTrait;

    private $repository;

    protected function SetUp()
    {
        self::bootKernel();
        $this->repository = self::$container->get(AdresseRepository::class);
    }

    public function testFindAllAdresse()
    {
        $this->loadFixtures([AdresseFixtures::class]);
        $adresse = $this->repository->findAll();
        $this->assertCount(5, $adresse);
    }

    public function testFindByAdresse()
    {
        $this->loadFixtures([AdresseFixtures::class]);
        $adresse = $this->repository->findby(["numRue" => 1]);
        $this->assertCount(1, $adresse);
    }

    public function testfind()
    {
        $this->loadFixtures([AdresseFixtures::class]);
        $adresse = $this->repository->findby(["id" => 1]);
        $this->assertCount(1, $adresse);
    }

    protected function tearDown()
    {
        $this->loadFixtures([AppFixtures::class]);
    }
}
