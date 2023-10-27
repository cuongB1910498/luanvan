<?php
// frontEnd

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExportVatController;
use App\Http\Controllers\homecontroller;
use App\Http\Controllers\layoutController;
use App\Http\Controllers\SortingCenterController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Route;

Route::middleware(['checkRequestMethod'])->group(function () {
    Route::get('/import-csv', 'homecontroller@importCsv');
    Route::get('/creating-process', "homecontroller@creating_process");
    Route::get('/admin-login-process', 'AdminController@admin_login_process');
    Route::get('/possison-process', 'ManagePosision@posision_process');
    Route::get('/update-posision/{id_posision}', 'ManagePosision@update_posision');
    Route::get('/add-station-process', 'AdminController@add_station_process');
    Route::get('/edit-staff-process/{id_staff}', 'AdminController@edit_staff_process');
    Route::get('/user-add-process', 'UserController@user_add_process');
    Route::get('/add-truck-process', 'AdminController@addTruckProcess');
    Route::get('/update-truck-process/{id_truck}', 'AdminController@updateTruckProcess');
    Route::get('/staff/login-process', 'StaffController@login_process');
    Route::get('/staff/user-change', "StaffController@user_change");
    Route::get('/staff/change-password', "StaffController@change_password");
    Route::get('/staff/arrived-process', 'StaffController@arrived_process');
    Route::get('/staff/process-add-bag', 'StaffController@processAddBag');
    Route::get('/to-truck-process/{id_bag}', 'StaffController@toTruckprocess');
    Route::get('/deliver-complete/{id_tracking}', 'StaffController@deliverComplete');
    Route::get('/deliver-fail/{id_tracking}', 'StaffController@deliverFail');
    Route::get('/change-profile', 'homecontroller@changeProfile');
    Route::get('/add-address-process', 'homecontroller@addAddressProcess');
    Route::get('/create-company-info', 'ExportVatController@createCompanyInfo');
});


Route::get('/', 'homecontroller@index');
Route::get('/trang-chu', 'homecontroller@index');
Route::get('/register', 'homecontroller@register');
Route::post('/register', 'homecontroller@register_process');
Route::get('/login', 'homecontroller@login');
Route::post('/login', 'homecontroller@login_process');
Route::get('/logout', 'homecontroller@logout');
Route::get('/user', 'homecontroller@user');

Route::get('/carbon', 'homecontroller@show_carbon');

Route::get('/barcode', 'homecontroller@barcode');
Route::get('/pdf/{id_tracking}', 'homecontroller@generatePDF');
Route::get('reload-captcha', 'AdminController@reloadCaptcha');

    //Create tracking
        Route::get('/create-tracking', "homecontroller@create_tracking");
        Route::post('/creating-process', "homecontroller@creating_process");
        Route::get('/list-tracking', "homecontroller@list_tracking");
        Route::get('/view-tracking/{id_tracking}', "homecontroller@view_tracking");
        Route::get('/select-province', 'homecontroller@selectProvince');
        Route::get('/create-tracking-by-excel', 'homecontroller@importTracking');
        Route::post('/import-csv', 'homecontroller@importCsv');

    // user manager
        Route::get('user-profile', 'homecontroller@userProfile');
        Route::post('/change-profile', 'homecontroller@changeProfile');

    //Address
        Route::get('/my-address', 'homecontroller@myAddress');
        Route::get('/add-address', 'homecontroller@addAddress');
        Route::post('/add-address-process', 'homecontroller@addAddressProcess');
        Route::get('/modify-address/{id_address}', 'homecontroller@modifyAddress');
        Route::get('/delete-address/{id_address}', 'homecontroller@deletaAddress');
        Route::post('/modify-address-process/{id_address}', 'homecontroller@ModifyAddressProcess');
        Route::get('/test-error', 'homecontroller@testError');

    //Export VAT
        Route::get('/vat-preview', 'ExportVatController@vatPreview');
        Route::get('/sent-mail', 'ExportVatController@sentMailVat');
        Route::post('/create-company-info', 'ExportVatController@createCompanyInfo');
        Route::get('/export-vat', 'ExportVatController@exportVat');

    //Tracking Located
        Route::get('/located', 'locatedController@located');
        Route::post('/process-tracking', 'locatedController@findLocated');

    //UI
        Route::get('/how-to-pack', 'layoutController@howtoPack');
        Route::get('/prohibited-list', 'layoutController@prohibitedList');

//BackEnd
    //admin
Route::get('/admin-dashboard', 'AdminController@dashboard');
Route::get('/adminlogin', 'AdminController@login');
Route::get('/admin-logout', 'AdminController@logout');
Route::post('/admin-login-process', 'AdminController@admin_login_process');

        //posision
            Route::get('/add-posision', 'ManagePosision@add_posision');
            Route::post('/possison-process', 'ManagePosision@posision_process');
            Route::get('/posision-list', 'ManagePosision@posision_list');
            Route::get('/edit-posision/{id_posision}', 'ManagePosision@edit_posision');
            Route::post('/update-posision/{id_posision}', 'ManagePosision@update_posision');
            Route::get('/delete-posision/{id_posision}', 'ManagePosision@delete_posision');
        //Stations
            Route::get('/add-station', 'AdminController@add_station');
            Route::get('/station-list', 'AdminController@station_list');
            Route::post('/add-station-process', 'AdminController@add_station_process');
            Route::get('/station/{id_station}', 'AdminController@station_detail');
            Route::get('/edit-staff/{id_staff}', 'AdminController@edit_staff');
            Route::post('/edit-staff-process/{id_staff}', 'AdminController@edit_staff_process');
        // Staff
            Route::get('/add-user', 'UserController@add_user');  
            Route::post('/user-add-process', 'UserController@user_add_process'); 
        
        //Truck
            Route::get('/add-truck', 'AdminController@add_truck');
            Route::post('/add-truck-process', 'AdminController@addTruckProcess');
            Route::get('/edit-truck/{id_truck}', 'AdminController@editTruck');
            Route::post('/update-truck-process/{id_truck}', 'AdminController@updateTruckProcess');
            Route::get('/detete-truck/{id_truck}', 'AdminController@deleteTruck');

            Route::get('/trucks-details', "AdminController@trucksDetail");
            Route::get('/truck-details/{id_truck}', 'AdminController@showtruckDetail');

    //staff
Route::get('/staff/dashboard', 'StaffController@index');
Route::get('/staff/', 'StaffController@index');
        // Staff Login
            Route::get('/staff/login', 'StaffController@login');
            Route::post('/staff/login-process', 'StaffController@login_process');
            Route::get('/staff/logout', 'StaffController@logout');
        //Staff Change information
            Route::get('/staff/profile', 'StaffController@staff_profile');
            Route::post('/staff/user-change', "StaffController@user_change");
        //setting
            Route::get('/staff/setting', "StaffController@setting");
            Route::post('/staff/change-password', "StaffController@change_password");
        //Manage Tracking of station
            Route::get('/staff/confirm-arrived', 'StaffController@confirm_arrived');
            //Route::get('/staff/confirm-gone', 'StaffController@confirm_gone');
            Route::post('/staff/arrived-process', 'StaffController@arrived_process');
            Route::get('/staff/tracking-in-post-station', 'StaffController@all_tracking');
            //Route::get('/staff/process-data', 'StaffController@process_data');
            Route::get('/staff/process-data', 'StaffController@processData');
            //add to bag 
            Route::get('/staff/add-to-bag', 'StaffController@addToBag');
            Route::post('/staff/process-add-bag', 'StaffController@processAddBag');
            Route::get('/staff/view-bag/{id_bag}', 'StaffController@viewBag');
            //Add to truck
            Route::get('/staff/to-truck', 'StaffController@toTruck');
            Route::post('/to-truck-process/{id_bag}', 'StaffController@toTruckprocess');
        
        // Truck Driver
            Route::get('/staff/check-in-truck', 'StaffController@checkInTruck');
            Route::get('/truck-log', 'StaffController@truckLog');
        // Delivery staff
            Route::get('/staff/get-tracking', 'StaffController@getTracking');
            Route::get('/staff/get-tracking-process/{id_tracking}', 'StaffController@getTrackingProcess');
            Route::get('/staff/deliver-tracking', 'StaffController@deliverTracking');
            Route::post('/deliver-complete/{id_tracking}', 'StaffController@deliverComplete');
            Route::post('/deliver-fail/{id_tracking}', 'StaffController@deliverFail');
            Route::get('/staff/receive-tracking', 'StaffController@receiveTracking');
        //Sorting center
            Route::get('staff/arrive-sc', 'SortingCenterController@arriveSC');
            Route::post('/staff/process-sort', 'SortingCenterController@processSort');