<?php

use Illuminate\Support\Facades\Route;


// Route::get('/', function () {return view('welcome');});
Route::get('/login', function () {return view('login');});
Route::get('/aboutUS', function () {return view('aboutUS');});

//MAHASISWA//
Route::get('/homeMhs', function () {return view('mhs.homeMhs');});
Route::get('/myWorksMhs', function () {return view('mhs.myWorksMhs');});
Route::get('/addProjectMhs', function () {return view('mhs.addProjectMhs');});
Route::get('/editProjectMhs/{id}', function ($id) {
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

            // MEDIA beda → project 1 pakai G1
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

            // MEDIA beda → project 2 pakai G2
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
});

Route::get('/allWorksMhs', function () {return view('mhs.allWorksMhs');});
Route::get('/profileMhs', function () {return view('mhs.profileMhs');});
Route::get('/showGalery', function () {return view('showGalery');});

//DOSEN
Route::get('/vPortfolio', function () {return view('dosen.vPortfolio');});
Route::get('/profileDsn', function () {return view('dosen.profileDsn');});
Route::get('/studentProfiling', function () {return view('dosen.studentProfiling');});
Route::get('/dashboardDsn', function () {return view('dosen.dashboardDsn');});
Route::get('/studentProfiling/{id}', function ($id) {
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
        'cat'  => $base['cat'],   // <— penting
        'phone'=> $detail['phone'],
        'address'=>$detail['address'],
        'email'=> $detail['email'],
        'portfolio'=>$portfolio,
    ];

    return view('dosen.showProfile', compact('mhs'));
})->name('showProfile')->where('id', '[0-9]+');

