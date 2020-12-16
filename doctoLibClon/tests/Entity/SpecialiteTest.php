<?php

namespace App\tests\Entity;

use App\Entity\Specialite;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SpecialiteTest extends KernelTestCase
{

    private $validator;

    protected function setUp()
    {
        self::bootKernel();
        $this->validator = self::$container->get('validator');
    }

    public function getSpecialite($specialite)
    {
        return (new Specialite())->setSpecialite($specialite);
    }

    public function testSetterGetterSpecialite()
    {
        $specialite = $this->getSpecialite('Generaliste');
        $this->assertEquals('Generaliste', $specialite->getSpecialite(), 'error: testSetterGetterSpecialite()');
    }

    public function testErreurSpecialite()
    {
        $specialite = $this->getSpecialite('Generaliste');
        $error = $this->validator->validate($specialite);
        $this->assertCount(0, $error, 'erreur: testErreurSpecialite');
    }

    public function testErreur()
    {
        $specialite = $this->getSpecialite('vn');
        $erreur = $this->validator->validate($specialite);
        $this->assertEquals('une specialité ne peux pas faire moins de 4 mots!', $erreur[0]->getMessage());
    }
}
