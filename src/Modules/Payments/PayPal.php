<?php
namespace MiniStore\Modules\Payments;

class PayPal implements PaymentGateway {
    private string $message = '';

    public function processPayment(float $amount): bool {
        $this->message = "تم الدفع عبر PayPal بمبلغ: {$amount}";
        return true;
    }

    public function getMessage(): string {
        return $this->message;
    }
}
