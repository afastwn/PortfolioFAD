<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MhsProfileController;
use App\Http\Controllers\ProfilDosenController;

// =======================
// Public (tanpa login)
// =======================
Route::view('/login', 'login')->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

Route::view('/aboutUS', 'aboutUS')->name('about');
Route::view('/showGalery', 'showGalery')->name('showGalery');

// (opsional) root → arahkan ke login / dashboard bila sudah login
Route::get('/', function () {
    if (auth()->check()) {
        return match (auth()->user()->role) {
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
    // ---------- Mahasiswa ----------
    Route::middleware(['role:mahasiswa'])->prefix('mhs')->name('mhs.')->group(function () {
        Route::view('/dashboard', 'mhs.homeMhs')->name('dashboard');           // mhs.dashboard
        Route::view('/home', 'mhs.homeMhs')->name('home');                     // mhs.home (alias kalau perlu)
        Route::view('/my-works', 'mhs.myWorksMhs')->name('myworks');           // mhs.myworks
        Route::view('/add-project', 'mhs.addProjectMhs')->name('add');         // mhs.add
        Route::get('/edit-project/{id}', function ($id) {
            if ($id == 1) {
                $project = (object)[
                    'title'          => 'Ergo Chair V1',
                    'category'       => 'Office Furniture and Office Chairs',
                    'course'         => 'Course 2',
                    'client'         => 'Client A',
                    'project_date'   => '2025-08-10',
                    'design_brief'   => 'Desain kursi versi awal.',
                    'design_process' => 'Sketsa awal dan prototype sederhana.',
                    'spec_material'  => 'Kayu solid + busa',
                    'spec_size'      => '60 x 60 x 90 cm',
                    'final_product_urls'  => [asset('/G1.png')],
                    'design_process_urls' => [asset('/G1.png')],
                    'testing_photo_urls'  => [asset('/G1.png')],
                    'display_photo_urls'  => [asset('/G1.png')],
                    'poster_urls'         => [asset('/G1.png')],
                    'video_urls'          => [],
                ];
            } elseif ($id == 2) {
                $project = (object)[
                    'title'          => 'Ergo Chair V2',
                    'category'       => 'Office Furniture and Office Chairs',
                    'course'         => 'Course 4',
                    'client'         => 'PT Maju Jaya',
                    'project_date'   => '2025-08-20',
                    'design_brief'   => 'Kursi ergonomis untuk kerja jarak jauh.',
                    'design_process' => 'Riset postur, sketsa ide, prototyping busa, uji coba.',
                    'spec_material'  => 'Frame baja, dudukan mesh, armrest PU',
                    'spec_size'      => 'W60 x D60 x H95-110 cm',
                    'final_product_urls'  => [asset('/G2.png')],
                    'design_process_urls' => [asset('/G2.png')],
                    'testing_photo_urls'  => [asset('/G2.png')],
                    'display_photo_urls'  => [asset('/G2.png')],
                    'poster_urls'         => [asset('/G2.png')],
                    'video_urls'          => [],
                ];
            } else {
                abort(404);
            }
            return view('mhs.addProjectMhs', ['mode' => 'edit', 'project' => $project]);
        })->name('edit')->where('id', '[0-9]+');

        Route::view('/all-works', 'mhs.allWorksMhs')->name('allworks');        // mhs.allworks
        Route::get('/profile', [MhsProfileController::class, 'show'])->name('profile');           // mhs.profile
        Route::post('/profile/save',       [MhsProfileController::class, 'saveProfile'])->name('profile.save');
        Route::post('/profile/activities', [MhsProfileController::class, 'saveActivities'])->name('profile.activities');
        Route::post('/profile/skills',     [MhsProfileController::class, 'saveSkills'])->name('profile.skills');
        Route::post('/profile/school',     [MhsProfileController::class, 'saveSchool'])->name('profile.school');
        Route::view('/gallery', 'showGalery')->name('gallery');                // mhs.gallery
    });

    // ---------- Dosen ----------
    Route::middleware(['role:dosen'])->prefix('dosen')->name('dosen.')->group(function () {
        Route::view('/dashboard', 'dosen.dashboardDsn')->name('dashboard');    // dosen.dashboard
        Route::view('/v-portfolio', 'dosen.vPortfolio')->name('vportfolio');   // dosen.vportfolio
        Route::get('/profile', [ProfilDosenController::class, 'show'])->name('profile.show');
        Route::post('/profile', [ProfilDosenController::class, 'update'])->name('profile.update');
        Route::view('/student-profiling', 'dosen.studentProfiling')->name('studentProfiling'); // dosen.studentProfiling

        Route::get('/student-profiling/{id}', function ($id) {
            $rows = [
                ['id'=>'20462','name'=>'Matt Dickerson','cat'=>'Lighting Systems'],
                ['id'=>'18933','name'=>'Wiktoria','cat'=>'Sports Equipment'],
                ['id'=>'45169','name'=>'Trixie Byrd','cat'=>'Vehicle Accessories'],
                ['id'=>'73003','name'=>'Jun Redfern','cat'=>'Watercraft'],
                ['id'=>'58825','name'=>'Miriam Kidd','cat'=>'Robotics'],
                ['id'=>'44122','name'=>'Dominic','cat'=>'Office Supplies and Stationery'],
                ['id'=>'89094','name'=>'Shanice','cat'=>'Computer and Information Technology'],
                ['id'=>'85252','name'=>'Poppy-Rose','cat'=>'Gaming and Streaming'],
                ['id'=>'99001','name'=>'Aria','cat'=>'Gaming and Streaming'],
                ['id'=>'99002','name'=>'Liam','cat'=>'Watches'],
                ['id'=>'99003','name'=>'Noah','cat'=>'Sports Equipment'],
            ];

            $base = collect($rows)->firstWhere('id', $id);
            abort_if(!$base, 404);

            $detail = ['phone'=>'-', 'address'=>'-', 'email'=>'-'];
            $portfolio = [
                ['title'=>'Project 1','course'=>'Course Name','semester'=>'Semester 1','img'=>'/G1.png'],
                ['title'=>'Project 2','course'=>'Course Name','semester'=>'Semester 2','img'=>'/G2.png'],
            ];

            $mhs = (object)[
                'id'   => $base['id'],
                'name' => $base['name'],
                'cat'  => $base['cat'],
                'phone'=> $detail['phone'],
                'address'=>$detail['address'],
                'email'=> $detail['email'],
                'portfolio'=>$portfolio,
            ];

            return view('dosen.showProfile', compact('mhs'));
        })->name('showProfile')->where('id', '[0-9]+');
    });
});
