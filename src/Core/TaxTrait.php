<?php
namespace MiniStore\Core;

trait TaxTrait {
    public function applyTax(float $amount): float {
        return $amount + ($amount * TAX_RATE);
    }
}
