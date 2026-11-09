<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ContactMessageController as AdminMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\MediaController as AdminMediaController;
use App\Http\Controllers\Admin\MenuItemController as AdminMenuItemController;
use App\Http\Controllers\Admin\NavigationController as AdminNavigationController;
use App\Http\Controllers\Admin\OfferController as AdminOfferController;
use App\Http\Controllers\Admin\OpeningHourController as AdminOpeningHourController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\RedirectController as AdminRedirectController;
use App\Http\Controllers\Admin\RestaurantController as AdminRestaurantController;
use App\Http\Controllers\Admin\SeoController as AdminSeoController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\SubcategoryController as AdminSubcategoryController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Website\ContactController;
use App\Http\Controllers\Website\HomeController;
use App\Http\Controllers\Website\MenuController;
use App\Http\Controllers\Website\PageController;
use App\Http\Controllers\Website\RobotsController;
use App\Http\Controllers\Website\SitemapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public SEO and Crawler Endpoints
|--------------------------------------------------------------------------
*/
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', [RobotsController::class, 'index'])->name('robots');

/*
|--------------------------------------------------------------------------
| One-Time Production Deployment Setup Endpoint
|--------------------------------------------------------------------------
*/
Route::get('/deploy-setup', function (\Illuminate\Http\Request $request) {
    $token = $request->query('token');
    $secret = env('DEPLOY_SECRET', 'setup-restaurant-2026');
    if (!$token || $token !== $secret) {
        abort(403, 'Unauthorized setup access. Please provide the secret token: ?token=setup-restaurant-2026');
    }

    $results = [];

    // 1. Check APP_KEY
    $appKey = config('app.key');
    if (empty($appKey)) {
        \Illuminate\Support\Facades\Artisan::call('key:generate', ['--force' => true]);
        $results['app_key'] = 'Application key generated successfully.';
    } else {
        $results['app_key'] = 'Application key is already set.';
    }

    // 2. Check Database Connectivity
    try {
        \Illuminate\Support\Facades\DB::connection()->getPdo();
        $results['database'] = 'Connected successfully to ' . config('database.default') . ' database.';
    } catch (\Throwable $e) {
        return response()->json([
            'status' => 'error',
            'step' => 'database_connection',
            'message' => 'Database connection failed: ' . $e->getMessage(),
            'hint' => 'Check DB_DATABASE, DB_USERNAME, and DB_PASSWORD in your .env file on Hostinger.',
        ], 500);
    }

    // 3. Run Migrations
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        $results['migrations'] = trim(\Illuminate\Support\Facades\Artisan::output());
    } catch (\Throwable $e) {
        return response()->json([
            'status' => 'error',
            'step' => 'migrations',
            'message' => 'Migration failed: ' . $e->getMessage(),
        ], 500);
    }

    // 4. Run Seeders
    try {
        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
        $results['seeders'] = trim(\Illuminate\Support\Facades\Artisan::output());
    } catch (\Throwable $e) {
        return response()->json([
            'status' => 'error',
            'step' => 'seeders',
            'message' => 'Seeding failed: ' . $e->getMessage(),
        ], 500);
    }

    // 5. Storage Symlink
    try {
        \Illuminate\Support\Facades\Artisan::call('storage:link');
        $results['storage_link'] = trim(\Illuminate\Support\Facades\Artisan::output());
    } catch (\Throwable $e) {
        $results['storage_link'] = 'Notice: ' . $e->getMessage();
    }

    return response()->json([
        'status' => 'success',
        'message' => 'All deployment setup steps completed successfully!',
        'details' => $results,
        'links' => [
            'home' => url('/'),
            'admin_login' => url('/admin/login'),
        ],
    ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
})->name('deploy.setup');

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', fn () => redirect()->route('admin.login'))->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    });

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // Admin Profile & Password
        Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
        Route::match(['post', 'put'], '/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
        Route::put('/password', [AuthController::class, 'updatePassword'])->name('password.update');

        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.alt');

        // CMS Pages & Section Builder
        Route::get('/pages/{page}/sections', [AdminPageController::class, 'sections'])->name('pages.sections');
        Route::post('/pages/{page}/sections', [AdminPageController::class, 'storeSection'])->name('pages.sections.store');
        Route::post('/pages/{page}/sections/add', [AdminPageController::class, 'storeSection'])->name('pages.sections.add');
        Route::put('/pages/{page}/sections/{section}', [AdminPageController::class, 'updateSection'])->name('pages.sections.update');
        Route::delete('/pages/{page}/sections/{section}', [AdminPageController::class, 'destroySection'])->name('pages.sections.destroy');
        Route::post('/pages/{page}/sections/reorder', [AdminPageController::class, 'reorderSections'])->name('pages.sections.reorder');
        Route::post('/pages/{page}/sections/{section}/toggle', [AdminPageController::class, 'toggleSection'])->name('pages.sections.toggle');
        Route::post('/pages/{page}/duplicate', [AdminPageController::class, 'duplicate'])->name('pages.duplicate');
        Route::resource('pages', AdminPageController::class);

        // Restaurant Management
        Route::get('/restaurant/info', [AdminRestaurantController::class, 'index'])->name('restaurant.info');
        Route::post('/restaurant/info', [AdminRestaurantController::class, 'update'])->name('restaurant.update');
        Route::post('/restaurant/info/update', [AdminRestaurantController::class, 'update'])->name('restaurant.info.update');
        Route::get('/opening-hours', [AdminOpeningHourController::class, 'index'])->name('opening-hours.index');
        Route::post('/opening-hours', [AdminOpeningHourController::class, 'update'])->name('opening-hours.update');

        // Culinary Menu Management
        Route::resource('categories', AdminCategoryController::class);
        Route::resource('subcategories', AdminSubcategoryController::class);
        Route::post('/menu-items/{menuItem}/toggle-available', [AdminMenuItemController::class, 'toggleAvailable'])->name('menu-items.toggle-available');
        Route::post('/menu-items/{menuItem}/toggle-featured', [AdminMenuItemController::class, 'toggleFeatured'])->name('menu-items.toggle-featured');
        Route::resource('menu-items', AdminMenuItemController::class);

        // Media Library & Picker API
        Route::get('/media/api/list', [AdminMediaController::class, 'apiList'])->name('media.api');
        Route::get('/media/api/list-alt', [AdminMediaController::class, 'apiList'])->name('media.api.list');
        Route::post('/media/api/upload', [AdminMediaController::class, 'apiUpload'])->name('media.upload.api');
        Route::post('/media/api/upload-alt', [AdminMediaController::class, 'apiUpload'])->name('media.api.upload');
        Route::resource('media', AdminMediaController::class)->only(['index', 'store', 'destroy']);

        // Promotions & Offers
        Route::resource('offers', AdminOfferController::class);

        // Galleries
        Route::get('/galleries/{gallery}/items', [AdminGalleryController::class, 'items'])->name('galleries.items');
        Route::post('/galleries/{gallery}/items', [AdminGalleryController::class, 'addItem'])->name('galleries.items.add');
        Route::delete('/galleries/{gallery}/items/{item}', [AdminGalleryController::class, 'deleteItem'])->name('galleries.items.delete');
        Route::resource('galleries', AdminGalleryController::class);

        // Testimonials & FAQs
        Route::resource('testimonials', AdminTestimonialController::class);
        Route::resource('faqs', AdminFaqController::class);

        // Guest Inquiries, Table Bookings & Franchise Leads
        Route::get('/inquiries/bookings', [AdminMessageController::class, 'bookings'])->name('inquiries.bookings');
        Route::get('/inquiries/franchise', [AdminMessageController::class, 'franchise'])->name('inquiries.franchise');
        Route::get('/inquiries/contact', [AdminMessageController::class, 'contact'])->name('inquiries.contact');
        Route::post('/messages/{message}/status', [AdminMessageController::class, 'updateStatus'])->name('messages.status');
        Route::get('/messages', [AdminMessageController::class, 'index'])->name('messages.index');
        Route::get('/messages/{message}', [AdminMessageController::class, 'show'])->name('messages.show');
        Route::post('/messages/{message}/toggle-read', [AdminMessageController::class, 'toggleRead'])->name('messages.toggle-read');
        Route::post('/messages/{message}/notes', [AdminMessageController::class, 'updateNotes'])->name('messages.notes');
        Route::delete('/messages/{message}', [AdminMessageController::class, 'destroy'])->name('messages.destroy');

        // Navigation Menus
        Route::resource('navigation', AdminNavigationController::class)->only(['index', 'store', 'update', 'destroy']);

        // URL Redirects
        Route::resource('redirects', AdminRedirectController::class)->only(['index', 'store', 'update', 'destroy']);

        // SEO Defaults
        Route::get('/seo', [AdminSeoController::class, 'index'])->name('seo.index');
        Route::post('/seo', [AdminSeoController::class, 'updateDefaults'])->name('seo.update');

        // Global Settings
        Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [AdminSettingController::class, 'update'])->name('settings.update');

        // Users & Roles
        Route::resource('users', AdminUserController::class);

        // Audit & Activity Logs
        Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
    });
});

/*
|--------------------------------------------------------------------------
| Public Website Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

// Culinary Menu
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/menu/{categorySlug}', [MenuController::class, 'category'])->name('menu.category');
Route::get('/menu/{categorySlug}/sub/{subcategorySlug}', [MenuController::class, 'subcategory'])->name('menu.subcategory');
Route::get('/menu/{categorySlug}/{itemSlug}', [MenuController::class, 'item'])->name('menu.item');
Route::get('/menu/{categorySlug}/{subcategorySlug}/{itemSlug}', [MenuController::class, 'item'])->name('menu.subitem');

// Offers & Specials
Route::get('/offers', function () {
    return app(PageController::class)->show('offers');
})->name('offers');

// Contact & Reservations
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Page Preview (Authenticated staff only)
Route::get('/preview/page/{id}', [PageController::class, 'preview'])->name('page.preview');
Route::get('/preview/pages/{id}', [PageController::class, 'preview'])->name('pages.preview');

// Dedicated Brand Concept Sub-Pages
Route::get('/brands/{brandSlug}', [PageController::class, 'brandSubpage'])->where('brandSlug', '^[a-z0-9-]+$')->name('brands.subpage');

// CMS Dynamic Page Wildcard Catch-all (Must be last)
Route::get('/{slug}', [PageController::class, 'show'])->where('slug', '^[a-z0-9-]+$')->name('page.show');
