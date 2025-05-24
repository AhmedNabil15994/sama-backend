<?php

namespace Modules\Core\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

abstract class RouteServiceProvider extends ServiceProvider
{
    protected $module_name;

    protected $frontend_routes = [];

    protected $dashboard_routes = [];

    protected $trainer_routes = [];

    protected $api_routes = [];
    /**
     * @return string
     */
    protected function getFrontendNameSpace(): string
    {
        return '\Modules\\' . $this->module_name . '\\Http\Controllers\Frontend';
    }

    /**
     * @return string
     */
    protected function getDashboardNameSpace(): string
    {
        return '\Modules\\' . $this->module_name . '\\Http\Controllers\Dashboard';
    }

    protected function getTrainerNameSpace(): string
    {
        return '\Modules\\' . $this->module_name . '\\Http\Controllers\Trainer';
    }

    /**
     * @return string
     */
    protected function getApiNameSpace(): string
    {
        return '\Modules\\' . $this->module_name . '\\Http\Controllers\Api';
    }

    /**
     * @return array
     */
    protected function getFrontendRoutes(): array
    {
        $routes = [];

        if(count($this->frontend_routes)){

            foreach ($this->frontend_routes as $file){

                $routes[module_path($this->module_name, 'Routes/frontend') .'/'.$file] = $this->frontendGroups();
            }
        }

        return $routes;
    }

    /**
     * @return array
     */
    protected function getDashboardRoutes(): array
    {
        $routes = [];

        if(count($this->dashboard_routes)){

            foreach ($this->dashboard_routes as $file){

                $routes[module_path($this->module_name, 'Routes/dashboard') .'/'.$file] = $this->dashboardGroups();
            }
        }

        return $routes;
    }

    protected function getTrainerRoutes(): array
    {
        $routes = [];

        if(count($this->trainer_routes)){

            foreach ($this->trainer_routes as $file){

                $routes[module_path($this->module_name, 'Routes/trainer') .'/'.$file] = $this->trainerGroups();
            }
        }

        return $routes;
    }

    /**
     * @return array
     */
    protected function getApiRoutes(): array
    {
        $routes = [];

        if(count($this->api_routes)){

            foreach ($this->api_routes as $file){

                $routes[module_path($this->module_name, 'Routes/api') .'/'.$file] = $this->apiGroups();
            }
        }

        return $routes;
    }

    /**
     * @param Router $router
     * @param $files
     */
    private function requireRoutesFiles(Router $router ,$files){

        if(count($files)){
            foreach ($files as $file => $group){

                if ($file && file_exists($file)) {
                    $router->group(count((array)$group) ? (array)$group : [], function (Router $router) use ($file) {
                        require $file;
                    });
                }
            }
        }
    }

    /**
     *
     */
    public function boot()
    {
        parent::boot();
    }


    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    public function map(Router $router)
    {
//       TODO $this->loadRoutesFrom(DIR.'/../routes/web.php');
        $router->group(['namespace' => $this->getApiNameSpace()], function (Router $router) {
            $this->loadApiRoutes($router);
        });

        $router->group(['namespace' => $this->getDashboardNameSpace()], function (Router $router) {
            $this->loadDashboardRoutes($router);
        });

        $router->group(['namespace' => $this->getTrainerNameSpace()], function (Router $router) {
            $this->loadTrainerRoutes($router);
        });

        $router->group(['namespace' => $this->getFrontendNameSpace()], function (Router $router) {
            $this->loadFrontendRoutes($router);
        });
    }

    /**
     * @param Router $router
     */
    private function loadFrontendRoutes(Router $router)
    {
        $frontEnds = (array)$this->getFrontendRoutes();
        $this->requireRoutesFiles($router,$frontEnds);
    }
    /**
     * @param Router $router
     */
    private function loadDashboardRoutes(Router $router)
    {
        $dashboardRoutes = (array)$this->getDashboardRoutes();
        $this->requireRoutesFiles($router,$dashboardRoutes);
    }

    private function loadTrainerRoutes(Router $router)
    {
        $trainerRoutes = (array)$this->getTrainerRoutes();
        $this->requireRoutesFiles($router,$trainerRoutes);
    }

    /**
     * @param Router $router
     */
    private function loadApiRoutes(Router $router)
    {
        $apis = (array)$this->getApiRoutes();
        $this->requireRoutesFiles($router,$apis);
    }

}
