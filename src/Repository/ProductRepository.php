<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use mysql_xdevapi\Exception;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function getCategories() {
        $category = $this->createQueryBuilder('p')
            ->select('p.ProductCategory')
            ->distinct()
            ->getQuery();

        return $category->getResult();
    }

    public function deleteAll() {
        return $this->createQueryBuilder('p')
            ->delete()
            ->getQuery()
            ->execute();
    }

    public function deleteById($id) {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id = :val')
            ->setParameter('val', $id)
            ->delete()
            ->getQuery()
            ->execute();
    }
}
