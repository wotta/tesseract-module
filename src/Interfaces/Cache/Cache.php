<?php

namespace ConceptCore\Tesseract\Interfaces\Cache;

use Illuminate\Contracts\Cache\Store;

interface Cache extends Store
{
    public function all(): array;

    public function has(string $key): bool;
}