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

    /**
     * @var int
     */
    private $maxExtras = INF;

    public static function getTypes(): array
    {
        return static::$types;
    }

    /**
     * @return mixed
     */
    public function getMaxExtras(): float
    {
        return $this->maxExtras;
    }

    /**
     * @param float $maxExtras
     * @return ElectronicItem
     */
    public function setMaxExtras(float $maxExtras): ElectronicItem
    {
        $this->maxExtras = $maxExtras;

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): ElectronicItem
    {
        $this->price = $price;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type): ElectronicItem
    {
        $this->type = $type;

        return $this;
    }

    public function getWired()
    {
        return $this->wired;
    }

    public function setWired($wired): ElectronicItem
    {
        $this->wired = $wired;

        return $this;
    }
}