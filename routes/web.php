<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {return view('welcome');});
Route::get('/utama', function () {return view('utama');});
Route::get('/homeMhs', function () {return view('homeMhs');});
Route::get('/myWorksMhs', function () {return view('myWorksMhs');});
Route::get('/addProjectMhs', function () {return view('addProjectMhs');});
Route::get('/allWorksMhs', function () {return view('allWorksMhs');});
Route::get('/profileMhs', function () {return view('profileMhs');});