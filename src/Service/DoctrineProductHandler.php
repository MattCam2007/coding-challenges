<?php

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineProductHandler implements ProductHandlerInterface
{
    protected $pr;
    protected $em;

    public function __construct(ProductRepository $pr, EntityManagerInterface $em)
    {
        $this->pr = $pr;
        $this->em = $em;
    }

    public function getAllProducts()
    {
        return $this->pr->findAll();
    }

    public function getProductById($id)
    {
        return $this->pr->findBy(['id' => $id]);
    }

    public function getDistinctCategories()
    {
        $rc = [];
        $cats = $this->pr->getCategories();
        foreach($cats as $cat) {
            $rc[] = $cat['ProductCategory'];
        }
        return $rc;
    }

    public function createProduct($productData)
    {
        $product = new Product();
        $product->setDateCreated(new \DateTime());
        $this->saveProductData($product, $productData);
        return $product;
    }

    public function updateProduct($productData)
    {
        $product = $this->getProductById($productData['ProductId']);
        if(!$product)
        {
            throw new \Exception("Product " . $productData['ProductId'] . " not found!");
        }
        $this->saveProductData($product[0], $productData);
        return $product;
    }

    public function deleteProductById($id)
    {
        return $this->pr->deleteById($id);
    }

    public function deleteAll()
    {
        return $this->pr->deleteAll();
    }

    protected function saveProductData(Product $product, $productData)
    {
        $product->setName($productData['Name']);
        $product->setPrice($productData['Price']);
        $product->setProductCategory($productData['ProductCategory']);
        $product->setSku($productData['Sku']);
        $product->setQuantity($productData['Quantity']);
        $product->setDateModified(new \DateTime());

        $this->em->persist($product);
        $this->em->flush();

        return true;
    }


}