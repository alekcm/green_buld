<?php

namespace App\Providers;

use App\Enums\UserRoleEnum;
use App\Models\Page;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isAdmin', function (User $user) {
            return $user->roleIn(UserRoleEnum::ADMIN)
                ? Response::allow()
                : Response::deny(__('auth.wrong_role'));
        });

        Gate::define('isNotBlocked', function (User $user) {

            if ($user->is_blocked) {
                Auth::guard('web')->logout();
                Request::session()->invalidate();
                Request::session()->regenerateToken();
            }

            return !$user->is_blocked
                ? Response::allow()
                : Response::deny(__('auth.is_blocked'));
        });
    }
}
