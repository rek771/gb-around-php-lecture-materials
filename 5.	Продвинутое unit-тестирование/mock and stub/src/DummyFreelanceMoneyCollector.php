<?php
namespace App;

class DummyFreelanceMoneyCollector implements FreelanceMoneyCollectorInterface
{

    public function earnMoney(float $amount): void
    {
        // do nothing
    }

    public function withdrawMoney(): string
    {
        return '';
    }
}