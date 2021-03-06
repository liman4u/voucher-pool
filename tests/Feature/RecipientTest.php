<?php
/**
 * Created by PhpStorm.
 * User: liman
 * Date: 8/17/18
 * Time: 11:32 PM
 */

namespace Test\Feature;


use App\Domain\Recipient\Models\Recipient;
use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseTransactions;

class RecipientTest extends \TestCase
{

    use DatabaseTransactions;

    /**
     * Test for can create a recipient
     */
    public function testCanCreateRecipient()
    {
        $recipient = factory(Recipient::class)->make()->toArray();

        $response = $this->post('/api/v1/recipients', $recipient);

        $response
                 ->receiveJson()
                 ->seeStatusCode(Response::HTTP_CREATED)
                 ->seeJsonContains([
                     'success' => true
                 ])
                 ->seeJsonContains([
                     'data' => [
                            'name' => $recipient['name'],
                            'email' => $recipient['email']
                    ]
                  ]);
    }

    /**
     * Test for can not create a recipient for invalid data
     */
    public function testCanNotCreateRecipientInvalidData(){

        $response = $this->post('/api/v1/recipients', []);

        $response
            ->seeJsonContains([
            'success' => false
            ])
            ->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Test for can not create a recipient for duplicate email
     */
    public function testCanNotCreateRecipientDuplicateEmail(){

        $recipient = factory(Recipient::class)->create()->toArray();

        $response = $this->post('/api/v1/recipients', $recipient);

        $response
            ->seeJsonContains([
                'success' => false
            ])
            ->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}