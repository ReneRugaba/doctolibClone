<?php

namespace App\tests\Entity;

use App\Entity\Adresse;
use App\Entity\Consultation;
use App\Entity\Patient;
use App\Entity\Practicien;
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
        $patient = $this->getPatient("NomFamille", "Prenom", "2020/12/16", "e@mail.com","123456");
        $this->assertEquals("e@mail.com", $patient->getEmail(), "erreur: testGetterSetterEmail");
    }

    protected function getPatient($nom = null, $prenom = null, $dateNaissance = null, $email = null, $password = null)
    {
        return (new Patient())->setNom($nom)->setPrenom($prenom)->setDateNaissance(new \DateTime($dateNaissance))->setEmail($email)->setPassword($password);
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

    public function testAddGetRemoveConsultationPatient()
    {
        $patien = $this->getPatient("NomFamille", "prenom", "2020/12/16", "email.com");
        $adresse = (new Adresse())->setNumRue(25)->setRue('rue de la rue')->setCodePostal(15260)->setVille('ville');
        $practicien = (new Practicien())->setNom('DAVID')->setPrenom('Dev')->setEmail('e.b@d.c')->setAdresse($adresse);
        $rdvConsult = (new Consultation())->setDateRdv(new \DateTime('2020/12/20'))->setPracticien($practicien)->setPatient($patien);
        $patien->addConsultation($rdvConsult);
        $this->assertCount(1, $patien->getConsultations());
        $patien->removeConsultation($rdvConsult);
        $this->assertCount(0, $patien->getConsultations());
    }

    public function testAddGetRemovePracticienPatient()
    {
        $patien = $this->getPatient("NomFamille", "prenom", "2020/12/16", "email.com");
        $adresse = (new Adresse())->setNumRue(25)->setRue('rue de la rue')->setCodePostal(15260)->setVille('ville');
        $practicien = (new Practicien())->setNom('DAVID')->setPrenom('Dev')->setEmail('e.b@d.c')->setAdresse($adresse);
        $patien->addPracticien($practicien);
        $this->assertCount(1, $patien->getPracticien());
        $patien->removePracticien($practicien);
        $this->assertCount(0, $patien->getPracticien());
    }
}
