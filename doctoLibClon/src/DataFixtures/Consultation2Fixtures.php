<?php

namespace App\DataFixtures;


use App\Repository\ConsultationRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Consultation2Fixtures extends Fixture
{
    private $consultation;

    public function __construct(ConsultationRepository $consultation)
    {
        $this->consultation = $consultation;
    }
    public function load(ObjectManager $manager)
    {
        $consult = $this->consultation->findAll();
        foreach ($consult as $value) {
            $manager->remove($value);
        }

        $manager->flush();
    }
}
