<?php

namespace App\Context\Api\Http\Controllers;

use App\Core\Http\Controllers\Controller;
use App\Domain\Recipient\Repositories\RecipientRepository;
use App\Domain\Recipient\Transformers\RecipientTransformer;
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
    public function store(Request $request)
    {
        $this->repository->validator();

        return response()->json($this->repository->create($request->all()),Response::HTTP_CREATED);

    }

}