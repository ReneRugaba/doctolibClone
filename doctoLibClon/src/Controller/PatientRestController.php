<?php

namespace App\Controller;

use App\DTO\PatientDto;
use App\Entity\Patient;
use App\DTO\ConsultationDto;
use App\Entity\Consultation;
use FOS\RestBundle\View\View;
use OpenApi\Annotations as OA;
use App\Service\PatientService;
use FOS\RestBundle\Request\ParamFetcher;
use App\Service\Exception\ServiceException;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\Annotations\FileParam;

/**
 * @OA\Info(
 *      description="Praticien and Patient Management",
 *      version="V1",
 *      title="Praticien and Patient Management"
 * )
 */
class PatientRestController extends AbstractFOSRestController
{
    private $patientService;
    const URI_PATIENT_COLLECTION = "/patients";
    const URI_PATIENT_CREATE = "/patients/create";
    const URI_PATIENT_INSTANCE = "/patients/{id}";
    const URI_PATIENT_INSTANCE_USER = "/patients/{username}";
    const URI_PATIENT_ADD_INSTANCE = "/patients/consultations";
    const URI_PATIENT_DELETE_INSTANCE = "/patients/consultations/{id}";
    const URI_PATIENT_SHOW_INSTANCE = "/patients/{id}/consultations";
    const URI_PATIENT_IMAGES = "/patients/{id}/images";


    public function __construct(PatientService $patienService)
    {
        $this->patientService = $patienService;
    }

    /** 
     * @OA\Get(
     *     path="/patients/{username}",
     *     summary="Find one Patient",
     *     description="Returns one Patient",
     *     operationId="getCurrentUser",
     *     tags={"patient"},
     *     @OA\Parameter(
     *         description="Parameter with mutliple examples",
     *         in="path",
     *         name="username",
     *         required=true),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/PatientDto")
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Contact us, for this response"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Patients not found"
     *     )
     * )
     *
     * @Get(PatientRestcontroller::URI_PATIENT_INSTANCE_USER)
     * 
     */
   public function getCurrentUser(string $username){
    
    try {
        $patientDto=$this->patientService->findCurrentUser($username);
    } catch (ServiceException $e) {
        return View::create([],Response::HTTP_INTERNAL_SERVER_ERROR,["Content-type"=>"Application/json"]);
    }
        if($patientDto){
            return View::create($patientDto, Response::HTTP_OK, ["Content-type"=>"application/json"]);
        }else{
            return View::create([], Response::HTTP_NOT_FOUND, ["Content-type"=>"application/json"]);
        }
    }


    /**
     * 
     * @OA\Post(
     *     path="/patients",
     *     summary="Find one Patient",
     *     description="Returns one Patient",
     *     operationId="searchPatient",
     *     tags={"patient"},
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/PatientDto")
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Contact us, for this response"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Patients not found"
     *     ), @OA\Parameter(
     *         name="nom",
     *         in="query",
     *         description="Status values that needed to be considered for filter",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             type="array",
     *             default="available",
     *             @OA\Items(
     *                 type="string"
     * 
     *             )
     *         )
     *     )
     * )
     * @Post(PatientRestController::URI_PATIENT_COLLECTION)
     * @QueryParam(name="nom",requirements="\w+",description="name patient")
     */
    public function searchPatient(ParamFetcher $request): View 
    {
        try {
            
            $patients = $this->patientService->searchPatient(["nom" => $request->get('nom')]);
           
        } catch (ServiceException $e) { //dans le cas ou une exception est throw, j'expose l'erreur en json
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "Application/json"]);
        }
        if ($patients) { //je verifie que mon patient existe et je retourne le resultat
            return View::create($patients, Response::HTTP_OK, ["Content-Type" => "Application/json"]);
        } else { //dans le cas contraire je retourne un 404 
            return View::create([], Response::HTTP_NOT_FOUND, ["Content-type" => "Application/json"]);
        }
    }

    /**
     * @OA\Post(
     *     path="/patients",
     *     summary="create Patient",
     *     description="create Patient",
     *     operationId="createPatient",
     *     tags={"patient"},
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/PatientDto")
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Contact us, for this response"
     *     )
     * )
     * @Post(PatientRestController::URI_PATIENT_CREATE)
     * @ParamConverter("patientDto",converter="fos_rest.request_body")
     * @return View
     */
    public function createPatient(PatientDto $patientDto): View //cette methode crée des Patients
    {
        try { //ici je fait appel à la methode persist de ma class PatientService
            // PatientService pour persist en lui donnant une instance de patient et PatientDto
            $this->patientService->persistPatient(new Patient, $patientDto);
        } catch (ServiceException $e) { //dans le cas ou une erreur se produit coté serveur je retourne l'exception
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "Application/json"]);
        }
        return View::create([], Response::HTTP_CREATED, ["Content-type" => "Application/json"]); //je retourne le resultat du Post en retournant une repnse http 200
    }


    /**
     * @OA\Put(
     *     path="/patients/{id}",
     *     summary="update Patient",
     *     description="update Patient",
     *     operationId="updatePatient",
     *     tags={"patient"},
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/PatientDto")
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Contact us, for this response"
     *     ),
     *      @OA\Response(
     *         response="404",
     *         description="Patients not found"
     *     ),
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id of patient to return",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     )
     * )
     * @Put(PatientRestController::URI_PATIENT_INSTANCE)
     * @Paramconverter("patientDto",converter="fos_rest.request_body")
     * @return void
     */
    public function updatePatient(Patient $patient, PatientDto $patientDto): View //ici je recupère le Put
    //que je converti en PatientDto et grâce au paramètre de id de URI je recupère le patient à modifier dans ma bdd
    {
        
        try { //ici je passe en argu mes para ci-dessus à la methode persist de ma couche service
            
           
            $newPatient=$this->patientService->persistPatient($patient, $patientDto);
           
        } catch (ServiceException $e) { //dans le cas ou une exception est emise j'expose celle-ci en json
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => ""]);
        }
           
            return View::create($newPatient, Response::HTTP_CREATED, ["Content-type" => "Application/json"]); //si l'opération s'est fait
        //sans problèmes je retourne une réponse http 200 en json
    }

    /**
     * @OA\Delete(
     *     path="/patients/{id}",
     *     summary="delete Patient",
     *     description="delete Patient",
     *     operationId="removePatient",
     *     tags={"patient"},
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/PatientDto")
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Contact us, for this response"
     *     ),
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id of patient to return",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     )
     * )
     * @Delete(PatientRestController::URI_PATIENT_INSTANCE)
     * 
     * @return void
     */
    public function removePatient(Patient $patient): View //cette methode va supprimer un patient choisi
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
     * @OA\Post(
     *     path="/patients/consultations",
     *     summary="add meeting Patient",
     *     description="add meeting Patient",
     *     operationId="addRdv",
     *     tags={"patient"},
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ConsultationDto")
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Contact us, for this response"
     *     ),
     *      @OA\Response(
     *         response="404",
     *         description="Patients not found"
     *     )
     * )
     * @Post(PatientRestController::URI_PATIENT_ADD_INSTANCE)
     * @ParamConverter("consultationDto",converter="fos_rest.request_body")
     * @return void
     */
    public function addRdv(ConsultationDto $consultationDto): View
    {
        try {
            $this->patientService->addRdvConsult($consultationDto);
        } catch (ServiceException $e) {
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "Application/json"]);
        }
        return View::create([], Response::HTTP_OK, ["Content-type" => "Application/json"]);
    }

    /**
     * @OA\Delete(
     *     path="/patients/consultations/{id}",
     *     summary="delete Patient consultation",
     *     description="delete Patient consultation",
     *     operationId="deleteRdv",
     *     tags={"patient"},
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ConsultationDto")
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Contact us, for this response"
     *     ),
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id of consultation to return",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     )
     * )
     * @Delete(PatientRestController::URI_PATIENT_DELETE_INSTANCE)
     * 
     * @return void
     */
    public function deleteRdv(Consultation $consultation): View
    {
        try {
            $this->patientService->removeConsultation($consultation);
        } catch (ServiceException $e) {
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "Application/json"]);
        }
        return View::create([], Response::HTTP_OK, ["Content-type" => "Application/json"]);
    }

    /**
     * @OA\Get(
     *     path="/patients/{id}/consultations",
     *     summary="read Patient consultation",
     *     description="read Patient consultation",
     *     operationId="readRdv",
     *     tags={"patient"},
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ConsultationDto")
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Contact us, for this response"
     *     ),
     *      @OA\Response(
     *         response="404",
     *         description="Patients not found"
     *     ),
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id of patient to return",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     )
     * )
     * @Get(PatientRestController::URI_PATIENT_SHOW_INSTANCE)
     *
     * @return void
     */
    public function readRdv(Patient $patient): View
    {
        try {
            $consultArrayDto = $this->patientService->showConsultation($patient);
        } catch (ServiceException $e) {
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "Application/json"]);
        }
        if ($consultArrayDto) {
            return View::create($consultArrayDto, Response::HTTP_OK, ["Content-type" => "Application/json"]);
        } else {
            return View::create([], Response::HTTP_NOT_FOUND, ["Content-type" => "Application/json"]);
        }
    }



    /**
     * 
     * @Post(PatientRestController::URI_PATIENT_IMAGES)
     * @FileParam(name="image")
     * @return View
     */
    public function setPatientimage(ParamFetcher $params, Patient $patient){
    
       try {
        $fichier=$params->get('image');
        $destinationFile=$this->getParameter('image_dir');
        $this->patientService->setImagePatientTorepository($fichier,$patient,$destinationFile);
       } catch (ServiceException $e) {
           return View::create($e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR,["Content-type"=>"Application/json"]);
       }
       return View::create([],Response::HTTP_CREATED,["Content-type"=>"Application/json"]);
        
    }


}
