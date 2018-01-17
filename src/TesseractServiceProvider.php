<?php

namespace ConceptCore\Tesseract;

use Illuminate\Support\ServiceProvider;

class TesseractServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {

            $this->copyConfig()
                ->copyRoutes()
                ->copyViews()
                ->copyAssets()
                ->copyTranslations()
                ->copyMigrations();
        }
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/tesseract.php', 'tesseract');
    }

    /**
     * @return $this
     */
    private function copyConfig()
    {
        $this->publishes([
            __DIR__ . '/../config/tesseract.php' => config_path('tesseract.php'),
        ], 'config');
        return $this;
    }

    /**
     * @return $this
     */
    private function copyTranslations()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/translations', 'Tesseract');
        return $this;
    }
}
