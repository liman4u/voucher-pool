<?php
/**
 * Created by PhpStorm.
 * User: liman
 * Date: 8/19/18
 * Time: 4:53 AM
 */

namespace Test\Feature;


use App\Domain\Offer\Models\Offer;
use App\Domain\Recipient\Models\Recipient;
use App\Domain\Voucher\Helpers\RandomCodeGenerator;
use App\Domain\Voucher\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseTransactions;

class VoucherTest extends \TestCase
{

    use DatabaseTransactions;

    /**
     * Test for can generate voucher codes
     */
    public function testCanGenerateVoucherCodes()
    {
        $offer = factory(Offer::class)->create();
        $expiryDate = Carbon::now()->addDays(30);

        $response = $this->post('/api/v1/vouchers/generate', [
            'offer_id' => $offer->id,
            'expiry_date' => $expiryDate->format('Y-m-d H:i:s')
        ]);

        $response
            ->receiveJson()
            ->seeJsonContains([
                'success' => true
            ])
            ->seeStatusCode(Response::HTTP_OK);
    }


    /**
     * Test can not generate voucher codes
     */
    public function testCanNoGenerateVoucherCodes()
    {
        $response = $this->post('/api/v1/vouchers/generate',[]);

        $response
            ->seeJsonContains([
                'success' => false
            ])
            ->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
    }


    /**
     * Test for can validate voucher code
     */
    public function testCanValidateVoucherCode()
    {
        $recipient = factory(Recipient::class)->create();
        $offer = factory(Offer::class)->create();

        $generator = new RandomCodeGenerator();
        $code = strtoupper($generator->generate(8));

        $voucher = new Voucher([
            'offer_id' => $offer->id,
            'recipient_id' => $recipient->id,
            'expires_at' => Carbon::now()->addDays(30),
            'code' => $code
        ]);

        $voucher->save();

        $response = $this->get("/api/v1/vouchers/validate?" . http_build_query([
                'code' => $voucher->code,
                'email' => $recipient->email
            ]));

        $response
            ->receiveJson()
            ->seeStatusCode(Response::HTTP_OK)
            ->seeJsonContains([
                'success' => true
            ])
            ->seeJsonContains([
                'data' => [
                    'precentage_discount' => ($offer->discount / 100)
                ]
            ]);
    }

    /**
     * Test for can not validate voucher code
     */
    public function testCanNotValidateVoucherCode()
    {
        $code = "ABCD";

        $response = $this->get("/api/v1/vouchers/validate?" . http_build_query([
                'code' => $code
            ]));

        $response
            ->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->seeJsonContains([
                'success' => false
            ]);
    }
}