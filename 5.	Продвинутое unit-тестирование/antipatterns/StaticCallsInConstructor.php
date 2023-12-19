<?php

class StaticCallsInConstructor
{
    private User $user;

//    public function __construct(string $userName)
//    {
//        $this->user = User::getUserByName($userName);
//    }
//
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}