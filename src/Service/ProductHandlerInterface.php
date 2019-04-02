<?php


namespace App\Service;


interface ProductHandlerInterface
{
    public function createProduct($productData);
    public function getAllProducts();
    public function getProductById($id);
    public function updateProduct($productData);
    public function deleteProductById($id);
    public function getDistinctCategories();
    public function deleteAll();
}