<?php

namespace App\Controller;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use \App\Service\ProductService;

class ProductController extends AbstractController
{
    protected $ps;
    protected $us;

    public function __construct(ProductService $ps, UserService $us)
    {
        $this->ps = $ps;
        $this->us = $us;
    }

    // Get All
    public function getAll()
    {
        try
        {
            $rc = $this->ps->getAllProducts();
            return $this->json([
                'payload' => ['Product' => $rc],
            ]);
        } catch (\Exception $ex) {
            error_log("Failed getAll() call! " . $ex->getMessage());
            return $this->json([
                'payload' => ['Error' => $ex->getMessage()],
            ], 500);
        }
    }

    // Get By Id
    public function getById(Request $request)
    {
        try
        {
            $id = $request->attributes->get('id');
            if(!$id)
            {
                error_log("Failed getById() call! " . "Incorrect Parameters Passed!");
                return $this->json([
                    'payload' => ['Error' => "Incorrect parameters passed!"],
                ]);
            }
            $rc = $this->ps->getProductById($id);

            return $this->json([
                'payload' => ['Product' => $rc],
            ]);
        } catch (\Exception $ex) {
            error_log("Failed getById() call! " . $ex->getMessage());
            return $this->json([
                'payload' => ['Error' => $ex->getMessage()],
            ], 500);
        }
    }

    // Create
    public function create(Request $request) {
        if(!$this->authenticateUser($request)) {
            return $this->json([
                'payload' => ['Error' => "You are not authenticated for this action"],
            ], 403);
        }

        // Validate everything we need to create object is passed
        if(!$request->request->get('Name') || !$request->request->get('ProductCategory')
            || !$request->request->get('Sku') || !$request->request->get('Price')
            || !$request->request->get('Quantity'))
        {
            error_log("Failed create() call! " . "Incorrect Parameters Passed!");
            return $this->json([
                'payload' => ['Error' => "Incorrect parameters passed!"],
            ]);
        }

        // Assign values to array
        $productData['Name'] = $request->request->get('Name');
        $productData['ProductCategory'] = $request->request->get('ProductCategory');
        $productData['Sku'] =  $request->request->get('Sku');
        $productData['Price'] =  $request->request->get('Price');
        $productData['Quantity'] =  $request->request->get('Quantity');

        // Try to create the product or fail
        try
        {
            $rc = $this->ps->createProduct($productData);

            return $this->json([
                'payload' => ['Product' => $rc],
            ]);
        } catch (\Exception $ex) {
            error_log("Failed create() call! " . $ex->getMessage());
            return $this->json([
                'payload' => ['Error' => $ex->getMessage()],
            ], 500);
        }
    }

    // Update - This is acting like a PATCH, a PUT should also be implemented
    public function update(Request $request)
    {
        if(!$this->authenticateUser($request)) {
            return $this->json([
                'payload' => ['Error' => "You are not authenticated for this action"],
            ], 403);
        }
        if((!$request->request->get('Name') && !$request->request->get('ProductCategory')
            && !$request->request->get('Sku') && !$request->request->get('Price')
            && !$request->request->get('Quantity')) || !$request->attributes->get('id'))
        {
            error_log("Failed getById() call! " . "Incorrect Parameters Passed!");
            return $this->json([
                'payload' => ['Error' => "Incorrect parameters passed!"],
            ]);
        }

        $productData['ProductId'] = $request->attributes->get('id');

        if($request->request->get('Name')) { $productData['Name'] = $request->request->get('Name'); }
        if($request->request->get('ProductCategory')) { $productData['ProductCategory'] = $request->request->get('ProductCategory'); }
        if($request->request->get('Sku')) { $productData['Sku'] =  $request->request->get('Sku'); }
        if($request->request->get('Price')) { $productData['Price'] =  $request->request->get('Price'); }
        if($request->request->get('Quantity')) { $productData['Quantity'] =  $request->request->get('Quantity'); }

        try
        {
            $rc = $this->ps->updateProduct($productData);

            return $this->json([
                'payload' => ['Product' => $rc],
            ]);
        } catch (\Exception $ex) {
            error_log("Failed update() call! " . $ex->getMessage());
            return $this->json([
                'payload' => ['Error' => $ex->getMessage()],
            ], 500);
        }
    }

    // Delete
    public function delete(Request $request)
    {
        if(!$this->authenticateUser($request)) {
            return $this->json([
                'payload' => ['Error' => "You are not authenticated for this action"],
            ], 403);
        }
        $id = $request->attributes->get('id');
        try
        {
            $rc = $this->ps->deleteProductById($id);

            return $this->json([
                'Deleted' => $rc
            ]);
        } catch (\Exception $ex) {
            error_log("Failed delete() call! " . $ex->getMessage());
            return $this->json([
                'payload' => ['Error' => $ex->getMessage()],
            ], 500);
        }
    }

    protected function authenticateUser(Request $request)
    {

        $email = $request->headers->get('email');
        $password = md5($request->headers->get('password'));

        try {
            $user = $this->us->getUserByEmail($email);
        } catch (\Exception $ex) {
            error_log("Failed authenticateUser() call! " . $ex->getMessage());
            return false;
        }

        if($password == $user->getPassword()) {
            return true;
        }
        return false;
    }
}
