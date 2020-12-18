<?php

namespace App\DataFixtures;

use App\Entity\Specialite;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class SpecialiteFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 5; $i++) {
            $specialite = (new Specialite())->setSpecialite("generaliste$i");
            $manager->persist($specialite);
        }

        $manager->flush();
    }
}
