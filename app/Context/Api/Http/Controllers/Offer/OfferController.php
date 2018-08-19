<?php
/**
 * Created by PhpStorm.
 * User: liman
 * Date: 8/18/18
 * Time: 4:54 AM
 */

namespace App\Context\Api\Http\Controllers\Offer;

use App\Context\Api\Http\Traits\ResponseTrait;
use App\Core\Http\Controllers\Controller;
use App\Domain\Offer\Exceptions\OfferAlreadyExistsException;
use App\Domain\Offer\Repositories\OfferRepository;
use App\Domain\Offer\Validators\OfferValidator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Prettus\Validator\Contracts\ValidatorInterface;

class OfferController extends Controller
{

    use ResponseTrait;

    /**
     * @var OfferRepository
     */
    protected $repository;

    /**
     * OfferController constructor.
     * @param OfferRepository $repository
     */
    public function __construct(OfferRepository $repository){
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
    public function store(OfferValidator $validator, Request $request)
    {
        $this->validate($request,$validator->getRules(ValidatorInterface::RULE_CREATE));

        try {

            return $this->respondWithItem($this->repository->store($request->all()));


        } catch (OfferAlreadyExistsException $exception) {

            return $this->failureResponse($exception->getMessage(),Response::HTTP_UNPROCESSABLE_ENTITY);


        } catch (\Exception $exception) {

            return $this->failureResponse($exception->getMessage());


        }

    }

}