<?php

namespace App\Domain\Recipient\Repositories;

use App\Domain\Recipient\Exceptions\RecipientAlreadyExistsException;
use App\Domain\Recipient\Models\Recipient;
use App\Domain\Recipient\Validators\RecipientValidator;
use Prettus\Repository\Eloquent\BaseRepository;

class RecipientRepository extends BaseRepository
{

    /**
     * Recipient Model
     *
     * @return string
     */
    function model()
    {
        return Recipient::class;
    }

    /**
     * Recipient Presenter
     *
     * @return string
     */
    public function presenter()
    {
        return "App\\Domain\\Recipient\\Presenters\\RecipientPresenter";
    }



    /**
     * @param array $inputs
     * @return mixed
     */
    public function store(array $inputs)
    {
        //Check if recipient is already in records
        $this->checkRecipient($inputs['email']);
        $this->skipPresenter(false);
        return parent::create($inputs);
    }

    /**
     * @param array $inputs
     * @return mixed
     */
    public function update(array $inputs, $id)
    {
        //Check if recipient is already in records
        $this->checkRecipient($inputs['email']);
        $this->skipPresenter(false);
        return parent::update($inputs, $id);
    }

    /**
     * @param string $email
     */
    public function checkRecipient(string $email)
    {
        $recipient = $this->skipPresenter(true)->findByField('email',$email)->first();

        if($recipient){
            throw  new RecipientAlreadyExistsException();
        }
    }
}