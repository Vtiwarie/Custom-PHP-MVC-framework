<?php

class Ecommerce_Shopping_Cart {

    protected $products;
    protected $quantities;
    protected static $_instance = null;

    private function __construct() {
        $this->products = array();
        $this->quantities = array();
    }

    public static function getInstance() {
        if (isset($_SESSION['cart']))
            self::$_instance = $_SESSION['cart'];
        elseif (!isset(self::$_instance))
            self::$_instance = new Ecommerce_Shopping_Cart();

        return self::$_instance;
    }

    public function addProduct(Ecommerce_Products_Product $prod) {
        $id = $prod->getId();
        $prod_type = get_class($prod);

        if (!isset($this->products[$prod_type][$id])) {
            $this->products[$prod_type][$id] = $prod;
            $this->updateProduct($prod, 1);
        }
        else
            $this->updateProduct($prod, ++$this->quantities[$prod_type][$id]);
    }

    public function removeProduct(Ecommerce_Products_Product $prod) {
        $id = $prod->getId();
        $prod_type = get_class($prod);


        if (isset($this->products[$prod_type][$id]))
            unset($this->products[$prod_type][$id]);


        if (isset($this->quantities[$prod_type][$id]))
            unset($this->quantities[$prod_type][$id]);
    }

    public function updateProduct(Ecommerce_Products_Product $prod, $quantity) {
        if (!is_int($quantity))
            throw new Exception('Quantity must be a number');

        $id = $prod->getId();
        $prod_name = get_class($prod);

        if ($quantity >= 1)
            $this->quantities[$prod_name][$id] = $quantity;
        else {
            $this->removeProduct($prod);
        }
    }

    public function getProducts() {
        return $this->products;
    }
    
    public function getProduct($prod_name, $id)
    {
        return $this->products[$prod_name][$id];
    }
    
    public function isEmpty()
    {
        return (empty($this->products));
    }

    //parameter must comply with naming conventions i.e. Ecommerce_Product_Book
    public function getTotal(Ecommerce_Products_Product $prod) {
        if (!class_exists(get_class($prod)))
            throw new Exception("unknown class $prod");

        $prod_type = get_class($prod);
        $sum = 0;
        foreach ($this->quantities[$prod_type] AS $quantity)
            $sum += $quantity;

        return $sum;
    }

    public function emptyCart() {
        $this->products = array();
        $this->quantities = array();
        unset($this->products);
        unset($this->quantities);
    }

    public function saveCart() {
        $_SESSION['cart'] = $this;
    }

    public function destroyCart() {
        $this->emptyCart();
        unset($_SESSION['cart']);
        unset($this);
    }

}

?>
