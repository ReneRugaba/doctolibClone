<?php

namespace App\DataFixtures;

use App\Entity\Patient;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PatientFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 5; $i++) {
            $patient = (new Patient())->setNom("DAVID$i")->setPrenom("DAVID$i")->setPassword("12345$i")
                ->setDateNaissance(new \DateTime("2020/01/2$i"))->setEmail("e.d@C.E")->setPassword("12345$i");
            $manager->persist($patient);
        }

        $manager->flush();
    }
}
