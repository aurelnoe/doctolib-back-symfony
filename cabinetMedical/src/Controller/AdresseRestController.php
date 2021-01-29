<?php

namespace App\Controller;

use App\DTO\AdresseDTO;
use App\Entity\Adresse;
use App\Mapper\AdresseMapper;
use FOS\RestBundle\View\View;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use App\Service\Exception\AdresseServiceException;
use App\Service\ServiceAdresse;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
Use OpenApi\Annotations as OA;

class AdresseRestController extends AbstractFOSRestController
{
    private $adresseService;
    
    const URI_ADRESSE_COLLECTION = "/adresses";
    const URI_ADRESSE_INSTANCE = "/adresses/{id}";

    public function __construct(ServiceAdresse $adresseService, 
                                EntityManagerInterface $entityManager,
                                AdresseMapper $mapper){
        $this->adresseService = $adresseService;
        $this->entityManager = $entityManager;
        $this->adresseMapper = $mapper;
    }

    /**
     * @OA\Get(
     *      path="/adresses",
     *      tags={"Adresse"},
     *      summary="Returns a list of AdresseDTO",
     *      description="Returns a list of AdresseDTO",
     *      @OA\Response(
     *          response=200,
     *          description="Successfull operation",
     *          @OA\JsonContent(ref="#/components/schemas/AdresseDTO")
     *          ),
     *      @OA\Response(
     *          response=404,
     *          description="If no AdresseDTO found",
     *          @OA\JsonContent(ref="#/components/schemas/AdresseDTO")
     *          ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server Error. Please contact us",    
     *      )
     * )
     * 
     * @Get(AdresseRestController::URI_ADRESSE_COLLECTION)
     */
    public function searchAll()
    {
        try {
            $adresses = $this->adresseService->searchAll();
        } catch(AdresseServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
        if($adresses){
            return View::create($adresses, Response::HTTP_OK, ["Content-type" => "application/json"]);
        } else {
            return View::create($adresses, Response::HTTP_NOT_FOUND, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Post(
     *      path="/adresses",
     *      tags={"Adresse"},
     *      summary="Create AdresseDTO",
     *      description="This can only be done by the logged in user",
     *      @OA\Response(
     *          response=405,
     *          description="Invalid input",
     *          ),
     *      @OA\Response(
     *          response=201,
     *          description="Adresse inserted successfully",
     *          @OA\JsonContent(ref="#/components/schemas/AdresseDTO")
     *          ),
     *      @OA\RequestBody(
     *          description="AdresseDTO JSON Object",
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/AdresseDTO")
     *      )
     * )
     * 
     * @Post(AdresseRestController::URI_ADRESSE_COLLECTION)
     * @ParamConverter("adresseDto", converter="fos_rest.request_body")
     * @return void
     */
    public function create(AdresseDTO $adresseDto){
        try {
            $this->adresseService->persist(new Adresse(), $adresseDto,null);
            return View::create([], Response::HTTP_CREATED, ["Content-type" => "application/json"]);
        } catch (AdresseServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Delete(
     *      path="/adresses/{idAdresse}",
     *      tags={"Adresse"},
     *      summary="Delete purchase order by ID",
     *      description="For valid response try integer IDs with positive integer value. Negative or non-integer values will generate API errors",
     *      @OA\Parameter(
     *          name="idAdresse",
     *          in="path",
     *          required=true,
     *          description="ID of the order that needs to be deleted",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              minimum=1.0
     *          )
     *      ),
     *   @OA\Response(response=400, description="Invalid ID supplied"),
     *   @OA\Response(response=404, description="Order not found")
     * )
     * 
     * @Delete(AdresseRestController::URI_ADRESSE_INSTANCE)
     *
     * @param [type] $id
     * @return void
     */
    public function remove(Adresse $adresse){
        try {
            $this->adresseService->delete($adresse);
            return View::create([], Response::HTTP_NO_CONTENT, ["Content-type" => "application/json"]);
        } catch(AdresseServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Put(path="/adresses/{idAdresse}",
     *      tags={"Adresse"},
     *      summary="Updated Adresse",
     *      description="This can only be done by the logged in Adresse.",
     *      @OA\Parameter(
     *          name="idAdresse",
     *          in="path",
     *          description="id that need to be updated",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=400, 
     *          description="Invalid Adresse supplied"),
     *      @OA\Response(
     *          response=404, 
     *          description="Adresse not found"),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Updated user object",
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/AdresseDTO")
     *          )
     *      ),
     * ) 
     * 
     * @Put(AdresseRestController::URI_ADRESSE_INSTANCE)
     * @ParamConverter("adresseDto", converter="fos_rest.request_body")
     * @param AdresseDTO $adresseDto
     * @return void
     */
    public function update(Adresse $adresse, AdresseDTO $adresseDto){
        try {
            $this->adresseService->persist($adresse, $adresseDto);
            return View::create([], Response::HTTP_OK, ["Content-type" => "application/json"]);
        } catch (AdresseServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Get(
     *      path="/adresses/{id}",
     *      tags={"Adresse"},
     *      summary="Search one Adresse",
     *      operationId="searchById",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="Adresse trouvé",
     *          @OA\JsonContent(ref="#/components/schemas/AdresseDTO"),
     *          @OA\Link(link="AdresseDTO", ref="#/components/schemas/AdresseDTO")
     *      )
     * )
     * @Get(AdresseRestController::URI_ADRESSE_INSTANCE)
     *
     * @return void
     */
    public function searchById(int $id){
        try {
            $adresseDto = $this->adresseService->searchById($id);
        }catch (AdresseServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
        if($adresseDto){
            return View::create($adresseDto, Response::HTTP_OK, ["Content-type" => "application/json"]);
        } else {
            return View::create([], Response::HTTP_NOT_FOUND, ["Content-type" => "application/json"]);
        }
    }
}
