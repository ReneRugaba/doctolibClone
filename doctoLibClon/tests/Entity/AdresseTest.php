<?php


namespace App\tests\Entity;

use App\Entity\Adresse;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class  AdresseTest extends KernelTestCase
{

    private $validator;

    protected function setUp()
    {
        self::bootKernel();
        $this->validator = self::$container->get('validator');
    }

    public function getAdresseRdv($numRue = null, $rue = null, $codePostal = null, $ville = null)
    {
        return (new Adresse())->setNumRue($numRue)->setRue($rue)->setCodePostal($codePostal)->setVille($ville);
    }

    public function testSetterGetterNumRue()
    {
        $adresse = $this->getAdresseRdv(50);
        $this->assertEquals(50, $adresse->getNumRue(), 'erreur: testSetterGetterNumRue');
    }

    public function testSetterGetterRue()
    {
        $adresse = $this->getAdresseRdv(50, 'rue inconnu');
        $this->assertEquals('rue inconnu', $adresse->getRue(), 'erreur: testSetterGetterNumRue');
    }

    public function testSetterGetterCodePostal()
    {
        $adresse = $this->getAdresseRdv(50, 'rue inconnu', 60000);
        $this->assertEquals(60000, $adresse->getCodePostal(), 'erreur: testSetterGetterNumRue');
    }

    public function testSetterGetterVille()
    {
        $adresse = $this->getAdresseRdv(50, 'rue inconnu', 60000, 'ville');
        $this->assertEquals('ville', $adresse->getVille(), 'erreur: testSetterGetterNumRue');
    }

    public function testErreur()
    {
        $adresse = $this->getAdresseRdv(50, 'rue inconnu', 60000, 'ville');
        $erreur = $this->validator->validate($adresse);
        $this->assertCount(0, $erreur, 'erreur: testErreur()');
    }
}
