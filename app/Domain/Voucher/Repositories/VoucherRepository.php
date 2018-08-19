<?php

namespace App\Domain\Voucher\Repositories;

use App\Domain\Voucher\Exceptions\InvalidVoucherExpiryException;
use App\Domain\Voucher\Helpers\RandomCodeGenerator;
use App\Domain\Voucher\Models\Voucher;
use Carbon\Carbon;
use Prettus\Repository\Eloquent\BaseRepository;

class VoucherRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return Voucher::class;
    }


    /**
     * Voucher Presenter
     *
     * @return string
     */
    public function presenter()
    {
        return "App\\Domain\\Voucher\\Presenters\\VoucherPresenter";
    }

    /**
     * @param array $inputs
     * @return mixed
     */
    public function store(array $inputs)
    {
        //Check if offer expiry date
        $this->checkExpiryDate($inputs['expires_at']);
        $this->skipPresenter(false);

        //Assign new code
        $inputs['code'] = $this->generateUniqueCode();

        return parent::create($inputs);
    }

    /**
     * Check if the expiry date is not in the past
     *
     * @param string $expiry
     */
    public function checkExpiryDate(string $expiry)
    {
        $now = Carbon::now(); //current date
        $expiry_date = is_string($expiry) ? Carbon::parse($expiry) : $expiry;
        $difference = $now->diffInHours($expiry_date, false) ;

        if($difference < 0){
            throw  new InvalidVoucherExpiryException();
        }
    }


    /**
     * Generate unique code
     *
     * @param int $size
     * @return string
     */
    public function generateUniqueCode($size = 8)
    {
            //Generate new code
            $generator = new RandomCodeGenerator();
            $code = strtoupper($generator->generate($size));

            return $code;
    }


    /**
     *
     * Get voucher discount percentage and mark as used
     *
     * @param string $code
     * @return float|int
     */
    public function getVoucherDiscount(string $code)
    {
        $voucher = $this->skipPresenter()->with('offer')->findByField('code',$code)->first();

        $voucher->used_at = Carbon::now();
        $voucher->is_used = 1;
        $voucher->save();

        return $voucher->offer->discount / 100 ;

    }


    public function getValidVoucherCodes(string $recipientId)
    {
        return $this->skipPresenter(true)
            ->with('offer')
            ->whereHas('recipient', function ($query) use ($recipientId) {
            return $query->where('id', $recipientId);
        })->all()->filter(function ($voucher) {
                return $voucher->isValid();
        });

    }
}