<?php

namespace ConceptCore\Tesseract\Facades;

use Illuminate\Support\Facades\Facade;

class CacheFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'tesseractCache';
    }
}