<?php

namespace App\Controller;

use App\DTO\PracticienDto;
use App\Entity\Practicien;
use FOS\RestBundle\View\View;
use App\Service\PracticienService;
use App\Service\Exception\ServiceException;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use App\Service\Exception\PracticienServiceException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class PracticienRestController extends AbstractFOSRestController
{
    private $practicienService;

    const URI_REST_COLLECTION = "/practiciens";
    const URI_REST_INSTANCE = "/practiciens/{id}";

    public function __construct(PracticienService $practicienService)
    {
        $this->practicienService = $practicienService;
    }

    /**
     * @Get(PracticienRestController::URI_REST_COLLECTION)
     */
    public function searchAll()
    {
        try {
            $practiciens = $this->practicienService->searchAll();
        } catch (ServiceException $e) {
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }

        if ($practiciens) {
            return View::create($practiciens, Response::HTTP_OK, ["Content-type" => "application/json"]);
        } else {
            return View::create([], Response::HTTP_NOT_FOUND, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @Post(PracticienRestController::URI_REST_COLLECTION)
     * @ParamConverter("practicienDto",converter="fos_rest.request_body")
     * @return 
     */
    public function creatPracticien(PracticienDto $practicienDto)
    {
        try {
            $this->practicienService->percist(new Practicien(), $practicienDto);
        } catch (ServiceException $e) {
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "Application/json"]);
        }
    }


    /**
     * @Delete(PracticienRestController::URI_REST_INSTANCE)
     *
     * @return void
     */
    public function remove(Practicien $practicien)
    {
        try {
            $this->practicienService->removePracticien($practicien);
        } catch (ServiceException $e) {
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "Application/json"]);
        }
        return View::create([], Response::HTTP_NO_CONTENT, ["Content-type" => "Application/json"]);
    }
}
