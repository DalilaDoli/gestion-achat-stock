<?php

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



Auth::routes();

Route::middleware(['auth'])->group(function () {

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', function () {
    return view('admin_layout');
});
Route::get('/home',function () {
    return view('admin_layout');
});
//Referentiels
Route::resource('/client','App\Http\Controllers\Referentiel\ClientController');
Route::resource('/fournisseur','App\Http\Controllers\Referentiel\FournisseurController');
Route::resource('/famillearticle','App\Http\Controllers\Referentiel\FamilleArticleController');
Route::resource('/emplacement','App\Http\Controllers\Referentiel\EmplacementController');
Route::resource('/personnel','App\Http\Controllers\Referentiel\PersonnelController');
Route::resource('/article','App\Http\Controllers\Referentiel\ArticleController');
Route::resource('/utilisateur','App\Http\Controllers\Referentiel\UtilisateurController');


// Gestion achat
Route::resource('/da','App\Http\Controllers\GestionAchat\DaController');
Route::post('/modifierachat', 'App\Http\Controllers\GestionAchat\DaController@Modification')->name('ModificationDa');
Route::post('/suppachat', 'App\Http\Controllers\GestionAchat\DaController@AnnulationDa')->name('AnnulationDa');
Route::get('/validationachat', 'App\Http\Controllers\GestionAchat\DaController@indexValidationDa');
Route::post('/validationachat', 'App\Http\Controllers\GestionAchat\DaController@ValidationDa')->name('ValidationDa');
Route::get('/printda/{id}','App\Http\Controllers\GestionAchat\DaController@Print')->name('printda');

Route::resource('/commande','App\Http\Controllers\GestionAchat\CommandeController');
Route::post('/modifiercommande', 'App\Http\Controllers\GestionAchat\CommandeController@Modification')->name('ModificationCmd');
Route::post('/suppcommande', 'App\Http\Controllers\GestionAchat\CommandeController@AnnulationCmd')->name('AnnulationCmd');


Route::get('/validationcommande', 'App\Http\Controllers\GestionAchat\CommandeController@indexValidationCmd');
Route::post('/validationcommande', 'App\Http\Controllers\GestionAchat\CommandeController@ValidationCmd')->name('ValidationCmd');
Route::get('/printcmd/{id}','App\Http\Controllers\GestionAchat\CommandeController@Print')->name('printcmd');


//Gestion Stock
Route::resource('/reception', 'App\Http\Controllers\GestionStock\ReceptionController');
Route::post('/modifierreception', 'App\Http\Controllers\GestionStock\ReceptionController@Modification')->name('ModificationReception');
Route::post('/suppreception', 'App\Http\Controllers\GestionStock\ReceptionController@AnnulationReception')->name('AnnulationReception');
});
