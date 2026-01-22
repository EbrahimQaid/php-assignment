<?php

class Product {
    private $name;
    private $price;
    private $stockQuantity;
    private $discount = 0;

    public function __construct($name, $price, $stockQuantity) {
        $this->name = $name;
        $this->price = $price;
        $this->stockQuantity = $stockQuantity;
    }

    public function getName() {
        return $this->name;
    }

    public function getStockQuantity() {
        return $this->stockQuantity;
    }

    public function setDiscount($percentage) {
        $this->discount = $percentage;
    }

    public function getPriceAfterDiscount() {
        return $this->price - ($this->price * ($this->discount / 100));
    }

    public function getOriginalPrice() {
        return $this->price;
    }

    public function isInStock() {
        return $this->stockQuantity > 0;
    }
}
