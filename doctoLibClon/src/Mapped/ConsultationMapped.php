<?php

namespace App\Mapped;

use App\DTO\ConsultationDto;
use App\Entity\Consultation;
use App\Entity\Patient;
use App\Entity\Practicien;
use DateTime;

class ConsultationMapped
{
    private $consultationDto;


    public function __construct(ConsultationDto $consultationDto)
    {
        $this->consultationDto = $consultationDto;
    }


    public function transformeConsultationDtoToConsultation(Consultation $consultation, ConsultationDto $consultationDto, Patient $patient, Practicien $practicien): Consultation
    {
        $consultation->setDateRdv(new DateTime($consultationDto->getDateRdv()))->setPatient($patient)->setPracticien($practicien);
        return $consultation;
    }

    public function transformeConsultationToConsultationDto(ConsultationDto $consultationDto, Consultation $consultation)
    {
        $consultationDto->setId($consultation->getId())->setDateRdv($consultation->getDateRdv()->format("d-m-Y"))
            ->setPatient($consultation->getPatient()->getId())->setPracticien($consultation->getPracticien()->getId());
        return $consultationDto;
    }
}
