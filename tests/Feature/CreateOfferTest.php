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

class CreateOfferTest extends \TestCase
{

    use DatabaseTransactions;

    /**
     * Test for can create an offer
     */
    public function testCanCreateOffer()
    {
        $offer = factory(Offer::class)->make()->toArray();

        $response = $this->post('/api/v1/offers', $offer);

        $response->seeStatusCode(Response::HTTP_CREATED)
            ->seeJsonContains([
                'name' => $offer['name'],
                'discount' => $offer['discount']
            ]);
    }

    /**
     * Test for can not create an offer for invalid data
     */
    public function testCanNotCreateOfferInvalidData(){

        $response = $this->post('/api/v1/offers', []);

        $response->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
    }




}