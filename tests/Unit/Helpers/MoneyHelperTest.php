<?php

namespace Tests\Unit\Helpers;

use PHPUnit\Framework\TestCase;
use App\Helpers\MoneyHelper;

/** @coversDefaultClass MoneyHelper */
class MoneyHelperTest extends TestCase
{

    /**
     * @covers ::toMinor
     * @dataProvider toMinorProvider
     */
    public function testToMinor(?float $valueToConvert, int $expectedValue): void
    {
        $valueAfterConversion = MoneyHelper::toMinor($valueToConvert);

        $this->assertEquals($expectedValue, $valueAfterConversion);
    }


    public static function toMinorProvider(): array
    {
        return [
            [
                'valueToConvert' => 10.99,
                'expectedValue' => 1099,
            ],
            [
                'valueToConvert' => null,
                'expectedValue' => 0,
            ]
        ];
    }

    /**
     * @covers ::toDecimal
     * @dataProvider toDecimalProvider
     */
    public function testToDecimal(?int $valueToConvert, float $expectedValue): void
    {
        $valueAfterConversion = MoneyHelper::toDecimal($valueToConvert);

        $this->assertEquals($expectedValue, $valueAfterConversion);
    }

    public static function toDecimalProvider(): array
    {
        return [
            [
                'valueToConvert' => 1099,
                'expectedValue' => 10.99,
            ],
            [
                'valueToConvert' => null,
                'expectedValue' => 0,
            ]
        ];
    }

}
