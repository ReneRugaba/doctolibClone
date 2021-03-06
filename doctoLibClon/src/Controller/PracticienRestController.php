<?php

namespace App\Controller;

use App\DTO\PracticienDto;
use App\Entity\Practicien;
use FOS\RestBundle\View\View;
use OpenApi\Annotations as OA;
use App\Service\PracticienService;
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

/**
 * @OA\Info(
 *      description="Praticien and Patient  Management",
 *      version="V1",
 *      title="Praticien and Patient Management"
 * )
 */
class PracticienRestController extends AbstractFOSRestController
{
    private $practicienService;

    // constantes qui me permettent de centraliser les chemins liés à mes différentes methodes
    const URI_REST_COLLECTION = "/praticiens";
    const URI_REST_INSTANCE = "/practiciens/{id}";

    public function __construct(PracticienService $practicienService)
    {
        $this->practicienService = $practicienService; // je centralise l'instanciation des objets Practicienservice pour 
        //les rendre disponible dans mes differentes methodes, grâce à l'attribu $practicienService de ma class PracticienRestController
    }

    /**
     * 
     * @OA\Get(
     *     path="/practiens",
     *     summary="Find paticien's array whith params",
     *     description="Returns array practiens",
     *     operationId="searchAllByIndex",
     *     tags={"practicien"},
     *      @OA\Parameter(
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/PracticienDto")
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Contact us, for this response"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Patients not found"
     *     ),@OA\Parameter(
     *         name="specialite",
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
     *     ),@OA\Parameter(
     *         name="ville",
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
     * @Get(PracticienRestController::URI_REST_COLLECTION)
     * @QueryParam(name="specialite")
     * @QueryParam(name="ville")
     */
    public function searchAllByIndex(ParamFetcher $request) //cette methode me retourne l'ensembre de mes practiciens
    {
        
        try { //ici je passe passe en argument un tableau associatif avec les paramRequest que j'ai recuperé l'URI
            $practiciens = $this->practicienService->searchAll(["specialite"=>$request->get('specialite'),
                                                                "ville"=>$request->get('ville')]);
        } catch (ServiceException $e) { //ici je recupère toutes les exceptions interne à la base de donnée
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]); //ici je les retourne
        }

        if ($practiciens) { // si un tableau, d'objet de Practiciens, m'est retourné par ma ma couche service, j'expose le fresultat en Json
            return View::create($practiciens, Response::HTTP_OK, ["Content-type" => "application/json"]);
        } else { // dans le cas ou aucun objet Practicien m'est retourné par ma ma couche service, j'expose le fresultat en Json également
            return View::create([], Response::HTTP_NOT_FOUND, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Post(
     *     path="/practiens",
     *     summary="creat praticien",
     *     description="creat praticien",
     *     operationId="creatPracticien",
     *     tags={"practicien"},
     *      @OA\Parameter(
     *         @OA\Schema(
     *             type="object",
     *             @OA\Items(
     *                 type="object",
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/PracticienDto")
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Contact us, for this response"
     *     )
     * )
     * @Post(PracticienRestController::URI_REST_COLLECTION)
     * @ParamConverter("practicienDto",converter="fos_rest.request_body")
     * @return 
     */
    public function creatPracticien(PracticienDto $practicienDto) //cette methode crée les practiciens. symfony converti mon Post en PracticienDto 
    //grâce au paramconevrteur fos_rest qui utilise la proriété request_body
    {
        try { //ici je passe par l'attribut de ma class pour avoir accès à la methode percist de la class PracticienService 
            // en lui donant en argu new Practicien(), $practicienDto
            $this->practicienService->percist(new Practicien(), $practicienDto);
        } catch (ServiceException $e) { //ici je recupère toutes les exceptions interne à la base de donnée
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "Application/json"]);
        }
    }


    /**
     * @OA\Delete(
     *     path="/practiciens/{id}",
     *     summary="creat practicien",
     *     description="creat practicien",
     *     operationId="creatPracticien",
     *     tags={"practicien"},
     *      @OA\Parameter(
     *         @OA\Schema(
     *             type="object",
     *             @OA\Items(
     *                 type="object",
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/PracticienDto")
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
     * @Delete(PracticienRestController::URI_REST_INSTANCE)
     *
     * @return void
     */
    public function remove(Practicien $practicien) //cette methode supprime les practiciens. symfony converti  l'Id du path en Practicien 
    //grâce au paramconevrteur fos_rest qui utilise la proriété request_body
    {
        try { //ici je passe par l'attribut de ma class pour avoir accès à la methode removePracticien de la class PracticienService 
            // en lui donant en argu $practicien
            $this->practicienService->removePracticien($practicien);
        } catch (ServiceException $e) { //ici je recupère toutes les exceptions interne à la base de donnée
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "Application/json"]);
        } // dans le cas ou aucun objet Practicien n'est trouvé par ma ma couche service, j'expose le fresultat en Json également
        return View::create([], Response::HTTP_NO_CONTENT, ["Content-type" => "Application/json"]);
    }

    /**
     *  @OA\Put(
     *     path="/practiciens/{id}",
     *     summary="creat practicien",
     *     description="creat practicien",
     *     operationId="creatPracticien",
     *     tags={"practicien"},
     *      @OA\Parameter(
     *         @OA\Schema(
     *             type="PracticienDto",
     *             @OA\Items(
     *                 type="object",
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/PracticienDto")
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Contact us, for this response"
     *     )
     * )
     * @Put(PracticienRestController::URI_REST_INSTANCE)
     * @paramConverter("practicienDto",converter="fos_rest.request_body")
     * @return void
     */
    public function updatePracticien(Practicien $practicien, PracticienDto $practicienDto) //cette methode modifie les practiciens. symfony retrouve le practicien coresposndant et l'ingecte
    //grâce au paramconevrteur fos_rest qui utilise la proriété request_body
    {
        try { //ici je passe par l'attribut de ma class pour avoir accès à la methode percist de la class PracticienService 
            // en lui donant en argu new Practicien(), $practicienDto
            $this->practicienService->percist($practicien, $practicienDto);
        } catch (ServiceException $e) { //ici je recupère toutes les exceptions interne à la base de donnée
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "Application/json"]);
        }
    }
}
