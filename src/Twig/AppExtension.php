<?php

namespace App\Twig;

use Symfony\Component\Form\FormErrorIterator;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('to_array', [$this, 'toArray']),
        ];
    }

    public function toArray($object): array
    {
        if ($object instanceof FormErrorIterator) {
            return iterator_to_array($object);
        }

        if (is_array($object)) {
            return $object;
        }

        if (is_object($object)) {
            // Converts the object to an array
            return json_decode(json_encode($object), true);
        }

        return [];
    }
}
