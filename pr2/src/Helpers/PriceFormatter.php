<?php
declare(strict_types=1);

namespace Shop\Helpers;

class PriceFormatter
{
    public static function format(float $price): string
    {
        return str_replace(' ', "\u{00A0}", number_format($price, 2, ',', ' ')) . "\u{00A0}₽";
    }
}
