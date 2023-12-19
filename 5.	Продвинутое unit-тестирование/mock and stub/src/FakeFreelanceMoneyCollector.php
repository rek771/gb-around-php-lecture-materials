<?php
namespace App;

class FakeFreelanceMoneyCollector implements FreelanceMoneyCollectorInterface
{
    private int $sum;

    public function __construct()
    {
        $this->sum = 0;
    }

    public function earnMoney(float $amount): void
    {
        $this->sum = $this->sum + $amount;
    }

    public function withdrawMoney(): string
    {
        return "Результат: $this->sum";
    }
}