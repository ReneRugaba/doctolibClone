<?php

namespace App\tests\Repository;

use App\DataFixtures\Practicien2fixtures;
use App\DataFixtures\PracticienFixtures;
use App\Repository\PracticienRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use liip\TestFixturesBundle\Test\FixturesTrait;

class PracticienRepoTest extends KernelTestCase
{

    use FixturesTrait;

    private $practicienRepo;


    protected function setUp()
    {
        self::bootKernel();
        $this->practicienRepo = self::$container->get(PracticienRepository::class);
    }

    public function testFindAll()
    {
        $this->loadFixtures([PracticienFixtures::class]);
        $array = $this->practicienRepo->findAll();
        $this->assertCount(5, $array);
    }

    public function testFindOneBy()
    {
        $this->loadFixtures([PracticienFixtures::class]);
        $practicien = $this->practicienRepo->findOneBy(['id' => 1]);
        $this->assertEquals(1, $practicien->getId());
    }

    public function testFindBy()
    {
        $this->loadFixtures([PracticienFixtures::class]);
        $array = $this->practicienRepo->findBy(['id' => 1]);
        $this->assertCount(1, $array);
    }

    public function testFind()
    {
        $this->loadFixtures([PracticienFixtures::class]);
        $practicien = $this->practicienRepo->find(1);
        $this->assertEquals(1, $practicien->getId());
    }


    protected function tearDown()
    {
        $this->loadFixtures([Practicien2fixtures::class]);
    }
}
