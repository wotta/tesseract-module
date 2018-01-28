<?php

namespace ConceptCore\Tesseract\Facades;

use Illuminate\Support\Facades\Facade;

class TesseractFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'tesseract';
    }
}
