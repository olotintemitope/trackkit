<?php

namespace TrackKit;

class ElectronicItem
{
    const ELECTRONIC_ITEM_TELEVISION = 'television';
    const ELECTRONIC_ITEM_CONSOLE = 'console';
    const ELECTRONIC_ITEM_MICROWAVE = 'microwave';

    private static $types = [
        self::ELECTRONIC_ITEM_CONSOLE,
        self::ELECTRONIC_ITEM_MICROWAVE,
        self::ELECTRONIC_ITEM_TELEVISION
    ];

    /**
     * @var float
     */
    public $price;
    public $wired;
    /**
     * @var string
     */
    private $type;

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getWired()
    {
        return $this->wired;
    }

    public function setWired($wired)
    {
        $this->wired = $wired;
    }

    public static function getTypes()
    {
        return static::$types;
    }

}