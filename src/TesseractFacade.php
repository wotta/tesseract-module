<?php

namespace ConceptCore\Tesseract;

use Illuminate\Support\Facades\Facade;

class TesseractFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'tesseract';
    }
}
