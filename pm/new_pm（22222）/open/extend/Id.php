<?php
/**
 * Class Token
 * @Author AJMstr
 * @date 2017-5-8
 */

class Id {
    private static $epoch = 1293840000000;

    public static function generate($machine) {
        $timestamp = floor(microtime(true) * 1000) - self::$epoch;

        $sequence = mt_rand(0, 4095);
        if(PHP_INT_SIZE == 4) {
            return self::makeId32($timestamp, $machine, $sequence);
        } else {
            return self::makeId64($timestamp, $machine, $sequence);
        }
    }

    private static function makeId32($timestamp, $machine, $sequence) {
        $timestamp = gmp_mul((string)$timestamp, gmp_pow(2, 22));
        $machine = gmp_mul((string)$machine, gmp_pow(2, 12));
        $sequence = gmp_init((string)$sequence, 10);
        $value = gmp_or(gmp_or($timestamp, $machine), $sequence);

        return gmp_strval($value, 10);
    }

    private static function makeId64($timestamp, $machine, $sequence) {
        $value = ((int)$timestamp << 22) | ($machine << 12) | $sequence;

        return (string)$value;
    }
}