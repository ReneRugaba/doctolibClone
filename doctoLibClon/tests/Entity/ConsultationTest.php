<?php

namespace App\tests\Entity;

use App\Entity\Consultation;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ConsultationTest extends KernelTestCase
{
    private $validator;


    protected function setUp()
    {
        self::bootKernel();
        $this->validator = self::$container->get("validator");
    }

    public function testDateRdv()
    {
        $date = $this->getDateRdv('2020/12/16');
        $this->assertEquals('2020/12/16', $date->getDateRdv()->format("Y/m/d"), "erreur: testDateRdv");
    }

    protected function getDateRdv($date)
    {
        return (new Consultation())->setDateRdv(new \DateTime($date));
    }

    // public function testErreurDate()
    // {
    //     $date = $this->getDateRdv('2020/16');
    //     $erreur = $this->validator->validate($date);
    //     $this->assertCount(0, $erreur[0]->getMessage(), 'erreur: TestErreurDate');
    // }
}
