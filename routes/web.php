<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\GuestController;
use App\Http\Controllers\Admin\MenuSettingController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Customer\CustomerDashboardController;
use App\Http\Controllers\Customer\SubscriptionController;
use App\Http\Controllers\Customer\WeddingController;
use App\Http\Controllers\Customer\CustomerGuestController;

/*
|--------------------------------------------------------------------------
| Public Landing & Wedding Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [LandingController::class, 'index'])->name('home');

// Direct Public Auth Shortcuts
Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AdminAuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AdminAuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

// Dynamic Public Wedding Invitation View by Slug
Route::get('/w/{slug}', [WeddingController::class, 'showPublic'])->name('w.show');
Route::get('/wedding-invitation/calendar.ics', [WeddingController::class, 'downloadIcs'])->name('wedding-invitation.ics');

/*
|--------------------------------------------------------------------------
| Customer Portal Routes (ROLE = CUSTOMER)
|--------------------------------------------------------------------------
*/
Route::group([
    'prefix' => 'customer',
    'as' => 'customer.',
    'middleware' => ['auth', \App\Http\Middleware\CustomerMiddleware::class]
], function () {
    // Customer Dashboard
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');

    // Subscription Plans & Payment
    Route::get('/subscriptions', [SubscriptionController::class, 'plans'])->name('subscriptions.plans');
    Route::post('/subscriptions/payment', [SubscriptionController::class, 'processPayment'])->name('subscriptions.payment');

    // Create & Customize Wedding
    Route::get('/wedding/create', [WeddingController::class, 'create'])->name('wedding.create');
    Route::post('/wedding/store', [WeddingController::class, 'store'])->name('wedding.store');
    Route::get('/wedding/template', [WeddingController::class, 'template'])->name('wedding.template');
    Route::post('/wedding/template', [WeddingController::class, 'setTemplate'])->name('wedding.template.set');

    // Customer Guest List Management
    Route::resource('guests', CustomerGuestController::class)->except(['show', 'create', 'edit']);

    // Send Invitations & Sharing
    Route::get('/invitations/send', [CustomerGuestController::class, 'send'])->name('invitations.send');

    // RSVP & Guest Reports
    Route::get('/reports', [CustomerGuestController::class, 'reports'])->name('reports.index');
});

/*
|--------------------------------------------------------------------------
| Admin Panel Routes (ROLE = ADMIN)
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    // Language Switcher Route
    Route::get('/lang/{locale}', function ($locale) {
        if (in_array($locale, ['kh', 'en'])) {
            session(['admin_locale' => $locale]);
        }
        return redirect()->back();
    })->name('lang');

    // Auth Routes Alias
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AdminAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AdminAuthController::class, 'register'])->name('register.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Protected Admin Routes
    Route::middleware(['admin'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // User Management
        Route::resource('users', UserController::class)->except(['show']);
        
        // User Roles Management
        Route::resource('roles', RoleController::class)->except(['show']);

        // Subscription Plans Management
        Route::resource('plans', PlanController::class)->except(['show', 'create', 'edit']);
        
        // List Guest / RSVP Management
        Route::resource('guests', GuestController::class)->except(['show']);

        // Dedicated Pages for Menu & Role Settings
        Route::get('/menu-settings', [MenuSettingController::class, 'index'])->name('menu-settings.index');
        Route::get('/menu-settings/modules', [MenuSettingController::class, 'modulesIndex'])->name('menu-settings.modules.index');
        Route::get('/menu-settings/sub-modules', [MenuSettingController::class, 'subModulesIndex'])->name('menu-settings.sub-modules.index');
        Route::get('/menu-settings/pages', [MenuSettingController::class, 'pagesIndex'])->name('menu-settings.pages.index');
        Route::get('/menu-settings/page-actions', [MenuSettingController::class, 'pageActionsIndex'])->name('menu-settings.page-actions.index');
        Route::get('/menu-settings/roles', [MenuSettingController::class, 'rolesIndex'])->name('menu-settings.roles.index');

        // Modules CRUD & Import
        Route::post('/menu-settings/modules', [MenuSettingController::class, 'storeModule'])->name('menu-settings.modules.store');
        Route::put('/menu-settings/modules/{module}', [MenuSettingController::class, 'updateModule'])->name('menu-settings.modules.update');
        Route::delete('/menu-settings/modules/{module}', [MenuSettingController::class, 'destroyModule'])->name('menu-settings.modules.destroy');
        Route::get('/menu-settings/modules/download-template', [MenuSettingController::class, 'downloadModuleTemplate'])->name('menu-settings.modules.download-template');
        Route::post('/menu-settings/modules/import', [MenuSettingController::class, 'importModules'])->name('menu-settings.modules.import');

        // Sub-Modules CRUD & Import
        Route::post('/menu-settings/sub-modules', [MenuSettingController::class, 'storeSubModule'])->name('menu-settings.sub-modules.store');
        Route::put('/menu-settings/sub-modules/{subModule}', [MenuSettingController::class, 'updateSubModule'])->name('menu-settings.sub-modules.update');
        Route::delete('/menu-settings/sub-modules/{subModule}', [MenuSettingController::class, 'destroySubModule'])->name('menu-settings.sub-modules.destroy');
        Route::get('/menu-settings/sub-modules/download-template', [MenuSettingController::class, 'downloadSubModuleTemplate'])->name('menu-settings.sub-modules.download-template');
        Route::post('/menu-settings/sub-modules/import', [MenuSettingController::class, 'importSubModules'])->name('menu-settings.sub-modules.import');

        // Pages CRUD & Import
        Route::post('/menu-settings/pages', [MenuSettingController::class, 'storePage'])->name('menu-settings.pages.store');
        Route::put('/menu-settings/pages/{page}', [MenuSettingController::class, 'updatePage'])->name('menu-settings.pages.update');
        Route::delete('/menu-settings/pages/{page}', [MenuSettingController::class, 'destroyPage'])->name('menu-settings.pages.destroy');
        Route::get('/menu-settings/pages/download-template', [MenuSettingController::class, 'downloadPageTemplate'])->name('menu-settings.pages.download-template');
        Route::post('/menu-settings/pages/import', [MenuSettingController::class, 'importPages'])->name('menu-settings.pages.import');

        // Page Actions CRUD & Import
        Route::post('/menu-settings/page-actions', [MenuSettingController::class, 'storePageAction'])->name('menu-settings.page-actions.store');
        Route::put('/menu-settings/page-actions/{pageAction}', [MenuSettingController::class, 'updatePageAction'])->name('menu-settings.page-actions.update');
        Route::delete('/menu-settings/page-actions/{pageAction}', [MenuSettingController::class, 'destroyPageAction'])->name('menu-settings.page-actions.destroy');
        Route::get('/menu-settings/page-actions/download-template', [MenuSettingController::class, 'downloadPageActionTemplate'])->name('menu-settings.page-actions.download-template');
        Route::post('/menu-settings/page-actions/import', [MenuSettingController::class, 'importPageActions'])->name('menu-settings.page-actions.import');

        // System Structure Package Export / Import
        Route::get('/menu-settings/export-json', [MenuSettingController::class, 'exportSystemJson'])->name('menu-settings.export-json');
        Route::post('/menu-settings/import-json', [MenuSettingController::class, 'importSystemJson'])->name('menu-settings.import-json');

        Route::post('/menu-settings/role-access', [MenuSettingController::class, 'saveRoleAccess'])->name('menu-settings.role-access.save');
    });
});
