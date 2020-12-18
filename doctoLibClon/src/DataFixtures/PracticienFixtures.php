<?php

namespace App\DataFixtures;

use App\Entity\Adresse;
use App\Entity\Practicien;
use App\Entity\Specialite;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PracticienFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 5; $i++) {
            $adresse = (new Adresse())->setNumRue(25)->setRue('rue de la rue')->setCodePostal(15260)->setVille('ville');

            $specialite = (new Specialite())->setSpecialite('generaliste');
            $practicien = (new Practicien())->setNom("DAVID$i")->setPrenom("DAVID$i")->setEmail('e.b@d.c')->setAdresse($adresse)->setSpecialite($specialite);
            $manager->persist($practicien);
            $manager->persist($specialite);
            $manager->persist($adresse);
        }

        $manager->flush();
    }
}
