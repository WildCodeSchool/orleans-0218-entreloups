<?php

namespace AppBundle\Service;

class SlugService
{
    const PATTERN = '/[^a-zA-Z0-9éèêàç]/';

    public function generateSlug(string $stringToSlug)
    {
        return preg_replace(self::PATTERN, '-', $stringToSlug);
    }
}
