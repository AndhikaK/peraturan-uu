<?php

use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\DraftController;
use App\Http\Controllers\IndexController;
use App\Models\Archive;
use Illuminate\Support\Facades\Route;

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


Route::get('/', [IndexController::class, 'index'])->name('index');

Route::resources([
    'archive' => ArchiveController::class,
    'draft' => DraftController::class,
]);

// ROUTE FOR DATATABLES DATA
Route::get('archive_data', [ArchiveController::class, 'getData'])->name('archive.data');
Route::get('draft_data', [DraftController::class, 'hitungCousine'])->name('draft.data');

Route::get('archive_file_create', [ArchiveController::class, 'createFile'])->name('archive-file.create');

Route::post('archive_file_store', [ArchiveController::class, 'fileStore'])->name('archive-file.store');

require __DIR__ . '/auth.php';
