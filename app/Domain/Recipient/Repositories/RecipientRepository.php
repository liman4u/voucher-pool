<?php

namespace App\Domain\Recipient\Repositories;

use App\Domain\Recipient\Models\Recipient;
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
     * Recipient Validator
     *
     * @return mixed
     */
    public function validate()
    {
        return "App\\Domain\\Recipient\\Validators\\RecipientValidator";
    }
}