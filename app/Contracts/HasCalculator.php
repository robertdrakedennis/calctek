<?php

namespace App\Contracts;

interface HasCalculator
{
    static function calculate(string $equation): string;

    static function tokenize(string $payload): array;

    static function operators(): array;

    static function processTokens(array $tokens): array;

    static function compute(array $stack, array $output): string;
}
