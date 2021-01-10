<?php

namespace App\Controller;

use App\DTO\PracticienDto;
use App\Entity\Practicien;
use FOS\RestBundle\View\View;
use App\Service\PracticienService;
use App\Service\Exception\ServiceException;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class PracticienRestController extends AbstractFOSRestController
{
    private $practicienService;

    // constantes qui me permettent de centraliser les chemins liés à mes différentes methodes
    const URI_REST_COLLECTION = "/practiciens";
    const URI_REST_INSTANCE = "/practiciens/{id}";

    public function __construct(PracticienService $practicienService)
    {
        $this->practicienService = $practicienService; // je centralise l'instanciation des objets Practicienservice pour 
        //les rendre disponible dans mes differentes methodes, grâce à l'attribu $practicienService de ma class PracticienRestController
    }

    /**
     * @Get(PracticienRestController::URI_REST_COLLECTION)
     */
    public function searchAll() //cette methode me retourne l'ensembre de mes practiciens
    {
        try { //ici je passe par l'attribut de ma class pour avoir accès à la methode searchAll de la class PracticienService
            $practiciens = $this->practicienService->searchAll();
        } catch (ServiceException $e) { //ici je recupère toutes les exceptions interne à la base de donnée
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]); //ici je les retourne
        }

        if ($practiciens) { // si un objet Practicien m'est retourné par ma ma couche service, j'expose le fresultat en Json
            return View::create($practiciens, Response::HTTP_OK, ["Content-type" => "application/json"]);
        } else { // dans le cas ou aucun objet Practicien m'est retourné par ma ma couche service, j'expose le fresultat en Json également
            return View::create([], Response::HTTP_NOT_FOUND, ["Content-type" => "application/json"]);
        }
    }

    /**
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
