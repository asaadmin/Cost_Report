<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FileUpload;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [FileUpload::class, 'index']);

Route::post('/fileupload', [FileUpload::class, 'save'])->name("fileUpload");
Route::get('/export', [FileUpload::class, 'export'])->name("export");
Route::get('/reset', [FileUpload::class, 'reset'])->name("reset");
Route::get('/api/tabledata', [FileUpload::class, 'tabledata'])->name("tabledata");


Route::get('/tabletest', function () {
    return view('pages.tabulator');
});

Route::get('/upload', function () {
    return view('welcome');
});
