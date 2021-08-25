<?php

namespace TrackKit;

class ElectronicItems
{
    private $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * Returns the items depending on the sorting type requested
     *
     * @return array
     */
    public function getSortedItems($type)
    {
        $sorted = [];
        foreach ($this->items as $item) {
            $sorted[($item->price * 100)] = $item;
        }
        return ksort($sorted, SORT_NUMERIC);
    }

    /**
     *
     * @param string $type
     * @return array
     */
    public function getItemsByType($type)
    {
        if (in_array($type, ElectronicItem::getTypes(), true)) {
            $callback = static function ($item) use ($type) {
                return $item->type === $type;
            };
            $items = array_filter($this->items, $callback);
        }
        return false;
    }
}