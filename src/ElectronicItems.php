<?php

namespace TrackTik;

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
     * @param $type
     * @return array
     */
    public function getSortedItems($type): array
    {
        uasort($this->items, static function ($item1, $item2) use ($type) {
            return $item1->{$type} <=> $item2->{$type};
        });

        return $this->items;
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
        $items = $this->items;
        
        if (count($items) <= 0) {
            throw new \RuntimeException("Electronic items cannot be empty");
        }

        if (in_array($type, ElectronicItem::getTypes(), true)) {
            $item = array_splice($items, 0, 1);
            $extraItems = array_splice($items, 0, count($items));

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

    /**
     * Get all the electronic items
     * 
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }
}