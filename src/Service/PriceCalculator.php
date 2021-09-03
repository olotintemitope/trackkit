<?php

namespace TrackTik\Service;

use TrackTik\ElectronicItems;

class PriceCalculator
{
    private $items;
    
    public function __construct(ElectronicItems $items)
    {
        $this->items = $items;
    }
    
    public function calculate() : float 
    {
        return array_reduce($this->items->getItems(), static function ($totalPrice, $item) {
            $totalPrice += $item->price;

            return $totalPrice;
        }, 0.0);
    }
}