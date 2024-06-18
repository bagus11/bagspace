<?php

namespace App\Helpers;

class MonthRomawi {
    public static function romawi($month) {
        $romawi = [
            '01' => 'I', '02' => 'II', '03' => 'III', '04' => 'IV',
            '05' => 'V', '06' => 'VI', '07' => 'VII', '08' => 'VIII',
            '09' => 'IX', '10' => 'X', '11' => 'XI', '12' => 'XII'
        ];
        return $romawi[$month];
    }
}