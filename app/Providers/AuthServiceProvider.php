<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\Shift;
use App\Models\Manual;
use App\Models\User;
use App\Models\Notification;
use App\Models\Faq;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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
        $this->registerPolicies();

        // 有効ユーザーか
        Gate::define('isEnable', function (User $user) {
            return $user->admin->status === 'E';
        });

        // マスターもしくは管理者ユーザー
        Gate::define('isMaster', function (User $user) {
            return $user->admin->role === 'M';
        });

        // マスターもしくは管理者ユーザー
        Gate::define('isMasterOrAdmin', function (User $user) {
            return $user->admin->role === 'M'
                 ||$user->admin->role === 'A';
        });

        // 一般ユーザー
        Gate::define('isBasic', function (User $user) {
            return $user->admin->role === 'B';
        });

        // エンジニア権限
        Gate::define('isEngineer', function (User $user) {
            return $user->admin->engineer_role === 'E';
        });

        // シフト新規申請時の権限
        Gate::define('isShiftUpdateble', function (User $user, Shift $shift) {
            return $user->id === $shift->register_id
                || $user->id === $shift->charger_id;
        });

        // お知らせ閲覧権限
        Gate::define('isntNoticeVisible', function (User $user, Notification $notice) {
            //return $user->id === $notice->register_id;
            return $notice->status === 'E'
                && in_array($user->admin->role, getArrToRole(Admin::ADMIN_ROLES, $notice->role));
        });

        // マニュアル閲覧の権限
        Gate::define('isManualVisible', function (User $user, Manual $manual) {
            $user_role    = $user->admin->role;
            $manual_roles = getArrToRole(Admin::ADMIN_ROLES, $manual->role);

            return in_array($user_role,$manual_roles);
        });

        // マニュアル編集の権限
        Gate::define('isManualUpdateble', function (User $user, Manual $manual) {
            $user_id       = $user->admin->id;
            $updatable_ids = $manual->updatable_ids.','.$manual->register_id;
            
            return in_array($user_id, explode(',', $updatable_ids));
        });

        // FAQ閲覧の権限
        Gate::define('isFaqVisible', function (User $user, Faq $faq) {
            $user_role    = $user->admin->role;
            $faq_roles = getArrToRole(Admin::ADMIN_ROLES, $faq->role);

            return in_array($user_role,$faq_roles);
        });

        // FAQ編集の権限
        Gate::define('isFaqUpdateble', function (User $user, Faq $faq) {
            $user_id       = $user->admin->id;
            $updatable_ids = $faq->updatable_ids.','.$faq->register_id;
            
            return in_array($user_id, explode(',', $updatable_ids));
        });
    }
}
