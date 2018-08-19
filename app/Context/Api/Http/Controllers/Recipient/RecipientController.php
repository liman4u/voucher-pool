<?php

namespace App\Context\Api\Http\Controllers\Recipient;

use App\Context\Api\Http\Traits\ResponseTrait;
use App\Core\Http\Controllers\Controller;
use App\Domain\Recipient\Exceptions\RecipientAlreadyExistsException;
use App\Domain\Recipient\Repositories\RecipientRepository;
use App\Domain\Recipient\Validators\RecipientValidator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Prettus\Validator\Contracts\ValidatorInterface;

class RecipientController extends Controller
{
    use ResponseTrait;


    /**
     * @var RecipientRepository
     */
    protected $repository;

    /**
     * RecipientController constructor.
     * @param RecipientRepository $repository
     */
    public function __construct(RecipientRepository $repository){
        $this->repository = $repository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->respondWithArray($this->repository->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(RecipientValidator $validator, Request $request)
    {

        $this->validate($request,$validator->getRules(ValidatorInterface::RULE_CREATE));

        try {

            return $this->respondWithItem($this->repository->store($request->all()));


        } catch (RecipientAlreadyExistsException $exception) {

            return $this->failureResponse($exception->getMessage(),Response::HTTP_UNPROCESSABLE_ENTITY);

        } catch (\Exception $exception) {

            return $this->failureResponse($exception->getMessage());

        }

    }

}