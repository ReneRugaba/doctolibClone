<?php

namespace App\DataFixtures;

use Doctrine\Persistence\ObjectManager;
use App\Repository\SpecialiteRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;

class Specialite2Fixtures extends Fixture
{
    private $specialiteRepo;

    public function __construct(SpecialiteRepository $repo)
    {
        $this->specialiteRepo = $repo;
    }

    public function load(ObjectManager $manager)
    {
        $array = $this->specialiteRepo->findAll();
        foreach ($array as  $value) {
            $manager->remove($value);
        }

        $manager->flush();
    }
}
