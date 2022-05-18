<?php

use App\Http\Controllers\ContactsController;
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

Route::get('/', function () {
    return view('contatos.index');
});

Route::resource('contacts', ContactsController::class);
Route::post('/contacts/search', [ContactsController::class, 'search'])->name('contacts.search');
Route::post('/contacts/add_phone', [ContactsController::class, 'add_phone'])->name('contacts.add_phone');
Route::post('/contacts/add_email', [ContactsController::class, 'add_email'])->name('contacts.add_email');
Route::post('/contacts/delete_phone', [ContactsController::class, 'delete_phone'])->name('contacts.delete_phone');
Route::post('/contacts/delete_email', [ContactsController::class, 'delete_email'])->name('contacts.delete_email');