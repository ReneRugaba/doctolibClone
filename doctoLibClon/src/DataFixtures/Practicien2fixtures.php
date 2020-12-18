<?php

namespace App\DataFixtures;

use Doctrine\Persistence\ObjectManager;
use App\Repository\PracticienRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;

class Practicien2fixtures extends Fixture
{
    private $practicienRepo;

    public function __construct(PracticienRepository $pract)
    {
        $this->practicienRepo = $pract;
    }

    public function load(ObjectManager $manager)
    {
        $array = $this->practicienRepo->findAll();
        foreach ($array as  $value) {
            $manager->remove($value);
        }

        $manager->flush();
    }
}
