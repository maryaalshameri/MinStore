<?php
namespace MiniStore\Modules\Orders;

use MiniStore\Core\LoggerTrait;
use MiniStore\Core\DiscountTrait;
use MiniStore\Core\TaxTrait;
use MiniStore\Modules\Products\Product;
use MiniStore\Modules\Users\Customer;

class Order {
    use LoggerTrait, DiscountTrait, TaxTrait;

    private Customer $customer;
    private array $products = [];
    private float $total = 0.0;

    public function __construct(Customer $customer) {
        $this->customer = $customer;
    }

    public function addProduct(Product $product, int $qty): void {
        $product->reduceStock($qty);
        $this->products[] = ['product' => $product, 'qty' => $qty];
        $this->total += $product->getPrice() * $qty;
    }

    public function getTotal(): float { return $this->total; }
    public function getProducts(): array { return $this->products; }
    public function getCustomer(): Customer { return $this->customer; }
}
