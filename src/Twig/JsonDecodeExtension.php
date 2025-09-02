<?php

// src/Twig/JsonDecodeExtension.php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class JsonDecodeExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('json_decode', [$this, 'decode'], ['is_safe' => ['all']]),
        ];
    }

    public function decode(string $json): array
    {
        return json_decode($json, true) ?? [];
    }
}
