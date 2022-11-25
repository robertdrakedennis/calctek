<?php

namespace App\Support;

use Arr;

trait InteractsWithCalculator
{
    public static function calculate(string $equation): string
    {
        $tokens = static::tokenize($equation);

        [$stack, $output] = static::processTokens($tokens);

        return static::compute($stack, $output);
    }

    public static function tokenize(string $payload): array
    {
        return preg_split('/([()+\-*\/^])/', $payload, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
    }

    public static function operators(): array
    {
        return [
            '^' => 3,
            '*' => 2,
            '/' => 2,
            '+' => 1,
            '-' => 1
        ];
    }

    public static function processTokens(array $tokens): array
    {
        $stack = [];
        $output = [];

        foreach ($tokens as $token) {
            if (is_numeric($token)) {
                $output[] = $token;
            } else {
                while ($stack && static::operators()[$token] <= static::operators()[end($stack)]) {
                    $output[] = array_pop($stack);
                }
                $stack[] = $token;
            }
        }

        while ($stack) $output[] = array_pop($stack);

        return [$stack, $output];
    }

    public static function compute(array $stack, array $output): string
    {
        foreach ($output as $token) {
            if (is_numeric($token)) {
                $stack[] = $token;
            } else {
                $op2 = array_pop($stack);
                $op1 = array_pop($stack);
                match (true) {
                    $token === '+' => $stack[] = $op1 + $op2,
                    $token === '-' => $stack[] = $op1 - $op2,
                    $token === '/' => $stack[] = $op1 / $op2,
                    $token === '*' => $stack[] = $op1 * $op2
                };
            }
        }

        return (string) Arr::first($stack);
    }
}
