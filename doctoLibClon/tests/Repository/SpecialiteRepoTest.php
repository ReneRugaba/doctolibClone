<?php

namespace App\tests\Repository;

use App\DataFixtures\SpecialiteFixtures;
use App\Repository\SpecialiteRepository;
use App\DataFixtures\Specialite2Fixtures;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SpecialiteRepoTest extends KernelTestCase
{

    use FixturesTrait;

    private $specialiteRepo;

    protected function setUp()
    {
        self::bootKernel();
        $this->specialiteRepo = self::$container->get(SpecialiteRepository::class);
    }

    public function testFindAll()
    {
        $this->loadFixtures([SpecialiteFixtures::class]);
        $array = $this->specialiteRepo->findAll();
        $this->assertCount(5, $array);
    }

    public function testFind()
    {
        $this->loadFixtures([SpecialiteFixtures::class]);
        $specialite = $this->specialiteRepo->find(1);
        $this->assertEquals(1, $specialite->getId());
    }

    public function testFindOneBy()
    {
        $this->loadFixtures([SpecialiteFixtures::class]);
        $specialite = $this->specialiteRepo->findOneBy(["id" => 1]);
        $this->assertEquals(1, $specialite->getId());
    }

    public function testFindBy()
    {
        $this->loadFixtures([SpecialiteFixtures::class]);
        $specialite = $this->specialiteRepo->findBy(["id" => 1]);
        $this->assertCount(1, $specialite);
    }

    protected function tearDown()
    {
        $this->loadFixtures([Specialite2Fixtures::class]);
    }
}
