<?php


namespace App\Service;


class UserService
{
    protected $uh;

    public function __construct(UserHandlerInterface $uh)
    {
        $this->uh = $uh;
    }

    public function getUserByEmail($email)
    {
        return $this->uh->getUserByEmail($email);
    }
}