<?php

namespace App\Controller;

use App\DTO\PatientDTO;
use App\Entity\Patient;
use App\Mapper\PatientMapper;
use FOS\RestBundle\View\View;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use App\Service\Exception\PatientServiceException;
use App\Service\ServicePatient;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
Use OpenApi\Annotations as OA;

class PatientRestController extends AbstractFOSRestController
{
    private $patientService;
    
    const URI_PATIENT_COLLECTION = "/patients";
    const URI_PATIENT_INSTANCE = "/patients/{id}";

    public function __construct(ServicePatient $patientService, 
                                EntityManagerInterface $entityManager,
                                PatientMapper $mapper){
        $this->patientService =$patientService;
        $this->entityManager = $entityManager;
        $this->patientMapper = $mapper;
    }

    /**
     * @OA\Get(
     *      path="/patients",
     *      tags={"Patient"},
     *      summary="Returns a list of PatientDTO",
     *      description="Returns a list of PatientDTO",
     *      @OA\Response(
     *          response=200,
     *          description="Successfull operation",
     *          @OA\JsonContent(ref="#/components/schemas/PatientDTO")
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="If no PatientDTO found",
     *          @OA\JsonContent(ref="#/components/schemas/PatientDTO")
     *      ),
     * )
     * @Get(PatientRestController::URI_PATIENT_COLLECTION)
     */
    public function searchAll()
    {
        try {
            $patients = $this->patientService->searchAll();
        } catch(PatientServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
        if($patients){
            return View::create($patients, Response::HTTP_OK, ["Content-type" => "application/json"]);
        } else {
            return View::create($patients, Response::HTTP_NOT_FOUND, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Delete(
     *      path="/patients/{id}",
     *      tags={"Patient"},
     *      summary="Delete patient",
     *      description="For valid response try integer IDs with positive integer value. Negative or non-integer values will generate API errors",
     *      operationId="remove",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of the order that needs to be deleted",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              minimum=1.0
     *          )
     *      ),
     *      @OA\Response(response=400, description="Invalid ID supplied"),
     *      @OA\Response(response=404, description="Order not found")
     * )
     * 
     * @Delete(PatientRestController::URI_PATIENT_INSTANCE)
     *
     * @param integer $id
     * @return void
     */
    public function remove(Patient $patient){
        try {
            $this->patientService->delete($patient);
            return View::create([], Response::HTTP_NO_CONTENT, ["Content-type" => "application/json"]);
        } catch(PatientServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Post(
     *      path="/patients",
     *      tags={"Patient"},
     *      summary="Create Patient",
     *      description="This can only be done by the logged in patient",
     *      @OA\Response(
     *          response=405,
     *          description="Invalid input",
     *          ),
     *      @OA\Response(
     *          response=201,
     *          description="Patient inserted successfully",
     *          @OA\JsonContent(ref="#/components/schemas/PatientDTO")
     *          ),
     *          @OA\RequestBody(
     *              description="PatientDTO JSON Object",
     *              required=true,
     *              @OA\JsonContent(ref="#/components/schemas/PatientDTO"))
     * )
     * 
     * @Post(PatientRestController::URI_PATIENT_COLLECTION)
     * @ParamConverter("patientDto", converter="fos_rest.request_body")
     */
    public function create(PatientDTO $patientDto){
        try {
            //var_dump($patientDto);
            $this->patientService->persist(new Patient(),$patientDto);
            return View::create([], Response::HTTP_CREATED, ["Content-type" => "application/json"]);
        } catch (PatientServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Put(path="/patients/{id}",
     *      tags={"Patient"},
     *      summary="Updated patient",
     *      description="This can only be done by the logged in patient.",
     *      operationId="update",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="id that need to be updated",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=400, 
     *          description="Invalid patient supplied"),
     *      @OA\Response(
     *          response=404, 
     *          description="Patient not found"),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Updated user object",
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/PatientDTO")
     *          )
     *      ),
     * )
     * @Put(PatientRestController::URI_PATIENT_INSTANCE)
     * @ParamConverter("patientDto", converter="fos_rest.request_body")
     * 
     * @param PatientDTO $patientDto
     */
    public function update(Patient $patient, PatientDTO $patientDto){
        try {
            $this->patientService->persist($patient, $patientDto);
            return View::create([], Response::HTTP_OK, ["Content-type" => "application/json"]);
        } catch (PatientServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Get(
     *      path="/patients/{id}",
     *      tags={"Patient"},
     *      summary="Search one patient",
     *      operationId="searchById",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="Patient trouvé",
     *          @OA\JsonContent(ref="#/components/schemas/PatientDTO"),
     *          @OA\Link(link="PatientDTO", ref="#/components/schemas/PatientDTO")
     *      )
     * )
     * @Get(PatientRestController::URI_PATIENT_INSTANCE)
     *
     * @return void
     */
    public function searchById(int $id){
        try {
            $patientDto = $this->patientService->searchById($id);
        }catch (PatientServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
        if($patientDto){
            return View::create($patientDto, Response::HTTP_OK, ["Content-type" => "application/json"]);
        } else {
            return View::create([], Response::HTTP_NOT_FOUND, ["Content-type" => "application/json"]);
        }
    }
}
