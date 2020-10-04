<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
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


Auth::routes(['verify'=>true]);

Route::get('/', function () {
    return view('auth/login');
});

Route::get('/register', function() {
    return view('auth/register');
})->name('register');

Route::get('/password/reset', function() {
    return redirect('/login');    
});

Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('logout', function () {
    Auth::logout();
    return redirect('/');
});

Route::post('philippines-address/regions', 'AddressController@regions')->name('address.regions');
Route::post('philippines-address/provinces', 'AddressController@provinces')->name('address.provinces');
Route::post('philippines-address/city-municipality', 'AddressController@cityMunicipalities')->name('address.city-municipalities');
Route::post('philippines-address/barangays', 'AddressController@barangays')->name('address.barangays');

Route::group(['middleware' => ['auth']] , function() {
	Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/account', 'HomeController@account')->name('account');
});


Route::group(['prefix' => 'lgu', 'as' => 'lgu.', 'middleware' => ['App\Http\Middleware\UserLgu','auth']], function(){

    $parentDir = 'Lgu';

    Route::get('/home', $parentDir.'\HomeController@index')->name('home');



    Route::get('/residents', $parentDir.'\ResidentController@index')->name('residents');
    Route::get('/residents/list', $parentDir.'\ResidentController@list')->name('resident.list');
    Route::get('/residents/{poi}/establishment/log', $parentDir.'\ResidentController@establishmentLog')->name('resident.establishment.log');
    Route::post('/residents/health/set', $parentDir.'\ResidentController@setHealthStatus')->name('resident.set.health.status');


});



Route::group(['prefix' => 'rs', 'as' => 'rs.', 'middleware' => ['App\Http\Middleware\UserResident','auth','verified']], function(){

    $parentDir = 'Resident';

    Route::get('/home', $parentDir.'\HomeController@index')->name('home');

    // daily checklist
    Route::post('/home/health-checklist/store', $parentDir.'\HomeController@dailyChecklistStore')->name('health.check.list.store');

    // hci 
    Route::post('/home/health-care-institution/set', $parentDir.'\HomeController@healthCareInstitution')->name('hci.update');
});



Route::group(['prefix' => 'hci', 'as' => 'hci.', 'middleware' => ['App\Http\Middleware\UserHci','auth']], function(){

    $parentDir = 'Hci';

    Route::get('/home', $parentDir.'\HomeController@index')->name('home');



    Route::get('/patient', $parentDir.'\PatientController@index')->name('patient');
    Route::get('/patient/list', $parentDir.'\PatientController@list')->name('patient.list');
    Route::post('/patient/add', $parentDir.'\PatientController@add')->name('patient.add');
    Route::post('/patient/store', $parentDir.'\PatientController@store')->name('patient.store');
    Route::get('/patient/{poi_id}', $parentDir.'\PatientController@single')->name('patient.single');
    
    Route::post('/patient/health/set', $parentDir.'\PatientController@setHealthStatus')->name('patient.set.health.status');
    
    Route::get('/patient/{poi_id}/health-test/list', $parentDir.'\PatientHealthTestController@list')->name('patient.health.test.list');
    Route::post('/patient/{poi_id}/health-test/store', $parentDir.'\PatientHealthTestController@store')->name('patient.health.test.store');

    Route::get('/patient/{poi_id}/health-test/{test_id}/diary', $parentDir.'\PatientHealthTestDiaryController@index')->name('patient.health.test.diary');
    Route::get('/patient/{poi_id}/health-test/{test_id}/diary/list', $parentDir.'\PatientHealthTestDiaryController@list')->name('patient.health.test.diary.list');
    Route::post('/patient/{poi_id}/health-test/{test_id}/diary/store', $parentDir.'\PatientHealthTestDiaryController@store')->name('patient.health.test.diary.store');

    Route::get('/patient/{id}/health/test/list', $parentDir.'\PatientController@list')->name('patient.single.test.diary.list');
});