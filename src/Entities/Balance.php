<?php

namespace PavloDotDev\PopolniClub\Entities;

readonly class Balance
{
    public function __construct(
        public int $currentBalance,
        public int $creditLimit
    ) {
    }

    public function amount(): float
    {
        return round($this->currentBalance / 100, 2);
    }
}
