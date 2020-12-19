<?php

namespace App\DataFixtures;

use App\Entity\Adresse;
use App\Entity\Patient;
use App\Entity\Practicien;
use App\Entity\Specialite;
use App\Entity\Consultation;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ConsultationFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        for ($i = 1; $i <= 5; $i++) {
            $patient = (new Patient())->setNom("DAVID$i")->setPrenom("DAVID$i")->setPassword("12345$i")->setDateNaissance(new \DateTime("2020/01/2$i"))->setEmail("e.d@C.E")->setPassword("12345$i");

            $adresse = (new Adresse())->setNumRue(25)->setRue('rue de la rue')->setCodePostal(15260)->setVille('ville');

            $specialite = (new Specialite())->setSpecialite('generaliste');
            $practicien = (new Practicien())->setNom("DAVID$i")->setPrenom("DAVID$i")->setEmail('e.b@d.c')->setAdresse($adresse)->setSpecialite($specialite)->setPassword("12345$i");

            $consultation = (new Consultation())->setDateRdv(new \DateTime("2020/12/0$i"))
                ->setPracticien($practicien)->setPatient($patient);
            $manager->persist($adresse);
            $manager->persist($patient);
            $manager->persist($practicien);
            $manager->persist($consultation);
        }

        $manager->flush();
    }
}
