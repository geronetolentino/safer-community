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

// Route::get('/', function () {
//     return view('welcome');
// });



Route::get('/', function () {
    return view('auth/login');
});

Route::get('privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy-policy');

Auth::routes(['verify'=>true]);

Route::get('/register', function() {
    return view('auth/register');
})->name('register');

Route::get('/register/visitor', function() {
    $data = \App\Models\Purposes::all();
    return view('auth.visitor-register')->with(['data'=>$data]);
})->name('register.visitor');

Route::post('/register/visitor/purposes', 'Auth\VisitorRegisterController@purposes')->name('register.visitor.purposes');

Route::post('/register/visitor', 'Auth\VisitorRegisterController@register')->name('register.visitor');

Route::get('/password/reset', function() {
    return redirect('/login');    
});

Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('logout', function () {
    Auth::logout();
    return redirect('/');
});

// CRON
Route::get('establishment-auto-out', 'CronController@establishmentAutoOut');
Route::get('generate-qr-file', 'CronController@generateQrFile');
// CRON


// PHILIPPINE ADDRESS
Route::post('philippines-address/regions', 'AddressController@regions')->name('address.regions');
Route::post('philippines-address/provinces', 'AddressController@provinces')->name('address.provinces');
Route::post('philippines-address/city-municipality', 'AddressController@cityMunicipalities')->name('address.city-municipalities');
Route::post('philippines-address/barangays', 'AddressController@barangays')->name('address.barangays');
// PHILIPPINE ADDRESS


Route::group(['middleware' => ['auth']] , function() {
	Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/account', 'HomeController@account')->name('account');

    Route::get('profile/{filename}', 'ImageProcessorController@index')->name('image.process');
    Route::get('logo/{filename}', 'ImageProcessorController@establishment')->name('image.process.establishment');

    Route::get('/home/eep/{eep}', 'Resident\HomeController@enrollEmployee')->name('employee.enroll');
    Route::post('/home/eep/enroll', 'Resident\HomeController@enrollEmployeeConfirm')->name('employee.enroll.confirm');
});



Route::group(['prefix' => 'pa', 'as' => 'pa.', 'middleware' => ['App\Http\Middleware\ProvincialAdministrator','auth']], function(){

    $parentDir = 'ProvincialAdministrator';

    Route::get('/home', $parentDir.'\HomeController@index')->name('home');


    Route::get('/municipality', $parentDir.'\MunicipalityController@index')->name('municipality');
    Route::get('/municipality/list', $parentDir.'\MunicipalityController@list')->name('municipality.list');
    Route::get('/municipality/create', $parentDir.'\MunicipalityController@create')->name('municipality.create');
    Route::post('/municipality/store', $parentDir.'\MunicipalityController@store')->name('municipality.store');
    Route::get('/municipality/{id}', $parentDir.'\MunicipalityController@view')->name('municipality.view');
    Route::post('/municipality/account/generate', $parentDir.'\MunicipalityController@account')->name('municipality.account');


    Route::get('/hospital', $parentDir.'\HospitalController@index')->name('hospital');
    Route::get('/hospital/list', $parentDir.'\HospitalController@list')->name('hospital.list');
    Route::get('/hospital/create', $parentDir.'\HospitalController@create')->name('hospital.create');
    Route::post('/hospital/store', $parentDir.'\HospitalController@store')->name('hospital.store');
    Route::get('/hospital/{id}', $parentDir.'\HospitalController@view')->name('hospital.view');
    Route::post('/hospital/account/generate', $parentDir.'\HospitalController@account')->name('hospital.account');



    Route::get('/establishment', $parentDir.'\EstablishmentController@index')->name('establishment');
    Route::get('/establishment/list', $parentDir.'\EstablishmentController@list')->name('establishment.list');
    Route::get('/establishment/create', $parentDir.'\EstablishmentController@create')->name('establishment.create');
    Route::post('/establishment/store', $parentDir.'\EstablishmentController@store')->name('establishment.store');
    Route::get('/establishment/{est_code}', $parentDir.'\EstablishmentController@single')->name('establishment.single');
    Route::get('/establishment/visitors/list/{est_code}', $parentDir.'\EstablishmentController@branchVisitor')->name('establishment.visitor.list');
    Route::get('/establishment/employee/list/{id}', $parentDir.'\EstablishmentController@branchEmployee')->name('establishment.employee.list');



    Route::get('/account', $parentDir.'\AccountController@index')->name('account');
    Route::get('/account/edit', $parentDir.'\AccountController@edit')->name('account.edit');
    Route::post('/account/save', $parentDir.'\AccountController@save')->name('account.save');
    Route::post('/account/photo', $parentDir.'\AccountController@photo')->name('account.photo');

});



Route::group(['prefix' => 'ma', 'as' => 'ma.', 'middleware' => ['App\Http\Middleware\MunicipalAdministrator','auth']], function(){

    $parentDir = 'MunicipalAdministrator';

    Route::get('/home', $parentDir.'\HomeController@index')->name('home');
    Route::get('/home/positive-list', $parentDir.'\HomeController@positiveList')->name('home.positiveList');
    Route::get('/home/pui-list', $parentDir.'\HomeController@puiList')->name('home.puiList');
    Route::get('/home/pum-list', $parentDir.'\HomeController@pumList')->name('home.pumList');

    Route::get('/barangay', $parentDir.'\BarangayController@index')->name('barangay');
    Route::get('/barangay/list', $parentDir.'\BarangayController@list')->name('barangay.list');
    Route::post('/barangay/store', $parentDir.'\BarangayController@store')->name('barangay.store');
    Route::get('/barangay/{id}', $parentDir.'\BarangayController@view')->name('barangay.view');
    Route::post('/barangay/account/generate', $parentDir.'\BarangayController@account')->name('barangay.account');



    Route::get('/residents', $parentDir.'\ResidentController@index')->name('residents');
    Route::get('/residents/list', $parentDir.'\ResidentController@list')->name('resident.list');
    Route::get('/residents/{poi}/establishment/log', $parentDir.'\ResidentController@establishmentLog')->name('resident.establishment.log');
    Route::post('/residents/health/set', $parentDir.'\ResidentController@setHealthStatus')->name('resident.set.health.status');



    Route::get('/establishment', $parentDir.'\EstablishmentController@index')->name('establishment');
    Route::get('/establishment/list', $parentDir.'\EstablishmentController@list')->name('establishment.list');
    Route::get('/establishment/create', $parentDir.'\EstablishmentController@create')->name('establishment.create');
    Route::post('/establishment/store', $parentDir.'\EstablishmentController@store')->name('establishment.store');
    Route::get('/establishment/{est_code}', $parentDir.'\EstablishmentController@single')->name('establishment.single');
    Route::get('/establishment/visitors/list/{est_code}', $parentDir.'\EstablishmentController@branchVisitor')->name('establishment.visitor.list');
    Route::get('/establishment/employee/list/{id}', $parentDir.'\EstablishmentController@branchEmployee')->name('establishment.employee.list');





    Route::get('/visitors', $parentDir.'\VisitorController@index')->name('visitors');
    Route::get('/visitors/list', $parentDir.'\VisitorController@list')->name('visitors.list');
    Route::get('/visitors/approve/{id}', $parentDir.'\VisitorController@approve')->name('visitor.approve');

    Route::get('/account', $parentDir.'\AccountController@index')->name('account');
    Route::get('/account/edit', $parentDir.'\AccountController@edit')->name('account.edit');
    Route::post('/account/save', $parentDir.'\AccountController@save')->name('account.save');
    Route::post('/account/photo', $parentDir.'\AccountController@photo')->name('account.photo');
});



Route::group(['prefix' => 'br', 'as' => 'br.', 'middleware' => ['App\Http\Middleware\BarangayAdministrator','auth','verified']], function(){

    $parentDir = 'BarangayAdministrator';

    Route::get('/home', $parentDir.'\HomeController@index')->name('home');
    Route::get('/home/positive-list', $parentDir.'\HomeController@positiveList')->name('home.positiveList');
    Route::get('/home/pui-list', $parentDir.'\HomeController@puiList')->name('home.puiList');
    Route::get('/home/pum-list', $parentDir.'\HomeController@pumList')->name('home.pumList');


    Route::get('/residents', $parentDir.'\ResidentController@index')->name('residents');
    Route::get('/residents/list', $parentDir.'\ResidentController@list')->name('resident.list');
    Route::get('/residents/documents', $parentDir.'\ResidentController@documents')->name('resident.documents');
    Route::post('/residents/health/set', $parentDir.'\ResidentController@setHealthStatus')->name('resident.set.health.status');



    Route::get('/establishment', $parentDir.'\EstablishmentController@index')->name('establishment');
    Route::get('/establishment/list', $parentDir.'\EstablishmentController@list')->name('establishment.list');
    Route::get('/establishment/create', $parentDir.'\EstablishmentController@create')->name('establishment.create');
    Route::post('/establishment/store', $parentDir.'\EstablishmentController@store')->name('establishment.store');
    Route::get('/establishment/{id}', $parentDir.'\EstablishmentController@view')->name('establishment.view');



    Route::get('/account', $parentDir.'\AccountController@index')->name('account');
    Route::get('/account/edit', $parentDir.'\AccountController@edit')->name('account.edit');
    Route::post('/account/save', $parentDir.'\AccountController@save')->name('account.save');
    Route::post('/account/photo', $parentDir.'\AccountController@photo')->name('account.photo');
});



Route::group(['prefix' => 'rs', 'as' => 'rs.', 'middleware' => ['App\Http\Middleware\Resident','auth','verified']], function(){

    $parentDir = 'Resident';

    Route::get('/home', $parentDir.'\HomeController@index')->name('home');



    Route::get('/visits', $parentDir.'\HomeController@visits')->name('visits');
    Route::get('/visit/register', $parentDir.'\VisitController@register')->name('register.visit');



    Route::get('/travel', $parentDir.'\TravelHistory@index')->name('travel');



    Route::get('/information-access-log', $parentDir.'\AccessLogController@index')->name('access.logs');



    Route::get('/scanner/{uid}', $parentDir.'\ScannerController@index')->name('scanner');
    Route::post('/scanner/register', $parentDir.'\ScannerController@register')->name('scanner.register');



    Route::get('/documents', $parentDir.'\DocumentController@index')->name('documents');
    Route::post('/documents/save', $parentDir.'\DocumentController@index')->name('document.save');



    Route::get('/account', $parentDir.'\AccountController@index')->name('account');
    Route::get('/account/edit', $parentDir.'\AccountController@edit')->name('account.edit');
    Route::post('/account/save', $parentDir.'\AccountController@save')->name('account.save');
    Route::post('/account/photo', $parentDir.'\AccountController@photo')->name('account.photo');
    Route::get('/qr-code', 'AccountController@generateQrFile');
});



// Hospital Route
Route::group(['prefix' => 'hp', 'as' => 'hp.', 'middleware' => ['App\Http\Middleware\Hospital','auth']], function(){

    $parentDir = 'Hospital';

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



    Route::get('/account', $parentDir.'\AccountController@index')->name('account');
    Route::get('/account/edit', $parentDir.'\AccountController@edit')->name('account.edit');
    Route::post('/account/save', $parentDir.'\AccountController@save')->name('account.save');
    Route::post('/account/photo', $parentDir.'\AccountController@photo')->name('account.photo');
});



Route::group(['prefix' => 'es', 'as' => 'es.', 'middleware' => ['App\Http\Middleware\Establishment','auth']], function(){

    $parentDir = 'Establishment';

    Route::get('/home', $parentDir.'\HomeController@index')->name('home');



    Route::get('/branch', $parentDir.'\BranchController@index')->name('branch');
    Route::get('/branch/list', $parentDir.'\BranchController@list')->name('branch.list');
    Route::get('/branch/create', $parentDir.'\BranchController@create')->name('branch.create');
    Route::post('/branch/store', $parentDir.'\BranchController@store')->name('branch.store');
    

    Route::get('/branch/{est_code}', $parentDir.'\BranchController@single')->name('branch.single');
    Route::get('/branch/{est_code}/poiList', $parentDir.'\BranchController@poiList')->name('branch.single.poiList');
    Route::get('/branch/{est_code}/visitor-log', $parentDir.'\Branch\VisitorController@index')->name('branch.single.visitor.log');
    Route::get('/branch/{est_code}/visitor-log/list', $parentDir.'\Branch\VisitorController@list')->name('branch.single.visitor.log.list');

    Route::get('/branch/{est_code}/assigned-employee', $parentDir.'\Branch\EmployeeController@index')->name('branch.single.assigned.employee');
    Route::get('/branch/{est_code}/assigned-employee/list', $parentDir.'\Branch\EmployeeController@list')->name('branch.single.assigned.employee.list');
    Route::post('/branch/{est_code}/employee/deploy', $parentDir.'\Branch\EmployeeController@deploy')->name('branch.single.employee.deploy');

    Route::get('/branch/{est_code}/scanner', $parentDir.'\Branch\ScannerController@index')->name('branch.single.scanner');
    Route::get('branch/{est_code}/scanner/list', $parentDir.'\Branch\ScannerController@list')->name('branch.single.scanner.list');
    Route::post('/branch/{est_code}/scanner/store', $parentDir.'\Branch\ScannerController@store')->name('branch.single.scanner.store');
    Route::get('/branch/{est_code}/scanner/show', $parentDir.'\Branch\ScannerController@show')->name('branch.single.scanner.show');
    Route::post('/branch/{est_code}/scanner/update', $parentDir.'\Branch\ScannerController@update')->name('branch.single.scanner.update');
    Route::post('/branch/{est_code}/scanner/assign', $parentDir.'\Branch\ScannerController@assign')->name('branch.single.scanner.assign');
    

    Route::get('/branch/visitors/list/{est_code}', $parentDir.'\BranchController@branchVisitor')->name('branch.visitor.list');
    Route::post('/branch/account/generate', $parentDir.'\BranchController@account')->name('account.generate');   

    Route::get('/employee/list/{id}', $parentDir.'\EmployeeController@branchList')->name('branch.employee.list');
    Route::get('employee/{poi}/establishment/log', $parentDir.'\EmployeeController@establishmentLog')->name('employee.establishment.log');
    Route::post('/enroll', $parentDir.'\EmployeeController@enrollStatus')->name('employee.status');



    Route::get('/scanner', $parentDir.'\ScannerController@index')->name('scanner');
    Route::get('/scanner/list', $parentDir.'\ScannerController@list')->name('scanner.list');
    Route::post('/scanner/store', $parentDir.'\ScannerController@store')->name('scanner.store');
    Route::post('/scanner/update', $parentDir.'\ScannerController@update')->name('scanner.update');
    Route::post('/scanner/destroy', $parentDir.'\ScannerController@destroy')->name('scanner.destroy');
    Route::post('/scanner/assign', $parentDir.'\ScannerController@assign')->name('scanner.assign');



    Route::get('/employee', $parentDir.'\EmployeeController@index')->name('employee');
    Route::get('/employee/list', $parentDir.'\EmployeeController@list')->name('employee.list');
    Route::get('/employee/{poi}/establishment/log', $parentDir.'\EmployeeController@establishmentLog')->name('employee.establishment.log');



    Route::get('/visitors', $parentDir.'\VisitorController@index')->name('visitors');
    Route::get('/visitor/list', $parentDir.'\VisitorController@list')->name('visitor.list');
    Route::get('/visitor/scanner', $parentDir.'\VisitorController@scanner')->name('visitor.scanner');
    Route::get('/visit/scanner/{est_code}/{poi}', $parentDir.'\VisitorController@register')->name('visitor.scan');



    Route::get('/account', $parentDir.'\AccountController@index')->name('account');
    Route::get('/account/edit', $parentDir.'\AccountController@edit')->name('account.edit');
    Route::post('/account/save', $parentDir.'\AccountController@save')->name('account.save');
    Route::post('/account/photo', $parentDir.'\AccountController@photo')->name('account.photo');
});


Route::group(['prefix' => 'wa', 'as' => 'wa.', 'middleware' => ['App\Http\Middleware\WebAdmin','auth']], function(){

    $parentDir = 'WebAdmin';

    Route::get('/home', $parentDir.'\HomeController@index')->name('home');
});