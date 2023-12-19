<?php
namespace TestsApi\Datasets;

interface DataProvider
{
    public static function get(): array;
}