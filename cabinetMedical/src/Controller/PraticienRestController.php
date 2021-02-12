<?php

namespace App\Controller;

use Exception;
use App\Service\Exception\PraticienServiceException;
use App\DTO\PraticienDTO;
use App\Entity\Praticien;
use FOS\RestBundle\View\View;
use App\Mapper\PraticienMapper;
use App\Service\ServicePraticien;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
Use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *      description="DoctoLib management",
 *      version="V1",
 *      title="DoctoLib management",
 * )
 */
class PraticienRestController extends AbstractFOSRestController
{
    private $praticienService;
    
    const URI_PRATICIEN_COLLECTION = "/praticiens";
    const URI_PRATICIEN_INSTANCE = "/praticiens/{id}";

    public function __construct(ServicePraticien $praticienService, 
                                EntityManagerInterface $entityManager,
                                PraticienMapper $mapper){
        $this->praticienService = $praticienService;
        $this->entityManager = $entityManager;
        $this->praticienMapper = $mapper;
    }
    
    /**
     * @OA\Get(
     *      path="/praticiens",
     *      tags={"Praticien"},
     *      summary="Returns a list of PraticienDTO",
     *      description="Returns a list of PraticienDTO",
     *      @OA\Parameter(
     *          name="ville",
     *          in="query",
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successfull operation",
     *          @OA\JsonContent(ref="#/components/schemas/PraticienDTO")
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="If no PraticienDTO found",
     *          @OA\JsonContent(ref="#/components/schemas/PraticienDTO")
     *      ),
     *      @OA\Response(
     *         response=500,
     *         description="Internal server Error. Please contact us",    
     *      )
     * )
     * 
     * @QueryParam(name="ville", requirements="[a-zA-Z]+", description="Ville")
     * @param string $ville
     * @QueryParam(name="adresse", requirements="[a-zA-Z]+", description="Adresse")
     * @param int $adresse
     * @Get(PraticienRestController::URI_PRATICIEN_COLLECTION)
     */
    public function searchAll($ville=null,$adresse=null)
    {
        try {
            if ($ville) {
                $praticiens = $this->praticienService->findPraticiensByVille($ville); 
            } 
            else if($adresse){
                $praticiens = $this->praticienService->findPraticienByAdresse($adresse);
            }
            else {
                $praticiens = $this->praticienService->searchAll();
            }
        } catch(PraticienServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
        if($praticiens){
            return View::create($praticiens, Response::HTTP_OK, ["Content-type" => "application/json"]);
        } else {
            return View::create($praticiens, Response::HTTP_NOT_FOUND, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Post(
     *      path="/praticiens",
     *      tags={"Praticien"},
     *      summary="Create PraticienDTO",
     *      description="This can only be done by the logged in user",
     *      @OA\Response(
     *          response=405,
     *          description="Invalid input",
     *          ),
     *      @OA\Response(
     *          response=201,
     *          description="Praticien inserted successfully",
     *          @OA\JsonContent(ref="#/components/schemas/PraticienDTO")
     *          ),
     *      @OA\RequestBody(
     *          description="PraticienDTO JSON Object",
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/PraticienDTO")
     *      )
     * )
     * 
     * @Post(PraticienRestController::URI_PRATICIEN_COLLECTION)
     * @ParamConverter("praticienDto", converter="fos_rest.request_body")
     */
    public function create(PraticienDTO $praticienDto){
        try {
            $this->praticienService->persist(new Praticien(), $praticienDto);
            return View::create([], Response::HTTP_CREATED, ["Content-type" => "application/json"]);
        } catch (PraticienServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Delete(
     *      path="/praticiens/{idPraticien}",
     *      tags={"Praticien"},
     *      summary="Delete purchase order by ID",
     *      description="For valid response try integer IDs with positive integer value. Negative or non-integer values will generate API errors",
     *      @OA\Parameter(
     *          name="idPraticien",
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
     * @Delete(PraticienRestController::URI_PRATICIEN_INSTANCE)
     *
     * @param integer $id
     * @return void
     */
    public function remove(Praticien $praticien,PraticienDTO $praticienDto){
        try {
            $this->praticienService->delete($praticien,$praticienDto);
            return View::create([], Response::HTTP_NO_CONTENT, ["Content-type" => "application/json"]);
        } catch(PraticienServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Put(path="/praticiens/{idPraticien}",
     *      tags={"Praticien"},
     *      summary="Updated praticien",
     *      description="This can only be done by the logged in praticien.",
     *      @OA\Parameter(
     *          name="idPraticien",
     *          in="path",
     *          description="id that need to be updated",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=400, 
     *          description="Invalid praticien supplied"),
     *      @OA\Response(
     *          response=404, 
     *          description="Praticien not found"),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Updated user object",
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/PraticienDTO")
     *          )
     *      ),
     * )
     * 
     * @Put(PraticienRestController::URI_PRATICIEN_INSTANCE)
     * @ParamConverter("praticienDto", converter="fos_rest.request_body")
     * 
     * @param PraticienDTO $praticienDto
     * @return void
     */
    public function update(Praticien $praticien, PraticienDTO $praticienDto){
        try {
            $this->praticienService->persist($praticien, $praticienDto);
            return View::create([], Response::HTTP_OK, ["Content-type" => "application/json"]);
        } catch (PraticienServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * 
     * @OA\Get(
     *      path="/praticiens/{id}",
     *      tags={"Praticien"},
     *      summary="search one praticien",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="Praticien trouvé",
     *          @OA\JsonContent(ref="#/components/schemas/PraticienDTO"),
     *          @OA\Link(link="PraticienDTO", ref="#/components/schemas/PraticienDTO")
     *      )
     * )
     * 
     * @Get(PraticienRestController::URI_PRATICIEN_INSTANCE)
     *
     * @return void
     */
    public function searchById(int $id){
        try {
            $praticienDto = $this->praticienService->searchById($id);
        }catch (PraticienServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
        if($praticienDto){
            return View::create($praticienDto, Response::HTTP_OK, ["Content-type" => "application/json"]);
        } else {
            return View::create([], Response::HTTP_NOT_FOUND, ["Content-type" => "application/json"]);
        }
    }
}
