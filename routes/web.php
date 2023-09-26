<?php
// frontEnd

use App\Http\Controllers\AdminController;
use App\Http\Controllers\homecontroller;
use App\Http\Controllers\StaffController;

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

    //Create tracking
        Route::get('/create-tracking', "homecontroller@create_tracking");
        Route::post('/creating-process', "homecontroller@creating_process");
        Route::get('/list-tracking', "homecontroller@list_tracking");
        Route::get('/view-tracking/{id_tracking}', "homecontroller@view_tracking");
        Route::get('/select-province', 'homecontroller@selectProvince');
        Route::get('/create-tracking-by-excel', 'homecontroller@importTracking');
        Route::post('/import-csv', 'homecontroller@importCsv');

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
        
        // Truck Driver
            Route::get('staff/check-in-truck', 'StaffController@checkInTruck');
            Route::get('/truck-log', 'StaffController@truckLog');