<?php

namespace App\DTOs;

readonly class PaymentCreateRequest
{
    /**
     * @param int $payer_id
     * @param int $campus_id
     * @param float $amount
     * @param string $type
     * @param string|null $payment_method
     * @param string|null $account_name
     * @param string|null $bank_name
     * @param string|null $account_number
     * @param string|null $transaction_ref
     * @param string|null $notes
     * @param array|null $installments
     */
    public function __construct(
        public int $payer_id,
        public int $campus_id,
        public float $amount,
        public string $type,
        public ?string $payment_method,
        public ?string $account_name,
        public ?string $bank_name,
        public ?string $account_number,
        public ?string $transaction_ref,
        public ?string $notes,
        public ?array $installments,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'payer_id' => $this->payer_id,
            'campus_id' => $this->campus_id,
            'amount' => $this->amount,
            'type' => $this->type,
            'payment_method' => $this->payment_method,
            'account_name' => $this->account_name,
            'bank_name' => $this->bank_name,
            'account_number' => $this->account_number,
            'transaction_ref' => $this->transaction_ref,
            'notes' => $this->notes,
            'installments' => $this->installments,
        ];
    }
}
