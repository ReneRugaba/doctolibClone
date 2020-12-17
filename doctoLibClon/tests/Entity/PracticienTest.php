<?php

namespace App\tests\Entity;

use App\Entity\Adresse;
use App\Entity\Practicien;
use App\Entity\Consultation;
use App\Entity\Patient;
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

    public function testAddGetRemoveConsultationPracticien()
    {
        $practicien = $this->getPracticien("NomFamille", "prenom", "2020/12/16", "email.com");
        $adresse = (new Adresse())->setNumRue(25)->setRue('rue de la rue')->setCodePostal(15260)->setVille('ville');
        $patient = (new Patient())->setNom('DAVID')->setPrenom('Dev')->setEmail('e.b@d.c')->setAdresse($adresse);
        $rdvConsult = (new Consultation())->setDateRdv(new \DateTime('2020/12/20'))->setPracticien($practicien)->setPatient($patient);
        $practicien->addConsultation($rdvConsult);
        $this->assertCount(1, $practicien->getConsultation());
        $practicien->removeConsultation($rdvConsult);
        $this->assertCount(0, $practicien->getConsultation());
    }

    public function testAddGetRemovePatientPracticien()
    {
        $practicien = $this->getPracticien("NomFamille", "prenom", "2020/12/16", "email.com");
        $adresse = (new Adresse())->setNumRue(25)->setRue('rue de la rue')->setCodePostal(15260)->setVille('ville');
        $patient = (new Patient())->setNom('DAVID')->setPrenom('Dev')->setEmail('e.b@d.c')->setAdresse($adresse);

        $practicien->addPatient($patient);
        $this->assertCount(1, $practicien->getPatient());
        $practicien->removePatient($patient);
        $this->assertCount(0, $practicien->getConsultation());
    }
}
