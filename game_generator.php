<?php

class RandomGameGenerator
{
    const FIELD_SIZE = 10;
    //виды кораблей: первое значение - количество палуб, второе значение - количество кораблей такого типа
    private $shipsForms = [[4, 1], [3, 2], [2, 3], [1, 4]];
    private $field;

    function __construct()
    {
        $this->field = $this->createField();
        $this->generateShips();
    }

    private function createField()
    {
        $matrix = [self::FIELD_SIZE];
        for ($i = 0; $i < self::FIELD_SIZE; $i++) {
            $matrix[$i] = [self::FIELD_SIZE];
            for ($j = 0; $j < self::FIELD_SIZE; $j++) {
                $matrix[$i][$j] = 0;
            }
        }
        return $matrix;
    }

    private function generateShips()
    {
        for ($i = 0; $i < count($this->shipsForms); $i++) {
            $decks = $this->shipsForms[$i][0];
            $shipsCount = $this->shipsForms[$i][1];
            for ($j = 0; $j < $shipsCount; $j++) {
                $ship = $this->getRandomShipLocation($decks);
                $this->addShip($ship);
            }
        }
        return $this->field;
    }

    private function addShip($ship)
    {
        $k = 0;
        while ($k < $ship["decks"]) {
            $this->field[$ship["x"] + $k * $ship["dirX"]][$ship["y"] + $k * $ship["dirY"]] = 1;
            $k++;
        }
    }

    private function getRandomShipLocation($decks)
    {
        do {
            $dirX = $this->getRandom(1);
            $dirY = ($dirX == 0) ? 1 : 0;
            if ($dirX == 0) {
                $x = $this->getRandom(self::FIELD_SIZE - 1);
                $y = $this->getRandom(self::FIELD_SIZE - $decks);
            } else {
                $x = $this->getRandom(self::FIELD_SIZE - $decks);
                $y = $this->getRandom(self::FIELD_SIZE - 1);
            }
        } while (!$this->validateShipLocation($dirX, $dirY, $x, $y, $decks));
        return [
            "dirX" => $dirX,
            "dirY" => $dirY,
            "x" => $x,
            "y" => $y,
            "decks" => $decks
        ];
    }

    private function validateShipLocation($dirX, $dirY, $x, $y, $decks)
    {
        $startX = ($x == 0) ? $x : $x - 1;
        $finX = $this->findFinPos($x, $dirX, $decks);
        $startY = ($y == 0) ? $y : $y - 1;
        $finY = $this->findFinPos($y, $dirY, $decks);

        if (!isset($finX)) return false;
        if (!isset($finY)) return false;

        for ($i = $startX; $i < $finX; $i++) {
            for ($j = $startY; $j < $finY; $j++) {
                if ($this->field[$i][$j] == 1) return false;
            }
        }
        return true;
    }

    private function findFinPos($pos, $dir, $decks)
    {
        $finPos = null;
        if ($pos + $dir * $decks == self::FIELD_SIZE && $dir == 1) $finPos = $pos + $dir * $decks;
        else if ($pos + $dir * $decks < self::FIELD_SIZE && $dir == 1) $finPos = $pos + $dir * $decks + 1;
        else if ($pos == self::FIELD_SIZE - 1 && $dir == 0) $finPos = $pos + 1;
        else if ($pos < self::FIELD_SIZE - 1 && $dir == 0) $finPos = $pos + 2;
        return $finPos;
    }

    private function getRandom($num)
    {
        return rand(0, $num);
    }


    public function getField()
    {
        return $this->field;
    }

}
