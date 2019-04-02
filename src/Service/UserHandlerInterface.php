<?php


namespace App\Service;


interface UserHandlerInterface
{
    public function getUserByEmail($email);
}