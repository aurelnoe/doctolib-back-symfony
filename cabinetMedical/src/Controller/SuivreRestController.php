<?php

namespace App\Controller;

use App\DTO\SuivreDTO;
use App\Entity\Suivre;
use App\Mapper\SuivreMapper;
use FOS\RestBundle\View\View;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use App\Service\Exception\SuivreServiceException;
use App\Service\ServiceSuivre;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
Use OpenApi\Annotations as OA;
 
class SuivreRestController extends AbstractFOSRestController
{
    private $suivreService;
    
    const URI_SUIVRE_COLLECTION = "/suivres";
    const URI_SUIVRE_INSTANCE = "/suivres/{id}";

    public function __construct(ServiceSuivre $suivreService, 
                                EntityManagerInterface $entityManager,
                                SuivreMapper $mapper){
        $this->suivreService =$suivreService;
        $this->entityManager = $entityManager;
        $this->suivreMapper = $mapper;
    }

    /**
     * @OA\Get(
     *      path="/suivres",
     *      tags={"Suivre"},
     *      summary="Returns a list of SuivreDTO",
     *      description="Returns a list of SuivreDTO",
     *      @OA\Response(
     *          response=200,
     *          description="Successfull operation",
     *          @OA\JsonContent(ref="#/components/schemas/SuivreDTO")
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="If no SuivreDTO found",
     *          @OA\JsonContent(ref="#/components/schemas/SuivreDTO")
     *      ),
     *      @OA\Response(
     *         response=500,
     *         description="Internal server Error. Please contact us",    
     *      )
     * )
     * 
     * @Get(SuivreRestController::URI_SUIVRE_COLLECTION)
     */
    public function searchAll()
    {
        try {
            $suivres = $this->suivreService->searchAll();
        } catch(SuivreServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
        if($suivres){
            return View::create($suivres, Response::HTTP_OK, ["Content-type" => "application/json"]);
        } else {
            return View::create($suivres, Response::HTTP_NOT_FOUND, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Post(
     *      path="/suivres",
     *      tags={"Suivre"},
     *      summary="Create SuivreDTO",
     *      description="This can only be done by the logged in user",
     *      @OA\Response(
     *          response=405,
     *          description="Invalid input",
     *          ),
     *      @OA\Response(
     *          response=201,
     *          description="Suivre inserted successfully",
     *          @OA\JsonContent(ref="#/components/schemas/SuivreDTO")
     *          ),
     *      @OA\RequestBody(
     *          description="SuivreDTO JSON Object",
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/SuivreDTO")
     *      )
     * )
     * 
     * @Post(SuivreRestController::URI_SUIVRE_COLLECTION)
     * @ParamConverter("suivreDto", converter="fos_rest.request_body")
     * @return void
     */
    public function create(SuivreDTO $suivreDto){
        try {
            $this->suivreService->persist(new Suivre(), $suivreDto,null);
            return View::create([], Response::HTTP_CREATED, ["Content-type" => "application/json"]);
        } catch (SuivreServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }

    }

    /**
     * @OA\Delete(
     *      path="/suivres/{idSuivre}",
     *      tags={"Suivre"},
     *      summary="Delete purchase order by ID",
     *      description="For valid response try integer IDs with positive integer value. Negative or non-integer values will generate API errors",
     *      @OA\Parameter(
     *          name="idSuivre",
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
     * @Delete(SuivreRestController::URI_SUIVRE_INSTANCE)
     *
     * @param [type] $id
     * @return void
     */
    public function remove(Suivre $suivre){
        try {
            $this->suivreService->delete($suivre);
            return View::create([], Response::HTTP_NO_CONTENT, ["Content-type" => "application/json"]);
        } catch(SuivreServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Put(path="/suivres/{idSuivre}",
     *      tags={"Suivre"},
     *      summary="Updated Suivre",
     *      description="This can only be done by the logged in Suivre.",
     *      @OA\Parameter(
     *          name="idSuivre",
     *          in="path",
     *          description="id that need to be updated",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=400, 
     *          description="Invalid Suivre supplied"),
     *      @OA\Response(
     *          response=404, 
     *          description="Suivre not found"),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Updated user object",
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/SuivreDTO")
     *          )
     *      ),
     * )
     * 
     * @Put(SuivreRestController::URI_SUIVRE_INSTANCE)
     * @ParamConverter("suivreDto", converter="fos_rest.request_body")
     * @param SuivreDTO $suivreDto
     * @return void
     */
    public function update(Suivre $suivre, SuivreDTO $suivreDto){
        try {
            $this->suivreService->persist($suivre, $suivreDto,null);
            return View::create([], Response::HTTP_OK, ["Content-type" => "application/json"]);
        } catch (SuivreServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @Get(SuivreRestController::URI_SUIVRE_INSTANCE)
     *
     * @return void
     */
    public function searchById(int $id){
        try {
            $suivreDto = $this->suivreService->searchById($id);
        }catch (SuivreServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
        if($suivreDto){
            return View::create($suivreDto, Response::HTTP_OK, ["Content-type" => "application/json"]);
        } else {
            return View::create([], Response::HTTP_NOT_FOUND, ["Content-type" => "application/json"]);
        }
    }
}
