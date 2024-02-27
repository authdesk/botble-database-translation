<?php

namespace Botble\AdminAddon\Providers;

use Botble\AdminAddon\Models\DatabaseTranslation;
use Botble\Base\Facades\DashboardMenu;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Base\Supports\ServiceProvider;
use Illuminate\Routing\Events\RouteMatched;

class AdminAddonServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/admin-addon')
            ->loadHelpers()
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->loadRoutes();

        /* if (defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME')) {
            \Botble\LanguageAdvanced\Supports\LanguageAdvancedManager::registerModule(DatabaseTranslation::class, [
                'text',
            ]);
        } */

        $this->app['events']->listen(RouteMatched::class, function () {
            DashboardMenu::registerItem([
                'id' => 'cms-plugins-database-translation',
                'priority' => 5,
                'parent_id' => null,
                'name' => 'plugins/admin-addon::database-translation.name',
                'icon' => 'ti ti-language',
                'url' => route('database-translation.index'),
                'permissions' => ['database-translation.index'],
            ]);
        });
    }
}
