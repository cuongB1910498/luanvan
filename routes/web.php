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
Route::get('/admin-dashboard', 'AdminController@dashboard');
Route::get('/adminlogin', 'AdminController@login');
Route::get('/admin-logout', 'AdminController@logout');

Route::post('/admin-login-process', 'AdminController@admin_login_process');