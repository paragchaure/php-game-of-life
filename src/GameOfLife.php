<?php declare(strict_types = 1);

namespace Life;

class GameOfLife
{
    private Grid $grid;

    public function __construct(int $size)
    {
        $this->grid = new Grid($size);
    }

    public function tick(): void
    {
        $newCells = $this->grid->getCells();
        $size = count($newCells);

        for ($y = 0; $y < $size; $y++) {
            for ($x = 0; $x < $size; $x++) {
                $aliveNeighbors = $this->grid->countNeighbors($x, $y);
                var_dump($aliveNeighbors);
                $currentState = $this->grid->getCell($x, $y);
                if ($currentState && ($aliveNeighbors < 2 || $aliveNeighbors > 3)) {
                    $newCells[$y][$x] = false; // Cell dies
                } elseif (!$currentState && $aliveNeighbors === 3) {
                    $newCells[$y][$x] = true; // Cell becomes alive
                }else{
                    $newCells[$y][$x] = true; // Cell remains unchanged
                }
            }
        }

        foreach ($newCells as $y => $row) {
            foreach ($row as $x => $state) {
                $this->grid->setCell($x, $y, $state);
            }
        }
        dump($this->grid);
    }

    public function getGrid(): Grid
    {
        return $this->grid;
    }
}