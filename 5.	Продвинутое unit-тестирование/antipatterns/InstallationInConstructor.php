<?php

class InstallationInConstructor
{
    private Order $order;

//    public function __construct()
//    {
//        $this->order = new Order(new User);
//    }

    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}