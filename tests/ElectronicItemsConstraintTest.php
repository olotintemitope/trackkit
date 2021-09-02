<?php

namespace TrackKit\Tests;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use TrackKit\ElectronicItem;
use TrackKit\ElectronicItems;
use TrackKit\Electronics\Console;
use TrackKit\Electronics\Controller;
use TrackKit\Electronics\Microwave;
use TrackKit\Electronics\Television;

class ElectronicItemsConstraintTest extends TestCase
{
    /**
     * @var ElectronicItem
     */
    private $console;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testThatTheConsoleCanHave4Extras():void
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

        $electronicItems = new ElectronicItems([
            $console,
            $wiredController1,
            $wiredController2,
            $remoteController1,
            $remoteController2,
        ]);

        $result = $electronicItems->canHaveExtras(ElectronicItem::ELECTRONIC_ITEM_CONSOLE);
        $this->assertTrue($result);
    }

    public function testThatTheConsoleCannotHaveMoreThan4Extras():void
    {
        $this->expectException(RuntimeException::class);
        $console = (new Console())
            ->setMaxExtras(4)
            ->setType(ElectronicItem::ELECTRONIC_ITEM_CONSOLE)
            ->setPrice(2500)
            ->setWired(false);
        // A console has 2 wired controllers
        $wiredController1 = (new Controller())
            ->setPrice(200)
            ->setWired(true);

        $wiredController2 = (new Controller())
            ->setPrice(200)
            ->setWired(true);
        // A console has 2 remote controllers
        $remoteController1 = (new Controller())
            ->setPrice(250)
            ->setWired(false);

        $remoteController2 = (new Controller())
            ->setPrice(250)
            ->setWired(false);

        $electronicItems = new ElectronicItems([
            $console,
            $wiredController1,
            $wiredController2,
            $remoteController1,
            $remoteController2,
            $wiredController1,
        ]);

        $electronicItems->canHaveExtras(ElectronicItem::ELECTRONIC_ITEM_CONSOLE);
    }

    public function testThatATelevisionHasNoMaximumExtras(): void
    {
        $tv1 = (new Television())
            ->setWired(false)
            ->setPrice(1500)
            ->setType(ElectronicItem::ELECTRONIC_ITEM_TELEVISION)
            ->setMaxExtras(INF);

        $remoteController1 = (new Controller())
            ->setPrice(150)
            ->setWired(false);

        $remoteController2 = (new Controller())
            ->setPrice(150)
            ->setWired(false);

        $electronicItems = new ElectronicItems([
            $tv1,
            $remoteController1,
            $remoteController2,
            $remoteController1,
            $remoteController2,
            $remoteController1,
            $remoteController2,
        ]);

        $result = $electronicItems->canHaveExtras(ElectronicItem::ELECTRONIC_ITEM_TELEVISION);
        $this->assertTrue($result);
    }

    public function testThatAMicrowaveWillThrowExceptionWithAnyExtras(): void
    {
        $this->expectException(RuntimeException::class);

        $microwave = (new Microwave())
            ->setWired(false)
            ->setPrice(1000)
            ->setType(ElectronicItem::ELECTRONIC_ITEM_MICROWAVE)
            ->setMaxExtras(-1);

        $tv1 = (new Television())
            ->setWired(false)
            ->setPrice(1500)
            ->setType(ElectronicItem::ELECTRONIC_ITEM_TELEVISION);

        $tv2 = (new Television())
            ->setWired(false)
            ->setPrice(1500)
            ->setType(ElectronicItem::ELECTRONIC_ITEM_TELEVISION);

        $electronicItems = new ElectronicItems([
            $microwave,
            $tv1,
            $tv2
        ]);

        $electronicItems->canHaveExtras(ElectronicItem::ELECTRONIC_ITEM_MICROWAVE);
    }

    public function testThatAMicrowaveCannotHaveAnyExtras(): void
    {
        $microwave = (new Microwave())
            ->setWired(false)
            ->setPrice(1000)
            ->setType(ElectronicItem::ELECTRONIC_ITEM_MICROWAVE)
            ->setMaxExtras(-1);

        $electronicItems = new ElectronicItems([
            $microwave,
        ]);

        $result = $electronicItems->canHaveExtras(ElectronicItem::ELECTRONIC_ITEM_MICROWAVE);
        $this->assertTrue($result);
    }
}