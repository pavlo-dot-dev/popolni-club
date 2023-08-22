<?php

namespace PavloDotDev\PopolniClub\Entities;

readonly class TransactionStatus
{
    public function __construct(
        public int $transactionId,
        public int $status,
    ) {
    }

    public function statusText(): ?string
    {
        return match ($this->status) {
            0 => 'Платёж получен и обрабатывается',
            2 => 'Платёж в процессе выполнения',
            3 => 'Платёж выполнен успешно',
            101 => 'Недостаточно денег для выполнения данного платежа',
            121 => 'Провайдер не найден',
            124 => 'Невозможно создать платёж – платёж с таким номером уже был создан ранее',
            125 => 'Платёж не найден',
            208 => 'Платёж отменен',
            215 => 'Внутренняя ошибка шлюза',
            423 => 'Номер из черного списка заблокирован',
            default => null
        };
    }
}
