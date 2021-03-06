<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        // 如果开启设置就加载后台页面路由
        if (config('app.use_admin_lte')) {
            $this->mapAdminWebRoutes();
        }

        $this->mapAdminApiRoutes();

        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace.'\Web')
             ->group(base_path('routes/web.php'));
    }

    protected function mapAdminWebRoutes()
    {
        Route::prefix(config('admin.context_path'))
            ->middleware(['web','admin.checkAdminApiTokenExist','admin.userLogs'])
            ->namespace($this->namespace.'\Web\Admin')
            ->name('admin.')
            ->group(base_path('routes/admin_web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace.'\Api')
             ->name('api.')
             ->group(base_path('routes/api.php'));
    }

    protected function mapAdminApiRoutes()
    {
        $middleware = ['api','admin.userLogs'];
        if (config('app.use_admin_lte')) {
            $middleware = ['admin_api','admin.userLogs'];
        }
        Route::prefix('api/admin')
            ->middleware($middleware)
            ->namespace($this->namespace.'\Api\Admin')
            ->name('api.admin.')
            ->group(base_path('routes/admin_api.php'));
    }
}
