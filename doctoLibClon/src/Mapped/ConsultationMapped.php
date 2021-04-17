<?php

namespace App\Mapped;

use App\DTO\ConsultationDto;
use App\DTO\PatientDto;
use App\DTO\PracticienDto;
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

    public function transformeConsultationToConsultationDto(ConsultationDto $consultationDto, Consultation $consultation,PatientDto $patientDto=null,PracticienDto $praticienDto=null)
    {
        $consultationDto->setId($consultation->getId())->setDateRdv($consultation->getDateRdv()->format("d-m-Y H:i:s"))
            ->setPatient($patientDto)->setPracticien($praticienDto);
        return $consultationDto;
    }
}
