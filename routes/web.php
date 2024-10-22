<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\TopController;
use App\Http\Controllers\SignInController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\EmploymentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CorpController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ManualController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ConfigController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::fallback(function() {
    return response()->view('errors.404', [], 404);
    return response()->view('errors.403', [], 403);
    return response()->view('errors.419', [], 419);
});

Route::group(['middleware' => ['auth', 'can:isEnable']], function () {
    Route::get ('/public/{page?}/{path?}',         [FileController::class, 'publicNoid'])->where('path', '.*');
    Route::get ('/public/{page?}/{id?}/{path?}',   [FileController::class, 'public'])->where('path', '.*');
});

Route::group(['middleware' => ['auth', 'can:isEnable', 'can:isMaster']], function () {
    Route::get ('/protected/{page?}/{id?}/{path?}',[FileController::class, 'protected'])->where('path', '.*');
});

Route::group(['middleware' => ['auth', 'can:isEnable']], function (){
    Route::get ('/',                      [TopController::class, 'index'])       ->name('home');
    Route::get ('/cookie',                [TopController::class, 'cookie'])      ->name('cookie');
    Route::post('/signout',               [SignInController::class, 'signout'])  ->name('signout');
    Route::post('/upload/{id?}',          [PostController::class, 'upload']);
    Route::get ('/getfiledata',           [PostController::class, 'getfiledata'])->name('getfiledata');

    Route::get ('/profile',               [ProfileController::class, 'index']);
    Route::post('/profile',               [ProfileController::class, 'index']);
    Route::get ('/profile/edit',          [ProfileController::class, 'edit']);
    Route::post('/profile/confirm',       [ProfileController::class, 'confirm']) ->name('profile.confirm');
    Route::post('/profile/store',         [ProfileController::class, 'store'])   ->name('profile.store');
    Route::post('/profile/easy',          [ProfileController::class, 'easy'])   ->name('profile.easy');
    Route::post('/profile/note',          [ProfileController::class, 'note'])    ->name('note.store');
    Route::get ('/profile/note/get',      [ProfileController::class, 'getNote']) ->name('note.get');

    Route::get ('/shift/detail/{id?}',    [ShiftController::class, 'detail']);
    Route::get ('/shift/edit/{id?}',      [ShiftController::class, 'edit'])      ->name('shift.edit');
    Route::post('/shift/confirm',         [ShiftController::class, 'confirm'])   ->name('shift.confirm');
    Route::post('/shift/store',           [ShiftController::class, 'store'])     ->name('shift.store');
    Route::get ('/shift/approval/{id?}',  [ShiftController::class, 'approval'])  ->name('shift.approval');
    Route::get ('/shift/calendar',        [ShiftController::class, 'calendar']);
    Route::get ('/getshiftdata',          [ShiftController::class, 'getshiftdata'])->name('getshiftdata');

    // Route::get ('/task',                  [TaskController::class, 'index']);
    // Route::get ('/task/detail/{id?}',     [TaskController::class, 'detail']);
    Route::get ('/notification/list',     [NotificationController::class, 'list']);

    Route::get ('/order',                 [OrderController::class, 'index']);
    Route::get ('/order/detail/{id?}',    [OrderController::class, 'detail']);
    Route::get ('/order/edit/{id?}',      [OrderController::class, 'edit']);
    Route::post('/order/confirm',         [OrderController::class, 'confirm'])     ->name('order.confirm');
    Route::post('/order/store',           [OrderController::class, 'store'])       ->name('order.store');

    Route::get ('/manual',                [ManualController::class, 'index']);
    Route::get ('/manual/detail/{id?}',   [ManualController::class, 'detail'])     ->name('manual.detail');
    Route::get ('/manual/edit/{id?}',     [ManualController::class, 'edit'])       ->name('manual.edit');
    Route::post('/manual/confirm',        [ManualController::class, 'confirm'])    ->name('manual.confirm');
    Route::post('/manual/store',          [ManualController::class, 'store'])      ->name('manual.store');
    Route::get ('/manual/favorite',       [ManualController::class, 'favorite'])   ->name('manual.favorite');

    Route::get ('/faq',                   [FaqController::class, 'index'])   ->name('faq.index');
    Route::get ('/faq/edit/{id?}',        [FaqController::class, 'edit'])   ->name('faq.edit');
    Route::post('/faq/confirm',           [FaqController::class, 'confirm'])   ->name('faq.confirm');
    Route::post('/faq/store',             [FaqController::class, 'store'])->name('faq.store');
    Route::get ('/faq/search',            [FaqController::class, 'search'])  ->name('faq.search');

    Route::group(['middleware' => ['can:isEngineer']], function () {
        Route::get ('/site',                  [SiteController::class, 'index']);
        Route::get ('/site/detail/{id?}',     [SiteController::class, 'detail']);
        Route::get ('/site/edit/{id?}',       [SiteController::class, 'edit'])   ->name('site.edit');
        Route::post('/site/confirm',          [SiteController::class, 'confirm'])->name('site.confirm');
        Route::post('/site/store',            [SiteController::class, 'store'])  ->name('site.store');
        Route::get ('/site/ajax',             [SiteController::class, 'ajax'])   ->name('site.ajax');
    });

    Route::group(['middleware' => ['can:isMaster']], function () {
        Route::get ('/server',               [SiteController::class, 'indexServer']);
        Route::get ('/server/detail/{id?}',  [SiteController::class, 'detailServer']);
        Route::get ('/server/edit/{id?}',    [SiteController::class, 'editServer']) ->name('server.edit');
        Route::post('/server/confirm',       [SiteController::class, 'confirmServer'])   ->name('server.confirm');
        Route::post('/server/store',         [SiteController::class, 'storeServer'])->name('server.store');

        Route::get ('/database',             [SiteController::class, 'indexDatabase']);
        Route::get ('/database/detail/{id?}',[SiteController::class, 'detailDatabase']);
        Route::get ('/database/edit/{id?}',  [SiteController::class, 'editDatabase']) ->name('database.edit');
        Route::post('/database/confirm',     [SiteController::class, 'confirmDatabase'])   ->name('database.confirm');
        Route::post('/database/store',       [SiteController::class, 'storeDatabase'])->name('database.store');

        Route::get ('/employment',            [EmploymentController::class, 'index'])     ->name('employment.index');
        Route::get ('/employment/ajax',       [EmploymentController::class, 'ajax'])      ->name('employment.ajax');
        Route::post('/employment/update',     [EmploymentController::class, 'update'])    ->name('employment.update');

        Route::get ('/user/detail/{id?}',     [AdminController::class, 'detail']);
        Route::get ('/user/edit/{id?}',       [AdminController::class, 'edit']);
        Route::get ('/user/ajax',             [AdminController::class, 'ajax'])      ->name('user.ajax');
        Route::get ('/user/equipment',        [AdminController::class, 'equipment']) ->name('user.equipment');
        Route::post('/user/confirm/{id?}',    [AdminController::class, 'confirm'])   ->name('user.confirm');
        Route::post('/user/store',            [AdminController::class, 'store'])     ->name('user.store');
        Route::post('/user/media',            [AdminController::class, 'media'])      ->name('user.media');
        Route::post('/user/file',             [AdminController::class, 'file'])      ->name('user.file');

        Route::get ('/corp',                  [CorpController::class, 'index'])     ->name('corp.index');
        Route::get ('/corp/ajax',             [CorpController::class, 'ajax'])      ->name('corp.ajax');
        Route::post('/corp/update',           [CorpController::class, 'update'])    ->name('corp.update');

        Route::get ('/location',              [LocationController::class, 'index']);
        Route::get ('/location/detail/{id?}', [LocationController::class, 'detail']);
        Route::get ('/location/edit/{id?}',   [LocationController::class, 'edit']) ->name('location.edit');
        Route::post('/location/confirm',      [LocationController::class, 'confirm'])   ->name('location.confirm');
        Route::post('/location/store',        [LocationController::class, 'store'])->name('location.store');
        Route::post('/location/media',        [LocationController::class, 'media'])      ->name('location.media');
        Route::post('/location/file',         [LocationController::class, 'file'])      ->name('location.file');

        Route::get ('/config',                [ConfigController::class, 'index']);
        Route::post('/config/store',          [ConfigController::class, 'store'])->name('config.store');

        Route::get ('/location/ajax',         [LocationController::class, 'ajax'])      ->name('location.ajax');
        Route::post('/location/department',   [LocationController::class, 'department'])->name('location.department');
    });

    Route::group(['middleware' => ['can:isMasterOrAdmin']], function () {
        Route::get ('/admin',                 [AdminController::class, 'index'])     ->name('admin.index');
        Route::post('/admin',                 [AdminController::class, 'index']);
        Route::post('/admin/add',             [AdminController::class, 'add'])       ->name('admin.add');
        
        Route::get ('/equipment',             [EquipmentController::class, 'index']);
        Route::get ('/equipment/detail/{id?}',[EquipmentController::class, 'detail']);
        Route::get ('/equipment/edit/{id?}',  [EquipmentController::class, 'edit'])    ->name('equipment.edit');
        Route::post('/equipment/confirm',     [EquipmentController::class, 'confirm']) ->name('equipment.confirm');
        Route::post('/equipment/store',       [EquipmentController::class, 'store'])   ->name('equipment.store');
        Route::get ('/equipment/ajax',        [EquipmentController::class, 'ajax'])    ->name('equipment.ajax');

        Route::get ('/notification',              [NotificationController::class, 'index']);
        Route::get ('/notification/edit/{id?}',   [NotificationController::class, 'edit']) ->name('notification.edit');
        Route::post('/notification/confirm',      [NotificationController::class, 'confirm'])   ->name('notification.confirm');
        Route::post('/notification/store',        [NotificationController::class, 'store'])->name('notification.store');

        Route::get ('/shift/admin/edit/{id?}',    [ShiftController::class, 'editAdmin'])      ->name('shift.admin.edit');
        Route::get ('/shift/total',               [ShiftController::class, 'total'])      ->name('shift.total');

        Route::get ('/shift',                 [ShiftController::class, 'index']);
    });
    
    Route::get ('/notification/detail/{id?}', [NotificationController::class, 'detail']);
});

Route::get ('/signin',          [SignInController::class, 'index'])   ->name('login');
Route::post('/signin',          [SignInController::class, 'signin']);

Route::get ('/register',        [RegisterController::class, 'index']);
Route::post('/register',        [RegisterController::class, 'register']);

Route::get ('/password',        [PasswordController::class, 'index']);
Route::post('/password',        [PasswordController::class, 'send']);
Route::get ('/password/sent',   [PasswordController::class, 'sent'])->name('password.sent');
Route::get ('/password/reset',  [PasswordController::class, 'reset'])->name('password.reset');
Route::post('/password/reset',  [PasswordController::class, 'change'])->name('password.change');
Route::get ('/password/bye',    [PasswordController::class, 'bye'])->name('hello.bye');
Route::get ('/password/invalid',[PasswordController::class, 'invalid'])->name('password.invalid');
