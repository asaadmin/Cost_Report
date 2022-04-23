<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FileUpload;
use App\Http\Controllers\EditedFile;
use App\Http\Controllers\FormatExcel;

use App\Http\Controllers\Admin\ViewSession;

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


Route::get('/', [FileUpload::class, 'index'])->name('home');

Route::post('/fileupload', [FileUpload::class, 'saveFile'])->name("saveFile");
Route::get('/editdata', [EditedFile::class, 'index'])->name("editdata");
Route::get('/tableView', [FileUpload::class, 'tableView'])->name("tableView");

Route::get('/reupload', [FileUpload::class, 'reset'])->name("reupload");
Route::get('/api/tabledata', [FileUpload::class, 'tabledata'])->name("tabledata");
Route::get('/api/cleartables', [FileUpload::class, 'truncate'])->name("cleartables");

Route::get('/save', [EditedFile::class, 'save'])->name("save");
Route::put('/updaterow', [EditedFile::class, 'updateCostRow'])->name("updaterow");
Route::get('/template', [EditedFile::class, 'templateFile'])->name("template");

// report formated excel
Route::get('/report', [FormatExcel::class, 'index'])->name("report");


Route::get('/sessions', [ViewSession::class, 'index'])->name("sessions");






