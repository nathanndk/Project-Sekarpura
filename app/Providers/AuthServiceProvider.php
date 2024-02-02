<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Thread;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //Role
        Gate::define('admin', function (User $user) {
            return $user->role == 3;
        });

        //Permission
        Gate::define('thread.edit', function (User $user, Thread $thread) {
            return $user->role == 3 || $user->id === $thread->user_id;
        });

        Gate::define('thread.delete', function (User $user, Thread $thread) {
            return $user->role === 3 || $user->id === $thread->user_id;
        });

        Gate::define('thread.approve', function (User $user) {
            return $user->role === 3;
        });

        Gate::define('thread.reject', function (User $user) {
            return $user->role === 3;
        });

        Gate::define('manage.role', function (User $user) {
            return $user->role === 3;
        });

        Gate::define('see.users', function (User $user) {
            return $user->role === 3;
        });

    }
}
