<?php
namespace MiniStore\Core;

trait DiscountTrait {
    public function applyDiscount(float $amount): float {
        return $amount - ($amount * DISCOUNT_PERCENT);
    }
}
