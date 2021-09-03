<?php
require_once 'vendor/autoload.php';

use TrackTik\ElectronicItem;
use TrackTik\ElectronicItems;
use TrackTik\Electronics\Console;
use TrackTik\Electronics\Controller;
use TrackTik\Electronics\Microwave;
use TrackTik\Electronics\Television;
use TrackTik\Service\PriceCalculator;

// Scenario 1
try {
    $type = 'price';

    $consoleTotalPrice = 0.0;
    $tv1TotalPrice = 0.0;
    $tv2TotalPrice = 0.0;
    $microwaveTotalPrice = 0.0;

    $electronicItems = buyConsoleAndControllers();
    if ($electronicItems->canHaveExtras(ElectronicItem::ELECTRONIC_ITEM_CONSOLE)) {
        $electronicItems->getSortedItems($type);
        $consoleTotalPrice = (new PriceCalculator($electronicItems))->calculate();
    }

    $electronicItems = buyTelevision1AndRemoteControllers();
    if ($electronicItems->canHaveExtras(ElectronicItem::ELECTRONIC_ITEM_TELEVISION)) {
        $electronicItems->getSortedItems($type);
        $tv1TotalPrice = (new PriceCalculator($electronicItems))->calculate();
    }

    $electronicItems = buyTelevision2AndRemoteControllers();
    if ($electronicItems->canHaveExtras(ElectronicItem::ELECTRONIC_ITEM_TELEVISION)) {
        $electronicItems->getSortedItems($type);
        $tv2TotalPrice = (new PriceCalculator($electronicItems))->calculate();
    }

    $electronicItems = buyMicrowave();
    if ($electronicItems->canHaveExtras(ElectronicItem::ELECTRONIC_ITEM_MICROWAVE)) {
        $electronicItems->getSortedItems($type);
        $microwaveTotalPrice = (new PriceCalculator($electronicItems))->calculate();
    }

    // Total price of 1 console, 2 televisions with different prices and 1 microwave
    $totalPrice = $consoleTotalPrice + $tv1TotalPrice + $tv2TotalPrice +  $microwaveTotalPrice;
    echo "Total price of 1 console, 2 televisions with different prices and 1 microwave = {$totalPrice}";

    //Question 2
    // That person's friend saw her with her new purchase and asked her how much the
    //console and its controllers had cost her.
    echo "\n";
    echo "Total price of console and its controllers = {$consoleTotalPrice}";
    echo "\n";

} catch (RuntimeException $exception) {
    echo $exception->getMessage();
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
