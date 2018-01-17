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
        $this->mergeConfigFrom(__DIR__ . '/../config/Tesseract.php', 'Tesseract');
    }

    /**
     * @return $this
     */
    private function copyConfig()
    {
        $this->publishes([
            __DIR__ . '/../config/Tesseract.php' => config_path('Tesseract.php'),
        ], 'config');
        return $this;
    }

    /**
     * @return $this
     */
    private function copyRoutes()
    {
        $this->loadroutesFrom(__DIR__ . '/../routes/web.php');
        return $this;
    }

    /**
     * @return $this
     */
    private function copyViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'Tesseract');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/Tesseract'),
        ]);
        return $this;
    }

    /**
     * @return $this
     */
    private function copyAssets()
    {
        $this->publishes([
            __DIR__ . '/resources/assets' => public_path('vendor/Tesseract'),
        ], 'public');
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

    /**
     * @return $this
     */
    private function copyMigrations()
    {
        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations')
        ], 'migrations');
        return $this;
    }
}
