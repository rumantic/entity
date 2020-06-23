<?php

namespace Sitebill\Entity;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class EntityServiceProvider extends ServiceProvider
{
    /**
     * Where the route file lives, both inside the package and in the app (if overwritten).
     *
     * @var string
     */
    public $routeFilePath = '/routes/entity.php';

    /**
     * Register the application services.
     */
    public function register()
    {
        // setup the routes
        $this->setupRoutes($this->app->router);

        //$this->app->make('Sitebill\Sitebill');
        //$this->app->register('Sitebill\CRUD');

        /*
        $this->app->make('Sitebill\Http\Controllers\SitebillGridController');
        $this->app->register('Sitebill\Http\Controllers\SitebillGridController');


        $this->app->register(VoyagerEventServiceProvider::class);
        $this->app->register(ImageServiceProvider::class);
        $this->app->register(VoyagerDummyServiceProvider::class);
        $this->app->register(VoyagerHooksServiceProvider::class);
        $this->app->register(DoctrineSupportServiceProvider::class);

        $loader = AliasLoader::getInstance();
        $loader->alias('Voyager', VoyagerFacade::class);

        $this->app->singleton('voyager', function () {
            return new Voyager();
        });

        $this->app->singleton('VoyagerGuard', function () {
            return config('auth.defaults.guard', 'web');
        });

        $this->loadHelpers();

        $this->registerAlertComponents();
        $this->registerFormFields();

        $this->registerConfigs();

        if ($this->app->runningInConsole()) {
            $this->registerPublishableResources();
            $this->registerConsoleCommands();
        }

        if (!$this->app->runningInConsole() || config('app.env') == 'testing') {
            $this->registerAppCommands();
        }
        */
    }

    /**
     * Bootstrap the application services.
     *
     * @param \Illuminate\Routing\Router $router
     */
    public function boot(Router $router, Dispatcher $event)
    {
        $this->loadTranslationsFrom(realpath(__DIR__.'/resources/lang'), 'sitebill');
        //$this->loadViewsFrom(__DIR__.'/../resources/views', 'sitebill_entity');
        $this->loadViewsWithFallbacks();
        //$this->loadRoutesFrom(__DIR__.'/../routes/routes.php');
    }

    public function loadViewsWithFallbacks()
    {
        $customBaseFolder = resource_path('views/vendor/sitebill');

        // - first the published/overwritten views (in case they have any changes)
        if (file_exists($customBaseFolder)) {
            $this->loadViewsFrom($customBaseFolder, 'sitebill_entity');
        }
        // - then the stock views that come with the package, in case a published view might be missing
        $this->loadViewsFrom(realpath(__DIR__.'/resources/views'), 'sitebill_entity');
    }


    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        // by default, use the routes file provided in vendor
        $routeFilePathInUse = __DIR__.$this->routeFilePath;

        // but if there's a file with the same name in routes/backpack, use that one
        if (file_exists(base_path().$this->routeFilePath)) {
            $routeFilePathInUse = base_path().$this->routeFilePath;
        }

        $this->loadRoutesFrom($routeFilePathInUse);
    }

}
