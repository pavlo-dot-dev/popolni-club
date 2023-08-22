<?php

namespace PavloDotDev\PopolniClub\Entities;

use PavloDotDev\PopolniClub\API;

class TransactionBuilder
{
    protected array $transactions = [];

    public function __construct(
        protected readonly API $api,
    ) {
    }

    public function create(int $id, int|float|string $amount, string $phone): static
    {
        $amount = round($amount * 100);
        if ($amount < 100) {
            throw new \Exception('Minimum amount is 1');
        }

        $this->transactions[] = [
            'transactionId' => $id,
            'amount' => $amount,
            'msisdn' => $phone,
        ];

        return $this;
    }

    /** @return TransactionStatus[] */
    public function send(): array
    {
        if (count($this->transactions) === 0) {
            throw new \Exception('Transaction count is zero');
        }

        $data = $this->api->call('', null, $this->transactions);

        return array_map(fn(array $item) => new TransactionStatus(
            transactionId: $item['transactionId'],
            status: $item['status'],
        ), $data);
    }
}
