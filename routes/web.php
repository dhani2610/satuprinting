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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'FrontendController@home')->name('index');
Route::get('/detail/{id}', 'FrontendController@detailProd')->name('detail-prod');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/category', 'FrontendController@category')->name('category-landing');
Route::get('/generate-data', 'FrontendController@generate')->name('generate-data');

/**
 * Admin routes
 */
Route::group(['prefix' => 'admin'], function () {
    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', 'Backend\ProfileController@changePassword')->name('profile');
        Route::post('/proses-change-password', 'Backend\ProfileController@changePasswordProses')->name('profile.proses-change-password');
    });

    Route::group(['prefix' => 'support'], function () {
        Route::get('/', 'Backend\SupportController@index')->name('support');
    });
    
    Route::group(['prefix' => 'setting'], function () {
        Route::get('/', 'Backend\SettingController@index')->name('setting');
        Route::post('/store', 'Backend\SettingController@store')->name('setting.store');
    });
    
    Route::get('/', 'Backend\DashboardController@index')->name('admin.dashboard');
    Route::resource('roles', 'Backend\RolesController', ['names' => 'admin.roles']);
    Route::resource('users', 'Backend\UsersController', ['names' => 'admin.users']);
    Route::resource('admins', 'Backend\AdminsController', ['names' => 'admin.admins']);

    Route::group(['prefix' => 'client'], function () {
        Route::get('/', 'Backend\DashboardController@client')->name('client');
        Route::get('/tracking/{no_proj}', 'Backend\DashboardController@tracking')->name('tracking');
    });
    Route::group(['prefix' => 'services'], function () {
        Route::get('/', 'Backend\ServicesController@index')->name('services');
        Route::post('store', 'Backend\ServicesController@store')->name('services.store');
        Route::post('update/{id}', 'Backend\ServicesController@update')->name('services.update');
        Route::get('destroy/{id}', 'Backend\ServicesController@destroy')->name('services.destroy');
    });
    Route::group(['prefix' => 'category'], function () {
        Route::get('/', 'Backend\CategoryWorkController@index')->name('category');
        Route::post('store', 'Backend\CategoryWorkController@store')->name('category.store');
        Route::post('update/{id}', 'Backend\CategoryWorkController@update')->name('category.update');
        Route::get('destroy/{id}', 'Backend\CategoryWorkController@destroy')->name('category.destroy');
    });
    Route::group(['prefix' => 'customer'], function () {
        Route::get('/', 'Backend\CustomerController@index')->name('customer');
        Route::post('store', 'Backend\CustomerController@store')->name('customer.store');
        Route::post('update/{id}', 'Backend\CustomerController@update')->name('customer.update');
        Route::get('destroy/{id}', 'Backend\CustomerController@destroy')->name('customer.destroy');
    });
    Route::group(['prefix' => 'divisi'], function () {
        Route::get('/', 'Backend\DivisiController@index')->name('divisi');
        Route::post('store', 'Backend\DivisiController@store')->name('divisi.store');
        Route::post('update/{id}', 'Backend\DivisiController@update')->name('divisi.update');
        Route::get('destroy/{id}', 'Backend\DivisiController@destroy')->name('divisi.destroy');
    });
    Route::group(['prefix' => 'state'], function () {
        Route::get('/', 'Backend\StateController@index')->name('state');
        Route::post('store', 'Backend\StateController@store')->name('state.store');
        Route::post('update/{id}', 'Backend\StateController@update')->name('state.update');
        Route::get('destroy/{id}', 'Backend\StateController@destroy')->name('state.destroy');
    });
    Route::group(['prefix' => 'city'], function () {
        Route::get('/get-city', 'Backend\CityController@getCity')->name('get-city');
        Route::get('/', 'Backend\CityController@index')->name('city');
        Route::post('store', 'Backend\CityController@store')->name('city.store');
        Route::post('update/{id}', 'Backend\CityController@update')->name('city.update');
        Route::get('destroy/{id}', 'Backend\CityController@destroy')->name('city.destroy');
    });
    Route::group(['prefix' => 'category-document'], function () {
        Route::get('/', 'Backend\CategoryDocumentController@index')->name('category-document');
        Route::post('store', 'Backend\CategoryDocumentController@store')->name('category-document.store');
        Route::post('update/{id}', 'Backend\CategoryDocumentController@update')->name('category-document.update');
        Route::get('destroy/{id}', 'Backend\CategoryDocumentController@destroy')->name('category-document.destroy');
    });
    Route::group(['prefix' => 'slider'], function () {
        Route::get('/', 'Backend\SliderController@index')->name('slider');
        Route::post('store', 'Backend\SliderController@store')->name('slider.store');
        Route::post('update/{id}', 'Backend\SliderController@update')->name('slider.update');
        Route::get('destroy/{id}', 'Backend\SliderController@destroy')->name('slider.destroy');
    });
    Route::group(['prefix' => 'category-kajian'], function () {
        Route::get('/', 'Backend\CategoryKajianController@index')->name('category-kajian');
        Route::post('store', 'Backend\CategoryKajianController@store')->name('category-kajian.store');
        Route::post('update/{id}', 'Backend\CategoryKajianController@update')->name('category-kajian.update');
        Route::get('destroy/{id}', 'Backend\CategoryKajianController@destroy')->name('category-kajian.destroy');
    });
    Route::group(['prefix' => 'category-simbg'], function () {
        Route::get('/', 'Backend\CategorySimbgController@index')->name('category-simbg');
        Route::post('store', 'Backend\CategorySimbgController@store')->name('category-simbg.store');
        Route::post('update/{id}', 'Backend\CategorySimbgController@update')->name('category-simbg.update');
        Route::get('destroy/{id}', 'Backend\CategorySimbgController@destroy')->name('category-simbg.destroy');
    });

    Route::group(['prefix' => 'activity'], function () {
        Route::get('/', 'Backend\ActivityController@index')->name('activity');
        Route::post('store', 'Backend\ActivityController@store')->name('activity.store');
        Route::post('update/{id}', 'Backend\ActivityController@update')->name('activity.update');
        Route::get('destroy/{id}', 'Backend\ActivityController@destroy')->name('activity.destroy');
    });

    Route::group(['prefix' => 'assignment'], function () {
        Route::get('/', 'Backend\AssignmentController@index')->name('assignment');
        Route::post('store', 'Backend\AssignmentController@store')->name('assignment.store');
        Route::post('update/{id}', 'Backend\AssignmentController@update')->name('assignment.update');
        Route::get('destroy/{id}', 'Backend\AssignmentController@destroy')->name('assignment.destroy');

        Route::get('print/{id}', 'Backend\AssignmentController@print')->name('assignment.print');
    });

    // TRANSAKTION 
    Route::post('/getCustomerDetails', 'Backend\QuotationController@getCustomerDetails')->name('getCustomerDetails');
    Route::post('/getProjectByCustomer/{id}', 'Backend\ActivityController@getProjectByCustomer')->name('getProjectByCustomer');
    Route::get('/getInvoice', 'Backend\InvoiceController@getInvoice')->name('getInvoice');
    // Route::get('/getPaymentInvoice', 'Backend\InvoiceController@getPaymentInvoice')->name('getPaymentInvoice');

    Route::group(['prefix' => 'quotation'], function () {
        Route::get('/', 'Backend\QuotationController@index')->name('quotation');
        Route::post('store', 'Backend\QuotationController@store')->name('quotation.store');
        Route::post('update/{id}', 'Backend\QuotationController@update')->name('quotation.update');
        Route::get('destroy/{id}', 'Backend\QuotationController@destroy')->name('quotation.destroy');
    });

    Route::get('/getQuotation', 'Backend\PurchaseOrderController@getQuotation')->name('getQuotation');
    Route::get('/getPO', 'Backend\PurchaseOrderController@getPO')->name('getPO');
    Route::get('/getProject', 'Backend\PurchaseOrderController@getProject')->name('getProject');

    Route::group(['prefix' => 'purchase-order'], function () {
        Route::get('/', 'Backend\PurchaseOrderController@index')->name('purchase-order');
        Route::post('store', 'Backend\PurchaseOrderController@store')->name('purchase-order.store');
        Route::post('update/{id}', 'Backend\PurchaseOrderController@update')->name('purchase-order.update');
        Route::get('destroy/{id}', 'Backend\PurchaseOrderController@destroy')->name('purchase-order.destroy');
    });

    Route::group(['prefix' => 'project'], function () {
        Route::get('/', 'Backend\ProjectController@index')->name('project');
        Route::post('store', 'Backend\ProjectController@store')->name('project.store');
        Route::post('update/{id}', 'Backend\ProjectController@update')->name('project.update');
        Route::get('destroy/{id}', 'Backend\ProjectController@destroy')->name('project.destroy');

        Route::post('/create-team/{id}', 'Backend\ProjectController@storeTeam')->name('project.create.team');
        // tahapan acivity
        Route::get('/data-activity-dashboard', 'Backend\ProjectController@getActivityDashboard')->name('project.get.activity.dashboard');
        Route::get('/data-activity/{projectId}', 'Backend\ProjectController@getActivity')->name('project.get.activity');
        Route::get('/activity/{id}', 'Backend\ProjectController@activity')->name('project.activity');

        // tahapan document
        Route::get('/document/{id}', 'Backend\ProjectController@document')->name('project.document');
        Route::POST('/document-store/{id}', 'Backend\ProjectController@storeDocProject')->name('project.document.store');

        // tahapan survey
        Route::group(['prefix' => 'survey-project'], function () {
            Route::get('/{id}', 'Backend\SurveyProjectController@index')->name('survey.project');
            Route::post('store/{id}', 'Backend\SurveyProjectController@store')->name('survey.project.store');
            Route::post('update/{id_project}/{id}', 'Backend\SurveyProjectController@update')->name('survey.project.update');
            Route::get('destroy/{id_project}/{id}', 'Backend\SurveyProjectController@destroy')->name('survey.project.destroy');
        });

        // tahapan kajian
        Route::group(['prefix' => 'kajian'], function () {
            Route::get('/{id}', 'Backend\KajianProjectController@index')->name('kajian.project');
            Route::post('store/{id}', 'Backend\KajianProjectController@store')->name('kajian.project.store');
            Route::post('update/{id_project}/{id}', 'Backend\KajianProjectController@update')->name('kajian.project.update');
            Route::get('destroy/{id_project}/{id}', 'Backend\KajianProjectController@destroy')->name('kajian.project.destroy');
        });

        // tahapan simbg
        Route::group(['prefix' => 'simbg'], function () {
            Route::get('/{id}', 'Backend\SimbgProjectController@index')->name('simbg.project');
            Route::post('store/{id}', 'Backend\SimbgProjectController@store')->name('simbg.project.store');
            Route::post('update/{id_project}/{id}', 'Backend\SimbgProjectController@update')->name('simbg.project.update');
            Route::get('destroy/{id_project}/{id}', 'Backend\SimbgProjectController@destroy')->name('simbg.project.destroy');
        });

        // tahapan certificate
        Route::group(['prefix' => 'certificate'], function () {
            Route::get('/{id}', 'Backend\CertificateProjectController@index')->name('certificate.project');
            Route::post('store/{id}', 'Backend\CertificateProjectController@store')->name('certificate.project.store');
        });

        // tahapan documentation
        Route::group(['prefix' => 'documentation'], function () {
            Route::get('/{id}', 'Backend\DocumentationProjectController@index')->name('documentation.project');
            Route::post('store/{id}', 'Backend\DocumentationProjectController@store')->name('documentation.project.store');
            Route::post('update/{id}', 'Backend\DocumentationProjectController@update')->name('documentation.project.update');
        });
    });

    Route::group(['prefix' => 'invoice'], function () {
        Route::get('/', 'Backend\InvoiceController@index')->name('invoice');
        Route::get('pdf/{id}', 'Backend\InvoiceController@pdf')->name('pdf-invoice');
        Route::post('store', 'Backend\InvoiceController@store')->name('invoice.store');
        Route::post('update', 'Backend\InvoiceController@update')->name('invoice.update');
        Route::get('destroy/{id}', 'Backend\InvoiceController@destroy')->name('invoice.destroy');
    });
    Route::group(['prefix' => 'payment'], function () {
        Route::get('list-payment-invoice', 'Backend\InvoiceController@listPaymentInvoice')->name('list-payment-invoice');
        Route::get('payment-invoice-by-id', 'Backend\InvoiceController@PaymentInvoiceById')->name('payment-invoice-by-id');
        Route::post('store', 'Backend\InvoiceController@storePayment')->name('payment.store');
        Route::post('update', 'Backend\InvoiceController@updatePayment')->name('payment.update');
        Route::get('destroy/{id}', 'Backend\InvoiceController@destroyPayment')->name('payment.destroy');
    });
  
    Route::group(['prefix' => 'event'], function () {
        Route::get('/get-all-event', 'Backend\EventController@getAllEvent')->name('get-all-event');
        Route::get('/get-event/{id}', 'Backend\EventController@getEvent')->name('get-event');
        Route::get('/', 'Backend\EventController@index')->name('event');
        Route::post('store', 'Backend\EventController@store')->name('event.store');
        Route::post('update/{id}', 'Backend\EventController@update')->name('event.update');
        Route::get('destroy/{id}', 'Backend\EventController@destroy')->name('event.destroy');
    });

    Route::group(['prefix' => 'attendance'], function () {
        Route::get('/', 'Backend\AttendanceController@index')->name('attendance');
        Route::post('/store', 'Backend\AttendanceController@store')->name('attendance.store');
        Route::get('/team/rekap/{id}', 'Backend\AttendanceController@rekapByUser')->name('attendance.team.rekap');
    });
 
    Route::group(['prefix' => 'setting-attendance'], function () {
        Route::get('/', 'Backend\AttendanceController@index')->name('setting-attendance');
        Route::post('/store', 'Backend\AttendanceController@store')->name('setting-attendance.store');
    });
 
  
  

    // Login Routes
    Route::get('/login', 'Backend\Auth\LoginController@showLoginForm')->name('admin.login');
    Route::post('/login/submit', 'Backend\Auth\LoginController@login')->name('admin.login.submit');

    // Logout Routes
    Route::post('/logout/submit', 'Backend\Auth\LoginController@logout')->name('admin.logout.submit');

    // // Forget Password Routes
    // Route::get('/password/reset', 'Backend\Auth\ForgetPasswordController@showLinkRequestForm')->name('admin.password.request');
    // Route::post('/password/reset/submit', 'Backend\Auth\ForgetPasswordController@reset')->name('admin.password.update');
});
