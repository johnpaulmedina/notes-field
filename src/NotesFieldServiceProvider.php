<?php

namespace Johnpaulmedina\NotesField;

use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Outl1ne\NovaTranslationsLoader\LoadsNovaTranslations;

class NotesFieldServiceProvider extends ServiceProvider
{
    use LoadsNovaTranslations;

    public function boot()
    {
        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');

        // Publish migrations
        $this->publishes([
            __DIR__ . '/../migrations' => database_path('migrations'),
        ], 'migrations');

        // Config
        $this->publishes([
            __DIR__ . '/../config/notes-field.php' => config_path('notes-field.php'),
        ], 'config');

        // Load translations
        $this->loadTranslations(__DIR__ . '/../lang', 'notes-field', true);

        $this->mergeConfigFrom(
            __DIR__ . '/../config/notes-field.php',
            'notes-field'
        );

        // Serve assets
        Nova::serving(function (ServingNova $event) {
            Nova::script('notes-field', __DIR__ . '/../dist/js/entry.js');
            Nova::style('notes-field', __DIR__ . '/../dist/css/entry.css');
        });

        // Load routes
        $this->app->booted(function () {
            $this->routes();
        });
    }

    protected function routes()
    {
        if ($this->app->routesAreCached()) return;

        Route::middleware(['nova'])
            ->prefix('nova-vendor/notes')
            ->namespace('\Johnpaulmedina\NotesField\Http\Controllers')
            ->group(__DIR__ . '/../routes/api.php');
    }

    public static function getTableName()
    {
        return config('notes-field.table_name', 'notes');
    }

    public static function getNotesModel()
    {
        return config('notes-field.notes_model', \Johnpaulmedina\NotesField\Models\Note::class);
    }
}
