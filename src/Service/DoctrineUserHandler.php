<?php

namespace App\Service;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineUserHandler implements UserHandlerInterface
{
    protected $ur;
    protected $em;

    public function __construct(UserRepository $ur, EntityManagerInterface $em)
    {
        $this->ur = $ur;
        $this->em = $em;
    }

    public function getUserByEmail($email)
    {
        $user = $this->ur->findBy(['Email' => $email]);
        if(!$user) {
            throw new \Exception("User account not found!");
        }
        return $user[0];
    }
}