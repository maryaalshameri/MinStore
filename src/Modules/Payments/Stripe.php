<?php
namespace MiniStore\Modules\Payments;

class Stripe implements PaymentGateway {
    public function processPayment(float $amount): bool {
        echo "تم الدفع عبر Stripe بمبلغ: $amount<br>";
        return true;
    }
}
