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
        ksort($sorted, SORT_NUMERIC);

        return $sorted;
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
            return array_filter($this->items, $callback);
        }
        return false;
    }

    /**
     * @param string $type
     * @return bool
     */
    public function canHaveExtras(string $type): bool
    {
        if (count($this->items) <= 0) {
            throw new \RuntimeException("Electronic items cannot be empty");
        }

        if (in_array($type, ElectronicItem::getTypes())) {
            $item = array_splice($this->items, 0, 1);
            $extraItems = array_splice($this->items, 0, count($this->items));

            if ($item[0]->getMaxExtras() === -1.0 && count($extraItems) > 0) {
                throw new \RuntimeException("{$type} cannot have any extras");
            }

            if ($item[0]->getMaxExtras() === -1.0 && count($extraItems) <= 0) {
                return true;
            }

            if (count($extraItems) > $item[0]->getMaxExtras()) {
                throw new \RuntimeException("{$type} cannot have more than {$item[0]->getMaxExtras()} extras");
            }

            return true;
        }

        throw new \RuntimeException("Electronic item type not recognised");
    }
}