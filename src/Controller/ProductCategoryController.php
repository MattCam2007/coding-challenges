<?php
namespace App\Controller;

use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ProductCategoryController extends AbstractController
{
    protected $ps;

    public function __construct(ProductService $ps)
    {
        $this->ps = $ps;
    }

    public function getAll() {
        try
        {
            $rc = $this->ps->getDistinctCategories();

            return $this->json([
                'payload' => ['ProductCategory' => $rc],
            ]);
        } catch (\Exception $ex) {
            return $this->json([
                'payload' => ['Error' => $ex->getMessage()],
            ]);
        }
    }
}