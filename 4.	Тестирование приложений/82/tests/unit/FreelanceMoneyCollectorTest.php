<?php

namespace AppUnitTests;

use App\FreelanceMoneyCollector;
use Exception;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

class FreelanceMoneyCollectorTest extends TestCase
{
    public function testWithoutAssert(): void
    {
        $collector = new FreelanceMoneyCollector('Вася');

        $result = $collector->withdrawMoney();

        // забыли assert
    }

    public function testEarnMoney(): void
    {
        $collector = new FreelanceMoneyCollector('Александр');
        $collector->earnMoney(11000);

        $result = $collector->withdrawMoney();

        static::assertSame('Александр заработал 11000 руб. на фрилансе.', $result);
//        static::assertSame('Александр заработал 11000 руб. на фрилансе.', $result, 'Александр должен вывести столько же денег, сколько заработал.');
    }

    public function testEarnMoneyManyTime(): void
    {
        static::markTestIncomplete('Недоделанный тест');
        $collector = new FreelanceMoneyCollector('Федор');
        $collector->earnMoney(5111);
        $collector->earnMoney(3625);
        $collector->earnMoney(1234);

        $result = $collector->withdrawMoney();

        // TODO: посчитать грибы
        static::assertSame('Александр заработал ??? руб. на фрилансе.', $result);
    }

    public function testEarnMoneyWithRandomAmount(): void
    {
        static::markTestSkipped('Странная ошибка');
        $collector = new FreelanceMoneyCollector('Андрей');
        $collectedAmount = random_int(500000, 2000000);
        $collector->earnMoney($collectedAmount);

        $result = $collector->withdrawMoney();

        static::assertSame("Андрей заработал $collectedAmount руб. на фрилансе.", $result);
    }

    #[TestWith(["Василий", 20000])]
    #[TestWith(["Михаил", 15000])]
    #[TestWith(["Алексей", 77000])]
    public function testEarnMoneyWithArrays(string $name, int $collectedAmount): void
    {
        $collector = new FreelanceMoneyCollector($name);
        $collector->earnMoney($collectedAmount);

        $result = $collector->withdrawMoney();

        static::assertSame("$name заработал $collectedAmount руб. на фрилансе1.", $result);
    }

    #[DataProvider('someDataProvider')]
    public function testEarnMoneyWithDataProvider(string $name, array $collected, int $expectedCollectedAmount): void
    {
        $collector = new FreelanceMoneyCollector($name);
        foreach ($collected as $item) {
            $collector->earnMoney($item);
        }

        $result = $collector->withdrawMoney();

        static::assertSame("$name заработал $expectedCollectedAmount руб. на фрилансе.", $result);
    }

    public static function someDataProvider(): array
    {
        return [
            'Василий' => ['Василий', [20000, 4400], 244000],
            'Михаил' => ['Михаил', [15000, 0], 15000],
            'Алексей' => ['Алексей', [15000, 3300, 50000, 13000], 81300],
        ];
    }

    #[Test]
    public function testEarnTooMuchMoney(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessageMatches('/^Роман/'); // old expectExceptionMessageRegExp()

        $collector = new FreelanceMoneyCollector('Роман');
        $collector->earnMoney(1000001);

        $result = $collector->withdrawMoney();
    }
}