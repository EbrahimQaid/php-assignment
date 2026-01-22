<?php

require_once 'Product.php';

class Order {
    private $orderNumber;
    private $date;
    private $status;
    private $products = [];

    public function __construct($orderNumber, $date, $status) {
        $this->orderNumber = $orderNumber;
        $this->date = $date;
        $this->status = $status;
    }

    public function addProduct(Product $product) {
        $this->products[] = $product;
    }

    public function calculateTotal() {
        $total = 0;
        foreach ($this->products as $product) {
            $total += $product->getPriceAfterDiscount();
        }
        return $total;
    }

    public function getOrderDetails() {
        return [
            'number' => $this->orderNumber,
            'date' => $this->date,
            'status' => $this->status,
            'products_count' => count($this->products),
            'products' => $this->products
        ];
    }
}
