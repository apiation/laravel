<?php

declare(strict_types=1);

namespace Apiation\ApiationLaravel;

use stdClass;

class Scrambler
{
    public static function scramble($input)
    {
        foreach ($input as $key => $value) {
            data_set($input, $key, self::scrambleValue($value));
        }

        return $input;
    }

    private static function scrambleValue(mixed $value)
    {
        if (is_array($value)) {
            foreach ($value as $key => $val) {
                $value[$key] = self::scrambleValue($val);
            }

            return $value;
        }
        if (is_object($value)) {
            $object = new \stdClass;
            foreach ($value as $key => $val) {
                $object->{$key} = self::scrambleValue($val);
            }

            return $object;
        }

        return match (gettype($value)) {
            'boolean' => true,
            'integer' => 27348923749,
            'double' => 4534.343,
            'string' => 'hkjdhsfkjhsdfksdhfj',
            'array' => [],
            'object' => new stdClass(),
            'resource' => null,
            'NULL' => null,
            'unknown type' => null,
            'resource (closed)' => null,
        };
    }
}
