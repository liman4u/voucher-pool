<?php
/**
 * Created by PhpStorm.
 * User: liman
 * Date: 8/17/18
 * Time: 11:32 PM
 */

namespace Test\Feature;


use App\Domain\Offer\Models\Offer;
use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseTransactions;

class OfferTest extends \TestCase
{

    use DatabaseTransactions;

    /**
     * Test for can create an offer
     */
    public function testCanCreateOffer()
    {
        $offer = factory(Offer::class)->make()->toArray();

        $response = $this->post('/api/v1/offers', $offer);


        $response
                ->receiveJson()
                ->seeStatusCode(Response::HTTP_CREATED)
                 ->seeJsonContains([
                'success' => true
                ])
                ->seeJsonContains([
                'data' => [
                    'name' => $offer['name'],
                    'discount' => $offer['discount'],
                    'percentage_discount' => ($offer['discount'] / 100)
                ]
                ]);
    }

    /**
     * Test for can not create an offer for invalid data
     */
    public function testCanNotCreateOfferInvalidData(){

        $response = $this->post('/api/v1/offers', []);

        $response
            ->seeJsonContains([
                'success' => false
            ])
            ->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Test for can not create offer with negative discount
     */
    public function testCanNoCreateOfferWithNegativeDiscount()
    {
        $offer = factory(Offer::class)->make(['discount' => -10])->toArray();

        $response = $this->post('/api/v1/offers', $offer);

        $response
            ->seeJsonContains([
                'success' => false
            ])
            ->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Test for can not create offer with higher discount
     */
    public function testCanNoCreateOfferWithHigherDiscount()
    {
        $offer = factory(Offer::class)->make(['discount' => 200])->toArray();

        $response = $this->post('/api/v1/offers', $offer);

        $response
            ->seeJsonContains([
                'success' => false
            ])
            ->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

}