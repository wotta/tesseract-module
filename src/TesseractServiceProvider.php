<?php

namespace ConceptCore\Tesseract;

use ConceptCore\Tesseract\Objects\Tesseract;
use ConceptCore\Tesseract\Interfaces\Tesseract as TesseractInterface;
use Illuminate\Support\ServiceProvider;
use thiagoalessio\TesseractOCR\TesseractOCR;

class TesseractServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->copyConfig()->copyTranslations();
        }
    }

    public function register(): void
    {
        $this->app->bind(TesseractInterface::class, Tesseract::class);
        $this->app->bind('tesseract', Tesseract::class);
        $this->app->when(Tesseract::class)
            ->needs(TesseractOCR::class)
            ->give(function (): TesseractOCR {
                return new TesseractOCR('');
            });

        $this->mergeConfigFrom(__DIR__ . '/../config/tesseract.php', 'tesseract');
    }

    private function copyConfig(): TesseractServiceProvider
    {
        $this->publishes([
            __DIR__.'/../config/tesseract.php' => config_path('tesseract.php'),
        ], 'config');

        return $this;
    }

    private function copyTranslations(): TesseractServiceProvider
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/translations', 'Tesseract');

        return $this;
    }
}
