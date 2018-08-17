<?php

namespace App\Context\Api\Http\Controllers\Recipient;

use App\Core\Http\Controllers\Controller;
use App\Domain\Recipient\Exceptions\RecipientAlreadyExistsException;
use App\Domain\Recipient\Repositories\RecipientRepository;
use App\Domain\Recipient\Validators\RecipientValidator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RecipientController extends Controller
{
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
        return response()->json($this->repository->paginate(15));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(RecipientValidator $validator, Request $request)
    {
        $this->validate($request,$validator->getRules('create'));

        try {

            return response()->json($this->repository->store($request->all()),Response::HTTP_CREATED);

        } catch (RecipientAlreadyExistsException $exception) {

            return response()->json(['code' => $exception->getCode(),'message'=>$exception->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);

        } catch (\Exception $exception) {

            return response()->json($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);

        }

    }

}