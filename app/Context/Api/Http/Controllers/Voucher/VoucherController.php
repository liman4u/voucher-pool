<?php
/**
 * Created by PhpStorm.
 * User: liman
 * Date: 8/18/18
 * Time: 1:23 PM
 */

namespace App\Context\Api\Http\Controllers\Voucher;


use App\Context\Api\Http\Traits\ResponseTrait;
use App\Core\Http\Controllers\Controller;
use App\Domain\Offer\Repositories\OfferRepository;
use App\Domain\Recipient\Repositories\RecipientRepository;
use App\Domain\Voucher\Exceptions\InvalidVoucherExpiryException;
use App\Domain\Voucher\Repositories\VoucherRepository;
use App\Domain\Voucher\Transformers\VoucherTransformer;
use App\Domain\Voucher\Validators\RecipientVoucherCodesValidator;
use App\Domain\Voucher\Validators\ValidateVoucherValidator;
use App\Domain\Voucher\Validators\VoucherValidator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Prettus\Validator\Contracts\ValidatorInterface;

class VoucherController extends Controller
{

    use ResponseTrait;

    /**
     * @var OfferRepository
     */
    protected $offerRepository;

    /**
     * @var RecipientRepository
     */
    protected $recipientRepository;

    /**
     * @var VoucherRepository
     */
    protected $voucherRepository;


    /**
     * VoucherController constructor.
     * @param OfferRepository $offerRepository
     * @param RecipientRepository $recipientRepository
     * @param VoucherRepository $voucherRepository
     */
    public function __construct(
        OfferRepository $offerRepository,
        RecipientRepository $recipientRepository,
        VoucherRepository $voucherRepository

    ) {
        $this->offerRepository = $offerRepository;
        $this->recipientRepository = $recipientRepository;
        $this->voucherRepository = $voucherRepository;
        $this->offerRepository = $offerRepository;
        $this->recipientRepository = $recipientRepository;
    }


    /**
     * Generate voucher codes for all recipients
     *
     * @param VoucherValidator $validator
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateVoucherCode(VoucherValidator $validator,Request $request)
    {

        $this->validate($request,$validator->getRules(ValidatorInterface::RULE_CREATE));

        try{

            $offer = $this->offerRepository->skipPresenter()->find($request->input('offer_id'));

            $recipients = $this->recipientRepository->skipPresenter()->all();

            foreach ($recipients as $recipient){

                $input = array();
                $input['recipient_id'] = $recipient->id;
                $input['offer_id'] = $offer->id;

                $expiry = $request->input('expiry_date');
                $input['expires_at'] = is_string($expiry) ? Carbon::parse($expiry) : $expiry;


                $this->voucherRepository->store($input);
            }

            $vouchers = $this->voucherRepository->skipPresenter(false)->all();

            return $this->respondWithArray($vouchers);

            //return response()->json($vouchers->toArray(), Response::HTTP_CREATED);

        }catch (InvalidVoucherExpiryException $exception){

            return $this->failureResponse($exception->getMessage(),Response::HTTP_UNPROCESSABLE_ENTITY);

        }catch (\Exception $exception) {

            return $this->failureResponse($exception->getMessage());


        }


    }


    /**
     * Validate voucher code and mark as used
     *
     * @param ValidateVoucherValidator $validator
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateVoucherCode(ValidateVoucherValidator $validator,Request $request)
    {

        $this->validate($request,$validator->getRules('validate'));

        try{

            $discount = $this->voucherRepository->getVoucherDiscount($request->input('code'));

            return $this->successResponse([ 'precentage_discount' => $discount]);

        } catch (\Exception $exception) {

           return $this->failureResponse($exception->getMessage());


        }




    }


    /**
     * Get recipient valid voucher codes
     *
     * @param RecipientVoucherCodesValidator $validator
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRecipientVoucherCodes(RecipientVoucherCodesValidator $validator,Request $request)
    {
        $this->validate($request,$validator->getRules('recipient'));

        try{

            $recipient = $this->recipientRepository->skipPresenter()->findByField('email',$request->input('email'))->first();

            $vouchers = $this->voucherRepository->getValidVoucherCodes($recipient->id);

            $result = array();

            foreach($vouchers as $voucher){

                $voucherObject = array();

                $voucherObject['code'] = $voucher->code;

                $voucherObject['offerName'] = $voucher->offer->name;

                $voucherObject['percentage_discount'] = $voucher->offer->discount / 100;

                $voucherObject['expiryDate'] = $voucher->expires_at->format('Y-m-d H:i:s');

                array_push($result,$voucherObject);
            }

            return $this->respondWithArray(['data'=>$result]);



        }catch (\Exception $exception) {

            return $this->failureResponse($exception->getMessage());


        }



    }

}