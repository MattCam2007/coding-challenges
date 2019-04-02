<?php
namespace App\Controller;

use App\Entity\User;
use App\Kernel;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\KernelInterface;
use \App\Service\ProductService;

use App\Entity\Product;


// I openly acknowledge that this is not the cleanest Seeding methodology in the world. I wanted to focus on the actual
// assignment more than the seeding of the data.
class Seed extends AbstractController
{

    protected $kernel;
    protected $request;
    protected $ps;

    public function __construct(KernelInterface $kernel, ProductService $ps) {
        $this->kernel = $kernel;
        $this->ps = $ps;
    }

    public function handle(Request $request)
    {
        $this->request = $request;
        //$requestMethod = $request->server->get('REQUEST_METHOD');
        return $this->post($this->request);
    }

    public function post(Request $request) {

        $del = $this->ps->deleteAll();
        $delUser = $this->ps->deleteAll();
        $seedData = json_decode(file_get_contents($this->kernel->getProjectDir() . '/seed.json'));

        // If I have time I will come back here, but if you are reading this, I did not...
        $entityManager = $this->getDoctrine()->getManager();
        $i = 1;
        foreach($seedData->products as $seedproduct) {
            $product = new Product();

            $product->setName($seedproduct->name);
            $product->setPrice($seedproduct->price);
            $product->setProductCategory($seedproduct->category);
            $product->setSku($seedproduct->sku);
            $product->setQuantity($seedproduct->quantity);
            $product->setDateCreated(new \DateTime());
            $product->setDateModified(new \DateTime());
            $entityManager->persist($product);
            $i++;
        }

        $y = 0;
        foreach($seedData->users as $seeduser) {
            $user = new User();
            $user->setName($seeduser->name);
            $user->setEmail($seeduser->email);
            $user->setPassword(md5('qwert'));
            $user->setDateCreated(new \DateTime());
            $user->setDateModified(new \DateTime());
            $entityManager->persist($user);
            $y++;
        }

        $entityManager->flush();

        return $this->json([
            'CreatedProducts' => $i,
            'DeletedProducts' => $del,
            'CreatedUsers' => $y,
            'DeletedUsers' => $delUser
        ]);
    }
}