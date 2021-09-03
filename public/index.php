<?php
require_once 'vendor/autoload.php';

use TrackTik\ElectronicItem;
use TrackTik\ElectronicItems;
use TrackTik\Electronics\Console;
use TrackTik\Electronics\Controller;
use TrackTik\Electronics\Microwave;
use TrackTik\Electronics\Television;

// Scenario 1
try {
    $type = 'price';

    $consoleTotalPrice = 0.0;
    $tv1TotalPrice = 0.0;
    $tv2TotalPrice = 0.0;
    $microwaveTotalPrice = 0.0;

    $electronicItems = buyConsoleAndControllers();
    if ($electronicItems->canHaveExtras(ElectronicItem::ELECTRONIC_ITEM_CONSOLE)) {
        $consoleTotalPrice = calculateTotalPriceAndSortBy($electronicItems, $type);
    }

    $electronicItems = buyTelevision1AndRemoteControllers();
    if ($electronicItems->canHaveExtras(ElectronicItem::ELECTRONIC_ITEM_TELEVISION)) {
        $tv1TotalPrice = calculateTotalPriceAndSortBy($electronicItems, $type);
    }

    $electronicItems = buyTelevision2AndRemoteControllers();
    if ($electronicItems->canHaveExtras(ElectronicItem::ELECTRONIC_ITEM_TELEVISION)) {
        $tv2TotalPrice = calculateTotalPriceAndSortBy($electronicItems, $type);
    }

    $electronicItems = buyMicrowave();
    if ($electronicItems->canHaveExtras(ElectronicItem::ELECTRONIC_ITEM_MICROWAVE)) {
        $microwaveTotalPrice = calculateTotalPriceAndSortBy($electronicItems, $type);
    }

    // Total price of 1 console, 2 televisions with different prices and 1 microwave
    $totalPrice = $consoleTotalPrice + $tv1TotalPrice + $tv2TotalPrice +  $microwaveTotalPrice;
    echo "Total price of 1 console, 2 televisions with different prices and 1 microwave = {$totalPrice}";

    //Question 2
    // That person's friend saw her with her new purchase and asked her how much the
    //console and its controllers had cost her.
    echo "\n";
    echo "Total price of console and its controllers = {$consoleTotalPrice}";

} catch (RuntimeException $exception) {
    echo $exception->getMessage();
}


/**
 * @param $electronicItems
 * @param $type
 * @return float
 */
function calculateTotalPriceAndSortBy($electronicItems, $type): float
{
    $consoleItems = $electronicItems->getSortedItems($type);
    
    return array_reduce($consoleItems, static function ($totalPrice, $item) {
        $totalPrice += $item->price;

        return $totalPrice;
    }, 0.0);
}

function buyMicrowave(): ElectronicItems
{
    $microwave = (new Microwave())
        ->setWired(false)
        ->setPrice(1000)
        ->setType(ElectronicItem::ELECTRONIC_ITEM_MICROWAVE)
        ->setMaxExtras(-1);

    return new ElectronicItems([
        $microwave,
    ]);
}

function buyTelevision1AndRemoteControllers(): ElectronicItems
{
    $tv1 = (new Television())
        ->setWired(false)
        ->setPrice(1600)
        ->setType(ElectronicItem::ELECTRONIC_ITEM_TELEVISION)
        ->setMaxExtras(INF);

    $remoteController1 = (new Controller())
        ->setPrice(250)
        ->setWired(false);

    $remoteController2 = (new Controller())
        ->setPrice(250)
        ->setWired(false);

    return new ElectronicItems([
        $tv1,
        $remoteController1,
        $remoteController2,
    ]);
}

function buyTelevision2AndRemoteControllers(): ElectronicItems
{
    $tv2 = (new Television())
        ->setWired(false)
        ->setPrice(2000)
        ->setType(ElectronicItem::ELECTRONIC_ITEM_TELEVISION)
        ->setMaxExtras(INF);

    $remoteController1 = (new Controller())
        ->setPrice(280)
        ->setWired(false);

    return new ElectronicItems([
        $tv2,
        $remoteController1,
    ]);
}

/**
 * @return ElectronicItems
 */
function buyConsoleAndControllers(): ElectronicItems
{
    $console = (new Console())
        ->setMaxExtras(4)
        ->setType(ElectronicItem::ELECTRONIC_ITEM_CONSOLE)
        ->setPrice(500)
        ->setWired(false);
    // A console has 2 wired controllers
    $wiredController1 = (new Controller())
        ->setPrice(100)
        ->setWired(true);

    $wiredController2 = (new Controller())
        ->setPrice(100)
        ->setWired(true);
    // A console has 2 remote controllers
    $remoteController1 = (new Controller())
        ->setPrice(150)
        ->setWired(false);

    $remoteController2 = (new Controller())
        ->setPrice(150)
        ->setWired(false);

    return new ElectronicItems([
        $console,
        $wiredController1,
        $wiredController2,
        $remoteController1,
        $remoteController2,
    ]);
}
