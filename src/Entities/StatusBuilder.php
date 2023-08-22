<?php

namespace PavloDotDev\PopolniClub\Entities;

use PavloDotDev\PopolniClub\API;

class StatusBuilder
{
    protected array $items = [];

    public function __construct(
        protected readonly API $api,
    ) {
    }

    public function create(int $transactionId): static
    {
        $this->items[] = [
            'transactionId' => $transactionId,
            'status' => 0,
        ];

        return $this;
    }

    /** @return TransactionStatus[] */
    public function send(): array
    {
        if (count($this->items) === 0) {
            throw new \Exception('Transaction Status count is zero');
        }

        $data = $this->api->call('', null, $this->items);

        return array_map(fn(array $item) => new TransactionStatus(
            transactionId: $item['transactionId'],
            status: $item['status'],
        ), $data);
    }
}
