<?php declare(strict_types = 1);

namespace Life;

class Grid
{
    private array $cells;

    public function __construct(int $size)
    {
        $this->cells = array_fill(0, $size, array_fill(0, $size, false));
    }

    public function setCell(int $x, int $y, bool $state): void
    {
        $this->cells[$y][$x] = $state;
    }

    public function getCell(int $x, int $y): bool
    {
        return $this->cells[$y][$x] ?? false;
    }

    public function countNeighbors(int $x, int $y): int
    {
        $count = 0;
        $directions = [
            [-1, -1], [-1, 0], [-1, 1],
            [0, -1],          [0, 1],
            [1, -1], [1, 0], [1, 1],
        ];

        foreach ($directions as [$dx, $dy]) {
            $nx = $x + $dx;
            $ny = $y + $dy;
            if ($this->getCell($nx, $ny)) {
                $count++;
            }
        }

        return $count;
    }

    public function getCells(): array
    {
        return $this->cells;
    }
}