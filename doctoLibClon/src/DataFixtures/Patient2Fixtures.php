<?php

namespace App\DataFixtures;

use App\Repository\PatientRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Patient2Fixtures extends Fixture
{
    private $repository;

    public function __construct(PatientRepository $repo)
    {
        $this->repository = $repo;
    }

    public function load(ObjectManager $manager)
    {
        $array = $this->repository->findAll();
        foreach ($array as  $value) {
            $manager->remove($value);
        }

        $manager->flush();
    }
}
