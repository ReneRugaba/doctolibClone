<?php

namespace App\Controller;

use App\DTO\PatientDto;
use App\Entity\Patient;
use FOS\RestBundle\View\View;
use App\Service\PatientService;
use App\Service\Exception\ServiceException;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class PatientController extends AbstractFOSRestController
{
    private $patientService;

    const URI_PATIENT_COLLECTION = "/patients";
    const URI_PATIENT_INSTANCE = "/patients/{id}";

    public function __construct(PatientService $patienService)
    {
        $this->patientService = $patienService;
    }


    /**
     * @Get(PatientController::URI_PATIENT_COLLECTION)
     */
    public function searchAllPatient() //cette methode retourne tout les patient de ma base de donnée
    {
        try { //ici je recuypère chacun de mes patient sou forme d'instance PatientDto
            $patients = $this->patientService->searchAll();
        } catch (ServiceException $e) { //dans le cas ou une exception est throw, j'expose l'erreur en json
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "Application/json"]);
        }
        if ($patients) { //je verifie que mon tableau contient bien les donnée souhaitées et je retourne le resultat
            return View::create($patients, Response::HTTP_OK, ["Content-Type" => "Application/json"]);
        } else { //dans le cas contraire je retourne un 404 
            return View::create([], Response::HTTP_NOT_FOUND, ["Content-type" => "Application/json"]);
        }
    }

    /**
     * @Post(PatientController::URI_PATIENT_COLLECTION)
     * @ParamConverter("patientDto",converter="fos_rest.request_body")
     * @return void
     */
    public function createPatient(PatientDto $patientDto) //cette methode crée des Patients
    {
        try { //ici je fait appel à la methode persist de ma class 
            // PatientService pour persist en lui donnant une instance de patient et PatientDto
            $this->patientService->persist(new Patient, $patientDto);
        } catch (ServiceException $e) { //dans le cas ou une erreur se produit coté srveur je retourne l'exception
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "Application/json"]);
        }
        return View::create([], Response::HTTP_OK, ["Content-type" => "Application/json"]); //je retourne le resultat du Post en retournant une repnse http 200
    }


    /**
     * @Put(PatientController::URI_PATIENT_INSTANCE)
     * @Paramconverter("patientDto",converter="fos_rest.request_body")
     * @return void
     */
    public function updatePatient(Patient $patient, PatientDto $patientDto)
    {
        try {
            $this->patientService->persist($patient, $patientDto);
        } catch (ServiceException $e) {
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => ""]);
        }
        return View::create([], Response::HTTP_OK, ["Content-type" => "Application/json"]);
    }

    /**
     * @Delete(PatientController::URI_PATIENT_INSTANCE)
     * 
     * @return void
     */
    public function removePatient(Patient $patient) //cette methode va supprimer un patient choisi
    {
        try {
            $this->patientService->removePatient($patient);
        } catch (ServiceException $e) {
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "Application/json"]);
        }
        return View::create([], Response::HTTP_OK, ["Content-type" => "Application/json"]);
    }
}
