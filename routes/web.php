<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\KknGroupController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\VillageProfileController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\TourismController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ImpactController;
use App\Http\Controllers\HandoverController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AiAssistantController;
use App\Http\Controllers\PublicVillageController;

/*
|--------------------------------------------------------------------------
| Public Marketing Landing Page
|--------------------------------------------------------------------------
*/
Route::get('/', [LandingController::class, 'index'])->name('landing');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated Dashboard & Workspaces
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // AI Assistant Drafting Endpoint
    Route::post('/ai/draft', [AiAssistantController::class, 'draft'])->name('ai.draft');

    // Campus Admin Workspace
    Route::prefix('campus')->name('campus.')->middleware('role:SUPER_ADMIN,CAMPUS_ADMIN')->group(function () {
        Route::get('/dashboard', [CampusController::class, 'dashboard'])->name('dashboard');
        Route::post('/programs', [CampusController::class, 'storeProgram'])->name('programs.store');
        Route::post('/villages', [CampusController::class, 'storeVillage'])->name('villages.store');
        Route::post('/groups', [CampusController::class, 'storeGroup'])->name('groups.store');
        Route::post('/groups/{group}/assign', [CampusController::class, 'assignStudent'])->name('groups.assign');
    });

    // Supervisor Workspace
    Route::prefix('supervisor')->name('supervisor.')->middleware('role:SUPER_ADMIN,SUPERVISOR')->group(function () {
        Route::get('/dashboard', [SupervisorController::class, 'dashboard'])->name('dashboard');
        Route::post('/review', [SupervisorController::class, 'review'])->name('review');
    });

    // KKN Group Workspace
    Route::prefix('workspace/group/{group}')->name('group.')->group(function () {
        Route::get('/', [KknGroupController::class, 'workspace'])->name('workspace');
        Route::get('/members', [KknGroupController::class, 'members'])->name('members');
        Route::post('/members', [KknGroupController::class, 'storeMember'])->name('members.store');
        Route::put('/members/{member}', [KknGroupController::class, 'updateMember'])->name('members.update');
        Route::delete('/members/{member}', [KknGroupController::class, 'destroyMember'])->name('members.destroy');
        Route::get('/activity', [KknGroupController::class, 'activity'])->name('activity');

        // Programs & Tasks (Kanban)
        Route::get('/programs', [ProgramController::class, 'index'])->name('programs.index');
        Route::post('/programs', [ProgramController::class, 'store'])->name('programs.store');
        Route::get('/programs/{program}', [ProgramController::class, 'show'])->name('programs.show');
        Route::post('/programs/{program}/status', [ProgramController::class, 'updateStatus'])->name('programs.status');
        Route::post('/programs/{program}/tasks', [ProgramController::class, 'storeTask'])->name('programs.tasks.store');
        Route::post('/programs/{program}/tasks/{task}/status', [ProgramController::class, 'updateTaskStatus'])->name('programs.tasks.status');

        // Documents Repository
        Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
        Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
        Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');

        // Impact Dashboard
        Route::get('/impact', [ImpactController::class, 'index'])->name('impact.index');
        Route::post('/impact', [ImpactController::class, 'store'])->name('impact.store');
        Route::put('/impact/{metric}', [ImpactController::class, 'update'])->name('impact.update');
        Route::delete('/impact/{metric}', [ImpactController::class, 'destroy'])->name('impact.destroy');

        // Handover Engine
        Route::get('/handover', [HandoverController::class, 'index'])->name('handover.index');
        Route::post('/handover/execute', [HandoverController::class, 'execute'])->name('handover.execute');
        Route::get('/handover/{package}/certificate', [HandoverController::class, 'certificate'])->name('handover.certificate');

        // Report Generator
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/kkn-summary', [ReportController::class, 'kknSummary'])->name('reports.kkn_summary');
        Route::get('/reports/village-profile', [ReportController::class, 'villageProfile'])->name('reports.village_profile');
        Route::get('/reports/impact', [ReportController::class, 'impactReport'])->name('reports.impact');
    });

    // Village Content & Digital Asset Management
    Route::prefix('workspace/village/{village}')->name('village.')->group(function () {
        Route::get('/', [VillageProfileController::class, 'dashboard'])->name('workspace');
        Route::get('/dashboard', [VillageProfileController::class, 'dashboard'])->name('dashboard');
        Route::get('/delegation', [VillageProfileController::class, 'delegation'])->name('delegation');
        Route::get('/profile', [VillageProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile', [VillageProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/submit', [VillageProfileController::class, 'submitReview'])->name('profile.submit');
        Route::post('/facilities', [VillageProfileController::class, 'storeFacility'])->name('facilities.store');
        Route::delete('/facilities/{facility}', [VillageProfileController::class, 'destroyFacility'])->name('facilities.destroy');

        // UMKM Directory
        Route::get('/umkm', [UmkmController::class, 'index'])->name('umkm.index');
        Route::get('/umkm/create', [UmkmController::class, 'create'])->name('umkm.create');
        Route::post('/umkm', [UmkmController::class, 'store'])->name('umkm.store');
        Route::get('/umkm/{umkm}/edit', [UmkmController::class, 'edit'])->name('umkm.edit');
        Route::post('/umkm/{umkm}/update', [UmkmController::class, 'update'])->name('umkm.update');
        Route::post('/umkm/{umkm}/submit', [UmkmController::class, 'submitReview'])->name('umkm.submit');
        Route::delete('/umkm/{umkm}', [UmkmController::class, 'destroy'])->name('umkm.destroy');
        Route::post('/umkm/{umkm}/products', [UmkmController::class, 'storeProduct'])->name('umkm.products.store');
        Route::delete('/umkm/{umkm}/products/{product}', [UmkmController::class, 'destroyProduct'])->name('umkm.products.destroy');

        // Tourism
        Route::get('/tourism', [TourismController::class, 'index'])->name('tourism.index');
        Route::get('/tourism/create', [TourismController::class, 'create'])->name('tourism.create');
        Route::post('/tourism', [TourismController::class, 'store'])->name('tourism.store');
        Route::get('/tourism/{tourism}/edit', [TourismController::class, 'edit'])->name('tourism.edit');
        Route::post('/tourism/{tourism}/update', [TourismController::class, 'update'])->name('tourism.update');
        Route::post('/tourism/{tourism}/submit', [TourismController::class, 'submitReview'])->name('tourism.submit');
        Route::delete('/tourism/{tourism}', [TourismController::class, 'destroy'])->name('tourism.destroy');

        // Map
        Route::get('/map', [MapController::class, 'index'])->name('map.index');
        Route::post('/map', [MapController::class, 'store'])->name('map.store');
        Route::delete('/map/{location}', [MapController::class, 'destroy'])->name('map.destroy');

        // Events
        Route::get('/events', [EventController::class, 'index'])->name('events.index');
        Route::post('/events', [EventController::class, 'store'])->name('events.store');
        Route::post('/events/{event}/submit', [EventController::class, 'submitReview'])->name('events.submit');
        Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

        // Articles / News
        Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
        Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
        Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
        Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
        Route::post('/articles/{article}/update', [ArticleController::class, 'update'])->name('articles.update');
        Route::post('/articles/{article}/submit', [ArticleController::class, 'submitReview'])->name('articles.submit');
        Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');

        // Gallery
        Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
        Route::post('/gallery/albums', [GalleryController::class, 'storeAlbum'])->name('gallery.albums.store');
        Route::post('/gallery/albums/{album}/media', [GalleryController::class, 'storeMedia'])->name('gallery.media.store');
        Route::delete('/gallery/albums/{album}/media/{media}', [GalleryController::class, 'destroyMedia'])->name('gallery.media.destroy');
    });
});

/*
|--------------------------------------------------------------------------
| Public Village Website Routes
|--------------------------------------------------------------------------
| Accessible by public unauthenticated visitors, mobile-friendly, SEO ready
*/
Route::prefix('desa/{slug}')->name('public.village.')->group(function () {
    Route::get('/', [PublicVillageController::class, 'home'])->name('home');
    Route::get('/tentang', [PublicVillageController::class, 'about'])->name('about');
    Route::get('/umkm', [PublicVillageController::class, 'umkm'])->name('umkm');
    Route::get('/umkm/{umkmSlug}', [PublicVillageController::class, 'showUmkm'])->name('umkm.show');
    Route::get('/wisata', [PublicVillageController::class, 'tourism'])->name('tourism');
    Route::get('/peta', [PublicVillageController::class, 'map'])->name('map');
    Route::get('/kegiatan', [PublicVillageController::class, 'events'])->name('events');
    Route::get('/agenda', [PublicVillageController::class, 'events'])->name('agenda');
    Route::get('/berita', [PublicVillageController::class, 'news'])->name('news');
    Route::get('/warta', [PublicVillageController::class, 'news'])->name('warta');
    Route::get('/berita/{articleSlug}', [PublicVillageController::class, 'showNews'])->name('news.show');
    Route::get('/warta/{articleSlug}', [PublicVillageController::class, 'showNews'])->name('warta.show');
    Route::get('/galeri', [PublicVillageController::class, 'gallery'])->name('gallery');
    Route::get('/kkn', [PublicVillageController::class, 'kkn'])->name('kkn');
    Route::get('/impact', [PublicVillageController::class, 'impact'])->name('impact');
    Route::get('/dampak', [PublicVillageController::class, 'impact'])->name('dampak');
    Route::get('/handover', [PublicVillageController::class, 'handover'])->name('handover');
    Route::get('/kontak', [PublicVillageController::class, 'contact'])->name('contact');
});
