<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace CodeSinging\PinAdmin\Kernel;

use CodeSinging\PinAdmin\Console\Commands\AdminCommand;
use CodeSinging\PinAdmin\Console\Commands\ApplicationsCommand;
use CodeSinging\PinAdmin\Console\Commands\ListCommand;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class PinAdminServiceProvider extends ServiceProvider
{
    /**
     * 控制台命令
     *
     * @var array
     */
    protected array $commands = [
        AdminCommand::class,
        ApplicationsCommand::class,
        ListCommand::class,
    ];

    /**
     * 应用中间件
     *
     * @var array
     */
    protected array $middlewares = [];

    /**
     * 应用中间件组
     *
     * @var array
     */
    protected array $middlewareGroups = [];

    /**
     * 注册服务
     */
    public function register()
    {
        $this->bindContainer();
    }

    /**
     * 启动服务
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->registerCommands();
            $this->registerPublishes();
            $this->registerMigrations();
        }

        if (!$this->app->configurationIsCached()){
            $this->mergeConfig();
            $this->configureAuth();
        }

        if (!$this->app->routesAreCached()){
            $this->loadRoutes();
        }

        $this->registerMiddlewares();
        $this->loadViews();
    }

    /**
     * 绑定容器
     *
     * @return void
     */
    protected function bindContainer()
    {
        $this->app->singleton(PinAdmin::LABEL, PinAdmin::class);
    }

    /**
     * 注册控制台命令
     *
     * @return void
     */
    protected function registerCommands()
    {
        $this->commands($this->commands);
    }

    /**
     * 注册中间件
     *
     * @return void
     */
    protected function registerMiddlewares(): void
    {
        /** @var Router $router */
        $router = $this->app['router'];

        foreach ($this->middlewares as $key => $middleware) {
            $router->aliasMiddleware($key, $middleware);
        }

        foreach ($this->middlewareGroups as $key => $middlewareGroup) {
            $router->middlewareGroup($key, $middlewareGroup);
        }
    }

    /**
     * 加载应用路由
     *
     * @return void
     */
    protected function loadRoutes()
    {
        $applications = Admin::applications();
        foreach ($applications as $application) {
            $this->loadRoutesFrom($application->path(Application::ROUTE_FILENAME));
        }
    }

    /**
     * 注册资源发布
     *
     * @return void
     */
    protected function registerPublishes()
    {

    }

    /**
     * 注册数据库迁移文件
     *
     * @return void
     */
    protected function registerMigrations()
    {

    }

    /**
     * 加载应用视图文件
     *
     * @return void
     */
    protected function loadViews()
    {

    }

    /**
     * 合并配置文件
     *
     * @return void
     */
    protected function mergeConfig()
    {
        if (file_exists($file = Admin::packagePath('config/admin.php'))){
            $this->mergeConfigFrom($file, Admin::label());
        }
    }

    /**
     * 配置权限认证
     *
     * @return void
     */
    protected function configureAuth()
    {
        $applications = Admin::applications();
        foreach ($applications as $name => $application) {
            config([
                'auth.guards.' . Admin::label($name) => [
                    'driver' => 'session',
                    'provider' => $name . '_users',
                ],
                'auth.providers.' . $name . '_users' => [
                    'driver' => 'eloquent',
                    'model' => 'App\\Models\\' . Str::studly($name . '_users')
                ]
            ]);
        }
    }
}