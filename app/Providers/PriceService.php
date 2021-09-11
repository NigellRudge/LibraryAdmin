<?php


namespace App\Providers;


use App\Models\PricingInfo;
use phpDocumentor\Reflection\Types\Integer;

class PriceService
{

    public function getPrices(array $filterOptions){
        $items = PricingInfo::all();
        return $items;
    }

    public function storePrice(array $data){

    }
    public function editPrice($priceId, array $data){

    }
    public function deletePrice($priceId){

    }

}
