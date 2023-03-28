<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class SortTypeEnum extends Enum
{
    const AZ = 'A -> Z';
    const ZA = 'Z -> A';
    const PRICEUP = 'Giá tăng dần';
    const PRICEDOWN = 'Giá giảm dần';

    public static function getSortType()
    {
        return [
            'az' => self::AZ,
            'za' => self::ZA,
            'price_up' => self::PRICEUP,
            'price_down' => self::PRICEDOWN,
        ];
    }
}
