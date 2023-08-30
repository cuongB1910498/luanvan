<?php
// frontEnd
Route::get('/', 'homecontroller@index');
Route::get('/trang-chu', 'homecontroller@index');
Route::get('/register', 'homecontroller@register');
Route::post('/register', 'homecontroller@register_process');
Route::get('/login', 'homecontroller@login');
Route::post('/login', 'homecontroller@login_process');
Route::get('/logout', 'homecontroller@logout');

Route::get('/barcode', 'homecontroller@barcode');

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
        // Create Staff
            Route::get('/add-user', 'UserController@add_user');  
            Route::post('/user-add-process', 'UserController@user_add_process');  

    //staff
Route::get('/staff/dashboard', 'StaffController@index');