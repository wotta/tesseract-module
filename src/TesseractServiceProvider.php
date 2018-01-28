<?php

namespace ConceptCore\Tesseract;

use Cache;
use ConceptCore\Tesseract\Objects\Cache\Cache as CacheObject;
use Illuminate\Support\ServiceProvider;
use ConceptCore\Tesseract\Objects\Tesseract;
use thiagoalessio\TesseractOCR\TesseractOCR;
use ConceptCore\Tesseract\Interfaces\Tesseract as TesseractInterface;
use ConceptCore\Tesseract\Interfaces\Cache\Cache as CacheInterface;

class TesseractServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Cache::extend('tesseractCache', function ($app) {
            return Cache::repository(new CacheObject());
        });

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

        $this->app->bind(CacheInterface::class, CacheObject::class);
        $this->app->bind('tesseractCache', CacheObject::class);

        $this->mergeConfigFrom(__DIR__.'/../config/tesseract.php', 'tesseract');
    }

    private function copyConfig(): self
    {
        $this->publishes([
            __DIR__ . '/../config/tesseract.php' => config_path('tesseract.php'),
        ], 'config');

        return $this;
    }

    private function copyTranslations(): self
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/translations', 'Tesseract');

        return $this;
    }
}
