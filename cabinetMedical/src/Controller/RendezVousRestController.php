<?php

namespace App\Controller;

use App\DTO\RendezVousDTO;
use App\Entity\RendezVous;
use App\Mapper\RendezVousMapper;
use FOS\RestBundle\View\View;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use App\Service\Exception\RendezVousServiceException;
use App\Service\ServiceRendezVous;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
Use OpenApi\Annotations as OA;
 
class RendezVousRestController extends AbstractFOSRestController
{
    private $rendezVousService;
    
    const URI_RENDEZVOUS_COLLECTION = "/rendezVous";
    const URI_RENDEZVOUS_INSTANCE = "/rendezVous/{id}";

    public function __construct(ServiceRendezVous $rendezVousService, 
                                EntityManagerInterface $entityManager,
                                RendezVousMapper $mapper){
        $this->rendezVousService =$rendezVousService;
        $this->entityManager = $entityManager;
        $this->rendezVousMapper = $mapper;
    }

    /**
     * @OA\Get(
     *      path="/rendezVous",
     *      tags={"RendezVous"},
     *      summary="Returns a list of RendezVousDTO",
     *      description="Returns a list of RendezVousDTO",
     *      @OA\Response(
     *          response=200,
     *          description="Successfull operation",
     *          @OA\JsonContent(ref="#/components/schemas/RendezVousDTO")
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="If no RendezVousDTO found",
     *          @OA\JsonContent(ref="#/components/schemas/RendezVousDTO")
     *      ),
     *      @OA\Response(
     *         response=500,
     *         description="Internal server Error. Please contact us",    
     *      )
     * )
     * 
     * @Get(RendezVousRestController::URI_RENDEZVOUS_COLLECTION)
     */
    public function searchAll()
    {
        try {
            $rendezVouss = $this->rendezVousService->searchAll();
        } catch(RendezVousServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
        if($rendezVouss){
            return View::create($rendezVouss, Response::HTTP_OK, ["Content-type" => "application/json"]);
        } else {
            return View::create($rendezVouss, Response::HTTP_NOT_FOUND, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Post(
     *      path="/rendezVous",
     *      tags={"RendezVous"},
     *      summary="Create RendezVousDTO",
     *      description="This can only be done by the logged in user",
     *      @OA\Response(
     *          response=405,
     *          description="Invalid input",
     *          ),
     *      @OA\Response(
     *          response=201,
     *          description="RendezVous inserted successfully",
     *          @OA\JsonContent(ref="#/components/schemas/RendezVousDTO")
     *          ),
     *      @OA\RequestBody(
     *          description="RendezVousDTO JSON Object",
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/RendezVousDTO")
     *      )
     * )
     * 
     * @Post(RendezVousRestController::URI_RENDEZVOUS_COLLECTION)
     * @ParamConverter("rendezVousDto", converter="fos_rest.request_body")
     * @return void
     */
    public function create(RendezVousDTO $rendezVousDto){
        try {
            $this->rendezVousService->persist(new RendezVous(), $rendezVousDto,null);
            return View::create([], Response::HTTP_CREATED, ["Content-type" => "application/json"]);
        } catch (RendezVousServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }

    }

    /**
     * @OA\Delete(
     *      path="/rendezVous/{idRendezVous}",
     *      tags={"RendezVous"},
     *      summary="Delete purchase order by ID",
     *      description="For valid response try integer IDs with positive integer value. Negative or non-integer values will generate API errors",
     *      @OA\Parameter(
     *          name="idRendezVous",
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
     * @Delete(RendezVousRestController::URI_RENDEZVOUS_INSTANCE)
     *
     * @param [type] $id
     * @return void
     */
    public function remove(RendezVous $rendezVous){
        try {
            $this->rendezVousService->delete($rendezVous);
            return View::create([], Response::HTTP_NO_CONTENT, ["Content-type" => "application/json"]);
        } catch(RendezVousServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Put(path="/rendezVous/{idRendezVous}",
     *      tags={"RendezVous"},
     *      summary="Updated RendezVous",
     *      description="This can only be done by the logged in RendezVous.",
     *      @OA\Parameter(
     *          name="idRendezVous",
     *          in="path",
     *          description="id that need to be updated",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=400, 
     *          description="Invalid RendezVous supplied"),
     *      @OA\Response(
     *          response=404, 
     *          description="RendezVous not found"),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Updated user object",
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/RendezVousDTO")
     *          )
     *      ),
     * )
     * 
     * @Put(RendezVousRestController::URI_RENDEZVOUS_INSTANCE)
     * @ParamConverter("rendezVousDto", converter="fos_rest.request_body")
     * @param RendezVousDTO $rendezVousDto
     * @return void
     */
    public function update(RendezVous $rendezVous, RendezVousDTO $rendezVousDto){
        try {
            $this->rendezVousService->persist($rendezVous, $rendezVousDto,null);
            return View::create([], Response::HTTP_OK, ["Content-type" => "application/json"]);
        } catch (RendezVousServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Get(
     *      path="/rendezVous/{idRendezVous}",
     *      tags={"RendezVous"},
     *      summary="search one RendezVous",
     *      @OA\Parameter(
     *          name="idRendezVous",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="RendezVous trouvé",
     *          @OA\JsonContent(ref="#/components/schemas/RendezVousDTO"),
     *          @OA\Link(link="RendezVousDTO", ref="#/components/schemas/RendezVousDTO")
     *      )
     * )
     * 
     * @Get(RendezVousRestController::URI_RENDEZVOUS_INSTANCE)
     *
     * @return void
     */
    public function searchById(int $id){
        try {
            $rendezVousDto = $this->rendezVousService->searchById($id);
        }catch (RendezVousServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
        if($rendezVousDto){
            return View::create($rendezVousDto, Response::HTTP_OK, ["Content-type" => "application/json"]);
        } else {
            return View::create([], Response::HTTP_NOT_FOUND, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Get(
     *      path="/rendezVous/patient/{idPatient}",
     *      tags={"RendezVous"},
     *      summary="search one RendezVous",
     *      @OA\Parameter(
     *          name="idPatient",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="RendezVous trouvé",
     *          @OA\JsonContent(ref="#/components/schemas/RendezVousDTO"),
     *          @OA\Link(link="RendezVousDTO", ref="#/components/schemas/RendezVousDTO")
     *      )
     * )
     * 
     * @Get(RendezVousRestController::URI_RENDEZVOUS_INSTANCE)
     *
     * @return void
     */
    public function searchRdvByIdPatient(int $idPatient) {
        try {
            $rendezVousDto = $this->rendezVousService->searchRdvByIdPatient($idPatient);
        }catch (RendezVousServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
 
        if($rendezVousDto){
            return View::create($rendezVousDto, Response::HTTP_OK, ["Content-type" => "application/json"]);
        } else {
            return View::create([], Response::HTTP_NOT_FOUND, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Get(
     *      path="/rendezVous/praticien/{idPraticien}",
     *      tags={"RendezVous"},
     *      summary="search one RendezVous",
     *      @OA\Parameter(
     *          name="idPraticien",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="RendezVous trouvé",
     *          @OA\JsonContent(ref="#/components/schemas/RendezVousDTO"),
     *          @OA\Link(link="RendezVousDTO", ref="#/components/schemas/RendezVousDTO")
     *      )
     * )
     * 
     * @Get(RendezVousRestController::URI_RENDEZVOUS_INSTANCE)
     *
     * @return void
     */
    public function searchRdvByIdPraticien(int $idPraticien) {
        try {
            $rendezVousDto = $this->rendezVousService->searchRdvByIdPraticien($idPraticien);
        }catch (RendezVousServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
 
        if($rendezVousDto){
            return View::create($rendezVousDto, Response::HTTP_OK, ["Content-type" => "application/json"]);
        } else {
            return View::create([], Response::HTTP_NOT_FOUND, ["Content-type" => "application/json"]);
        }
    }
}
