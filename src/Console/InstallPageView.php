<?php

namespace Modla\KeysmithVue\Console;

use Illuminate\Filesystem\Filesystem;

trait InstallPageView
{
    public function installPageView()
    {
        // Composer packages
        if (! $this->requireComposerPackages(['inertiajs/inertia-laravel:^2.0'])) {
            return 1;
        }

        // Controller
        (new Filesystem)->ensureDirectoryExists(app_path('Http/Controllers/APITokens'));
        (new Filesystem)->copy(__DIR__.'/../../stubs/app/Http/Controllers/APITokens/TokenController.php', app_path('Http/Controllers/APITokens/TokenController.php'));

        // Views
        (new Filesystem)->ensureDirectoryExists(resource_path('js/pages/api-tokens'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/pages/api-tokens', resource_path('js/pages/api-tokens'));

        // Tests
        //(new Filesystem)->ensureDirectoryExists(base_path('tests/Feature'));
        //(new Filesystem)->copy(__DIR__.'/../../stubs/inertia-vue/tests/Feature/TokenTest.php', base_path('tests/Feature/TokenTest.php'));
    }
}