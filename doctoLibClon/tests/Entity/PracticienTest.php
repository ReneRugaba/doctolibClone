<?php

namespace App\tests\Entity;

use App\Entity\Practicien;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PracticienTest extends KernelTestCase
{
    private $validator;


    protected function setUp()
    {
        self::bootKernel();
        $this->validator = self::$container->get("validator");
    }


    public function testGetterSetterNom()
    {
        $practicien = $this->getPracticien("NomFamille");
        $this->assertEquals("NomFamille", $practicien->getNom(), "erreur: testGetterSetterNom");
    }

    public function testGetterSetterPrenom()
    {
        $practicien = $this->getPracticien("NomFamille", "Prenom");
        $this->assertEquals("Prenom",  $practicien->getPrenom(), "erreur: testGetterSetterPrenom");
    }

    public function testGetterSetterEmail()
    {
        $practicien = $this->getPracticien("NomFamille", "Prenom", "e@mail.com");
        $this->assertEquals("e@mail.com", $practicien->getEmail(), "erreur: testGetterSetterEmail");
    }

    protected function getPracticien($nom = null, $prenom = null, $email = null)
    {
        return (new Practicien())->setNom($nom)->setPrenom($prenom)->setEmail($email);
    }


    public function testValidatePatien()
    {
        $practicien = $this->getPracticien("NomFamille", "Prenom", "e@mail.com");
        $error = $this->validator->validate($practicien);
        $this->assertCount(0, $error, "erreur: sur la fonction testValidatePatien()");
    }

    public function testMessageErreurNom()
    {
        $practicien = $this->getPracticien("", "Prenom", "e@mail.com");
        $error = $this->validator->validate($practicien);
        $this->assertEquals("le nom ne peux être vide!", $error[0]->getMessage(), "error: messageErreur");
    }

    public function testMessageErreurPrenom()
    {
        $practicien = $this->getPracticien("NomFamille", "", "e@mail.com");
        $error = $this->validator->validate($practicien);
        $this->assertEquals("le prenom ne peux être vide!", $error[0]->getMessage(), "error: messageErreur");
    }

    public function testMessageErreurEmail()
    {
        $practicien = $this->getPracticien("NomFamille", "prenom", "email.com");
        $error = $this->validator->validate($practicien);
        $this->assertEquals("Votre email n'est pas valide!", $error[0]->getMessage(), "error: messageErreur");
    }
}
