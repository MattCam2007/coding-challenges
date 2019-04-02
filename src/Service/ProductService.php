<?php


namespace App\Service;


class ProductService
{
    protected $ph;

    public function __construct(ProductHandlerInterface $ph)
    {
        $this->ph = $ph;
    }

    public function getProductById($id)
    {
        return $this->ph->getProductById($id);
    }

    public function getAllProducts()
    {
        return $this->ph->getAllProducts();
    }

    public function createProduct($productData)
    {
        return $this->ph->createProduct($productData);
    }

    public function deleteProductById($id)
    {
        return $this->ph->deleteProductById($id);
    }

    public function updateProduct($productData)
    {
        return $this->ph->updateProduct($productData);
    }

    public function getDistinctCategories()
    {
        return $this->ph->getDistinctCategories();
    }

    public function deleteAll()
    {
        return $this->ph->deleteAll();
    }
}