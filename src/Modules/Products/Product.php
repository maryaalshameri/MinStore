<?php
namespace MiniStore\Modules\Products;

class Product {
    private string $name;
    private float $price;
    private int $stock;

    public function __construct(string $name, float $price, int $stock) {
        $this->setName($name);
        $this->setPrice($price);
        $this->setStock($stock);
    }

    public function setName(string $name): void {
        if (empty($name)) throw new \InvalidArgumentException("اسم المنتج لا يمكن أن يكون فارغًا");
        $this->name = $name;
    }

    public function setPrice(float $price): void {
        if ($price <= 0) throw new \InvalidArgumentException("السعر يجب أن يكون أكبر من صفر");
        $this->price = $price;
    }

    public function setStock(int $stock): void {
        if ($stock < 0) throw new \InvalidArgumentException("المخزون لا يمكن أن يكون سالب");
        $this->stock = $stock;
    }

    public function reduceStock(int $qty): void {
        if ($qty > $this->stock) throw new \RuntimeException("لا يوجد كمية كافية في المخزون");
        $this->stock -= $qty;
    }

    public function getName(): string { return $this->name; }
    public function getPrice(): float { return $this->price; }
    public function getStock(): int { return $this->stock; }
}
