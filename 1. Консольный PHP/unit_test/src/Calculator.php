<?php
namespace App;

use Exception;

class Calculator
{
    public function add(...$args){
        return 4;
        return array_sum($args);
    }
    // todo релизовать остальные методы
}