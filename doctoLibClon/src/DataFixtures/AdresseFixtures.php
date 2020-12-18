<?php

namespace App\DataFixtures;

use App\Entity\Adresse;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AdresseFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 5; $i++) {
            $adresse = (new Adresse())->setNumRue($i)->setRue("rue $i")
                ->setCodePostal(10000 + $i)->setVille("ville $i");
            $manager->persist($adresse);
        }
        $manager->flush();
    }
}
