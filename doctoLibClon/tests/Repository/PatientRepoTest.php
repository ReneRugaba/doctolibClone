<?php

namespace App\tests\Repository;

use App\DataFixtures\PatientFixtures;
use App\Repository\PatientRepository;
use App\DataFixtures\Patient2Fixtures;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PatientRepoTest extends KernelTestCase
{

    private $patientRepo;

    use FixturesTrait;

    protected function setUp()
    {
        self::bootKernel();
        $this->patientRepo = self::$container->get(PatientRepository::class);
    }



    public function testFindAll()
    {
        $this->loadFixtures([PatientFixtures::class]);
        $array = $this->patientRepo->findAll();
        $this->assertCount(5, $array);
    }

    public function testfindOneBy()
    {
        $this->loadFixtures([PatientFixtures::class]);
        $patient = $this->patientRepo->findOneBy(["id" => 1]);
        $this->assertEquals(1, $patient->getId());
    }

    public function testfindBy()
    {
        $this->loadFixtures([PatientFixtures::class]);
        $patient = $this->patientRepo->findBy(["id" => 1]);
        $this->assertCount(1, $patient);
    }

    public function testFind()
    {
        $this->loadFixtures([PatientFixtures::class]);
        $patient = $this->patientRepo->find(1);
        $this->assertEquals(1, $patient->getid());
    }

    protected function tearDown()
    {
        $this->loadFixtures([Patient2Fixtures::class]);
    }
}
