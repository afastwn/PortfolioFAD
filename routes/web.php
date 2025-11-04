<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MhsProfileController;
use App\Http\Controllers\ProfilDosenController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MhsProjectController;
use App\Http\Controllers\StudentProfilingController;
use App\Http\Controllers\ProjectViewController;
use App\Http\Controllers\MhsHomeController;
use App\Http\Controllers\MhsAllWorksController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\DosenVPortfController;
use App\Http\Controllers\DosenDashboardController;
use App\Http\Controllers\ProjectInteractionController;
use App\Http\Controllers\LocationController;


// =======================
// Public (tanpa login)
// =======================
Route::get('/login', [LoginController::class, 'index'])->name('login'); 
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

Route::view('/aboutUS', 'aboutUS')->name('about');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
Route::post('/projects/{project}/like', [ProjectInteractionController::class, 'toggleLike'])
    ->name('projects.like');

Route::post('/projects/{project}/comments', [ProjectInteractionController::class, 'storeComments'])
    ->name('projects.comments');



// (opsional) root → arahkan ke login / dashboard bila sudah login
Route::get('/', function () {
    if (auth()->check()) {
        return match (auth()->user()->role) {
            'admin'     => redirect()->route('admin.addStudents'),
            'dosen'     => redirect()->route('dosen.dashboard'),
            'mahasiswa' => redirect()->route('mhs.dashboard'),
            default     => redirect()->route('login'),
        };
    }
    return redirect()->route('login');
})->name('root');

// =======================
// Protected (harus login)
// =======================
Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    // ---------- Admin ----------
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::view('/addStudents', 'admin.addStudents')->name('addStudents');
        Route::view('/addDosen', 'admin.addDosen')->name('addDosen');

        Route::post('/students', [AdminController::class, 'storeStudent'])->name('students.store');
        Route::post('/dosen', [AdminController::class, 'storeDosen'])->name('dosen.store');
        Route::delete('/user/{user}', [AdminController::class, 'destroyUser'])->name('user.destroy');


     });

    // ---------- Mahasiswa ----------
    Route::middleware(['role:mahasiswa'])->prefix('mhs')->name('mhs.')->group(function () {
       // dashboard/home
        Route::get('/dashboard', [MhsHomeController::class, 'index'])->name('dashboard');
        Route::get('/home', [MhsHomeController::class, 'index'])->name('home');

        // === MyWorks & Projects ===
        Route::get('/my-works',              [MhsProjectController::class, 'index'])->name('myworks');

        // create/store
        Route::get('/projects/create',       [MhsProjectController::class, 'create'])->name('projects.create');
        Route::post('/projects',             [MhsProjectController::class, 'store'])->name('projects.store');

        // show/edit/update/destroy (untuk ikon 👁️ & ✏️)
        Route::get('/projects/{project}',           [MhsProjectController::class, 'show'])->name('projects.show');
        Route::get('/projects/{project}/edit',      [MhsProjectController::class, 'edit'])->name('projects.edit');
        Route::put('/projects/{project}',           [MhsProjectController::class, 'update'])->name('projects.update');
        Route::delete('/projects/{project}',        [MhsProjectController::class, 'destroy'])->name('projects.destroy');

        // all works & profile
        Route::get('/all-works', [MhsAllWorksController::class, 'index'])->name('allworks');

        Route::get('/profile',                [MhsProfileController::class, 'show'])->name('profile');
        Route::post('/profile/save',          [MhsProfileController::class, 'saveProfile'])->name('profile.save');
        Route::post('/profile/activities',    [MhsProfileController::class, 'saveActivities'])->name('profile.activities');
        Route::post('/profile/skills',        [MhsProfileController::class, 'saveSkills'])->name('profile.skills');
        Route::post('/profile/school',        [MhsProfileController::class, 'saveSchool'])->name('profile.school');

        // Route::view('/gallery', 'showGalery')->name('gallery');
    });

    // ---------- Dosen ----------
    Route::middleware(['role:dosen,kaprodi'])->prefix('dosen')->name('dosen.')->group(function () {
        Route::get('/dashboard', [DosenDashboardController::class, 'index'])->name('dashboard');
        Route::get('/v-portfolio', [DosenVPortfController::class, 'index'])->name('vportfolio');
        Route::get('/profile', [ProfilDosenController::class, 'show'])->name('profile.show');
        Route::post('/profile', [ProfilDosenController::class, 'update'])->name('profile.update');
        // ⬇⬇ GANTI INI: dari Route::view ke Controller index (server-side)
        Route::get('/student-profiling', [StudentProfilingController::class, 'index'])
        ->name('studentProfiling');

    // ⬇⬇ GANTI INI: dari closure dummy ke Controller show (User binding)
        Route::get('/student-profiling/{user}', [StudentProfilingController::class, 'show'])
        ->whereNumber('user')
        ->name('showProfile');
        // ✅ HANYA KAPRODI yang boleh export (URL tetap di bawah /dosen/)
        Route::get('/student-profiling-export', [StudentProfilingController::class, 'export'])
        ->middleware('role:kaprodi')
        ->name('studentProfiling.export');


        Route::get('/projects/{project}', [ProjectViewController::class, 'show'])
        ->whereNumber('project')
        ->name('projects.view');
    });

    Route::prefix('loc')->group(function(){
        Route::get('/provinces', [LocationController::class,'provinces'])->name('loc.provinces');
        Route::get('/regencies', [LocationController::class,'regenciesByProvince'])->name('loc.regencies');
        Route::get('/cities',    [LocationController::class,'citiesByProvince'])->name('loc.cities');
    });
});
