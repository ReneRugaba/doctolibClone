<?php

namespace App\Controller;

use App\DTO\ConsultationDto;
use App\DTO\PatientDto;
use App\DTO\PracticienDto;
use App\Entity\Consultation;
use App\Entity\Patient;
use App\Entity\Practicien;
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
    const URI_PATIENT_ADD_INSTANCE = "/patients/add_consultation";
    const URI_PATIENT_CHOW_INSTANCE = "/patients/consultation";

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
    public function updatePatient(Patient $patient, PatientDto $patientDto) //ici je recupère le Post
    //que je converti en PatientDto et grâce au paramètre de id de URI je recupère le patient à modifier dans ma bdd
    {
        try { //ici je passe en argu mes para ci-dessus à la methode persist de ma couche service
            $this->patientService->persist($patient, $patientDto);
        } catch (ServiceException $e) { //dans le cas ou une exception est emise j'expose celle-ci en json
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => ""]);
        }
        return View::create([], Response::HTTP_OK, ["Content-type" => "Application/json"]); //si l'opération s'est fait
        //sans problèmes je retourne une réponse http 200 en json
    }

    /**
     * @Delete(PatientController::URI_PATIENT_INSTANCE)
     * 
     * @return void
     */
    public function removePatient(Patient $patient) //cette methode va supprimer un patient choisi
    {
        try { //ici je passe en argu mon para ci-dessus à la methode removePatient de ma couche service
            $this->patientService->removePatient($patient);
        } catch (ServiceException $e) { //dans le cas ou une exception est emise j'expose celle-ci en json
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "Application/json"]);
        }
        return View::create([], Response::HTTP_OK, ["Content-type" => "Application/json"]); //si l'opération s'est fait
        //sans problèmes je retourne une réponse http 200 en json
    }


    /**
     * @Post(PatientController::URI_PATIENT_ADD_INSTANCE)
     * @ParamConverter("consultationDto",converter="fos_rest.request_body")
     * @return void
     */
    public function addRdv(ConsultationDto $consultationDto)
    {
        try {
            $this->patientService->addRdvConsult($consultationDto);
        } catch (ServiceException $e) {
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "Application/json"]);
        }
        return View::create([], Response::HTTP_OK, ["Content-type" => "Application/json"]);
    }
}
