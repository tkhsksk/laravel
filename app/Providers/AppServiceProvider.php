<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $yet = '<span class="text-muted">未登録</span>';
        view()->share('yet', $yet);
        view()->share('required_badge', '<span class="badge fw-semibold bg-danger-subtle text-danger fs-1 me-2">必須</span>');

        // カスタムディレクティブ@asset
        Blade::directive('asset', function ($file) {
            $file = str_replace(["'", '"'], "", $file);
            $path = public_path() . $file;
            try {
                // [注意] view:cacheにならないようPHPのスクリプトを返す
                $opt = "?<?php try { echo \File::lastModified('{$path}'); } catch (\Exception \$e) {} ?>";
            } catch(\Exception $exp) {
                // ファイルが無い場合はスキップ
                $opt = '';
            }
            return $file.$opt;
            // return secure_asset($file).$opt;
        });
        // 適用後にphp artisan view:clear
    }
}