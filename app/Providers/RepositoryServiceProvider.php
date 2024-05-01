<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider{
    /**
     * Register services.
     */
    public function register() : void{
        // Base
        // require_once app_path() . '/Repositories/Base/ContentRepositories.php';
        // require_once app_path() . '/Repositories/Base/GenderRepositories.php';
        // require_once app_path() . '/Repositories/Base/LanguageRepositories.php';
        // require_once app_path() . '/Repositories/Base/LinkRepositories.php';
        // require_once app_path() . '/Repositories/Base/RaceRepositories.php';
    }

    /**
     * Bootstrap services.
     */
    public function boot() : void{
        //
    }
}
