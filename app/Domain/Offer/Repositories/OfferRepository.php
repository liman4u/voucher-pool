<?php

namespace App\Domain\Offer\Repositories;

use App\Domain\Offer\Exceptions\OfferAlreadyExistsException;
use App\Domain\Offer\Models\Offer;
use Prettus\Repository\Eloquent\BaseRepository;

class OfferRepository extends BaseRepository
{

    /**
     * @return string
     */
    function model()
    {
        return Offer::class;
    }

    /**
     * @return string
     */
    public function presenter()
    {
        return "App\\Domain\\Offer\\Presenters\\OfferPresenter";
    }


    /**
     * Store action
     *
     * @param array $inputs
     * @return mixed
     */
    public function store(array $inputs)
    {
        //Check if offer is already in records
        $this->checkOffer($inputs['name']);
        $this->skipPresenter(false);

        //generate slug and assign to alias
        $inputs['alias'] = str_slug($inputs['name']);

        return parent::create($inputs);
    }

    /**
     * Update action
     *
     * @param array $inputs
     * @return mixed
     */
    public function update(array $inputs, $id)
    {
        //Check if offer is already in records
        $this->checkOffer($inputs['name']);
        $this->skipPresenter(false);
        return parent::update($inputs, $id);
    }

    /**
     * @param string $name
     */
    public function checkOffer(string $name)
    {
        $alias = str_slug($name);
        $offer = $this->skipPresenter()->findByField('alias',$alias)->first();

        if($offer){
            throw new OfferAlreadyExistsException();
        }
    }
}