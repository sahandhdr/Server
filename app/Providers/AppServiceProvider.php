<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Services\Interfaces\Auth\AuthServiceInterfaces::class,
            \App\Services\Auth\AuthService::class,
        );
        $this->app->bind(
            \App\Repositories\Interfaces\User\UserRepositoryInterfaces::class,
            \App\Repositories\User\UserRepository::class,
        );

        $this->app->bind(
            \App\Services\Interfaces\User\UserServiceInterfaces::class,
            \App\Services\User\UserService::class,
        );

        $this->app->bind(
            \App\Repositories\Interfaces\Role\RoleRepositoryInterfaces::class,
            \App\Repositories\Role\RoleRepository::class,
        );
        $this->app->bind(
            \App\Repositories\Interfaces\Permission\PermissionRepositoryInterfaces::class,
            \App\Repositories\Permission\PermissionRepository::class,
        );

        $this->app->bind(
            \App\Services\Interfaces\Permission\PermissionServiceInterfaces::class,
            \App\Services\Permission\PermissionService::class,
        );
        $this->app->bind(
            \App\Services\Interfaces\Role\RoleServiceInterfaces::class,
            \App\Services\Role\RoleService::class,
        );

        $this->app->bind(
            \App\Repositories\Interfaces\Department\DepartmentRepositoryInterfaces::class,
            \App\Repositories\Department\DepartmentRepository::class,
        );
        $this->app->bind(
            \App\Services\Interfaces\Department\DepartmentServiceInterfaces::class,
            \App\Services\Department\DepartmentService::class,
        );

        $this->app->bind(
            \App\Repositories\Interfaces\Tag\TagRepositoryInterfaces::class,
            \App\Repositories\Tag\TagRepository::class,
        );
        $this->app->bind(
            \App\Services\Interfaces\Tag\TagServiceInterfaces::class,
            \App\Services\Tag\TagService::class,
        );

        $this->app->bind(
            \App\Repositories\Interfaces\Agent\AgentRepositoryInterfaces::class,
            \App\Repositories\Agent\AgentRepository::class,
        );
        $this->app->bind(
            \App\Services\Interfaces\Agent\AgentServiceInterfaces::class,
            \App\Services\Agent\AgentService::class,
        );

        $this->app->bind(
            \App\Repositories\Interfaces\AgentSnapshot\AgentSnapshotRepositoryInterfaces::class,
            \App\Repositories\AgentSnapshot\AgentSnapshotRepository::class,
        );
        $this->app->bind(
            \App\Services\Interfaces\AgentSnapshot\AgentSnapshotServiceInterfaces::class,
            \App\Services\AgentSnapshot\AgentSnapshotService::class,
        );

        $this->app->bind(
            \App\Services\Interfaces\Pivot\PivotServiceInterfaces::class,
            \App\Services\Pivot\PivotService::class,
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
