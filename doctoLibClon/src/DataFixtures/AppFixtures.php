<?php

namespace App\DataFixtures;

use App\Repository\AdresseRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private $repository;

    public function __construct(AdresseRepository $repo)
    {
        $this->repository = $repo;
    }

    public function load(ObjectManager $manager)
    {
        $adress = $this->repository->findAll();
        foreach ($adress as $adresse) {
            $manager->remove($adresse);
        }
        $manager->flush();
    }
}
