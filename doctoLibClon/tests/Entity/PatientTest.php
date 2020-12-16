<?php

namespace App\tests\Entity;

use App\Entity\Patient;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PatientTest extends KernelTestCase
{
    private $validator;


    protected function setUp()
    {
        self::bootKernel();
        $this->validator = self::$container->get("validator");
    }


    public function testGetterSetterNom()
    {
        $patien = $this->getPatient("NomFamille");
        $this->assertEquals("NomFamille", $patien->getNom(), "erreur: testGetterSetterNom");
    }

    public function testGetterSetterPrenom()
    {
        $patient = $this->getPatient("NomFamille", "Prenom");
        $this->assertEquals("Prenom",  $patient->getPrenom(), "erreur: testGetterSetterPrenom");
    }

    public function testGetterSetterDateNaissance()
    {
        $patient = $this->getPatient("NomFamille", "Prenom", "2020/12/16");
        $this->assertEquals("2020/12/16",  $patient->getDateNaissance()->format("Y/m/d"), "erreur: testGetterSetterDateNaissance");
    }

    public function testGetterSetterEmail()
    {
        $patient = $this->getPatient("NomFamille", "Prenom", "2020/12/16", "e@mail.com");
        $this->assertEquals("e@mail.com", $patient->getEmail(), "erreur: testGetterSetterEmail");
    }

    protected function getPatient($nom = null, $prenom = null, $dateNaissance = null, $email = null)
    {
        return (new Patient())->setNom($nom)->setPrenom($prenom)->setDateNaissance(new \DateTime($dateNaissance))->setEmail($email);
    }


    public function testValidatePatien()
    {
        $patien = $this->getPatient("NomFamille", "Prenom", "2020/12/16", "e@mail.com");
        $error = $this->validator->validate($patien);
        $this->assertCount(0, $error, "erreur: sur la fonction testValidatePatien()");
    }

    public function testMessageErreurNom()
    {
        $patien = $this->getPatient("", "Prenom", "2020/12/16", "e@mail.com");
        $error = $this->validator->validate($patien);
        $this->assertEquals("le nom ne peux être vide!", $error[0]->getMessage(), "error: messageErreur");
    }

    public function testMessageErreurPrenom()
    {
        $patien = $this->getPatient("NomFamille", "", "2020/12/16", "e@mail.com");
        $error = $this->validator->validate($patien);
        $this->assertEquals("le prenom ne peux être vide!", $error[0]->getMessage(), "error: messageErreur");
    }

    public function testMessageErreurEmail()
    {
        $patien = $this->getPatient("NomFamille", "prenom", "2020/12/16", "email.com");
        $error = $this->validator->validate($patien);
        $this->assertEquals("Votre email n'est pas valide!", $error[0]->getMessage(), "error: messageErreur");
    }
}
