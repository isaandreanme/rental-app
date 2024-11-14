<?php

namespace App\Providers;

use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
use Filament\Actions\Action;
use Illuminate\Support\ServiceProvider;
use TomatoPHP\FilamentUsers\Resources\UserResource\Actions\CreatePageActions;
use TomatoPHP\FilamentUsers\Resources\UserResource\Actions\EditPageActions;
use TomatoPHP\FilamentUsers\Resources\UserResource\Actions\ManageUserActions;
use TomatoPHP\FilamentUsers\Resources\UserResource\Actions\ViewPageActions;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch
                ->locales(['id', 'en'])
                ->circular();
        });

        ManageUserActions::register([
            Action::make('action')
        ]);
     
        EditPageActions::register([
            Action::make('action')
        ]);
     
        ViewPageActions::register([
            Action::make('action')
        ]);
     
        CreatePageActions::register([
            Action::make('action')
        ]);
    }
}
