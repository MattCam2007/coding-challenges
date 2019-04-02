<?php
namespace App\Controller;

use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class StatusController extends AbstractController
{
    public function status() {
        return $this->json([
            'payload' => ['Status' => 'Up!']
        ]);
    }
}