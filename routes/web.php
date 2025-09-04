<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {return view('welcome');});
Route::get('/utama', function () {return view('utama');});
Route::get('/homeMhs', function () {return view('homeMhs');});
Route::get('/myWorksMhs', function () {return view('myWorksMhs');});
Route::get('/addProjectMhs', function () {return view('addProjectMhs');});
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

    return view('addProjectMhs', ['mode' => 'edit', 'project' => $project]);
});

Route::get('/allWorksMhs', function () {return view('allWorksMhs');});
Route::get('/profileMhs', function () {return view('profileMhs');});
Route::get('/showGalery', function () {return view('showGalery');});
Route::get('/aboutUS', function () {return view('aboutUS');});