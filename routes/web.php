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
Route::get('/', 'Auth\CustomerLoginController@showLoginForm');
Route::get('/nganu', 'AdminController@nganu')->name('admin.nganu');

Route::group(['prefix' => 'admin'], function(){
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login');
    Route::post('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
    Route::get('/home', 'HomeController@index')->name('admin.home'); 
    Route::resource('trashtype', 'TrashTypeController')->except(['create', 'show']);
    Route::post('/trashtype/restore/{id}', 'TrashTypeController@restore')->name('trashtype.restore');
    Route::post('/trashtype/force/{id}', 'TrashTypeController@force')->name('trashtype.force');
    Route::resource('trashprice', 'TrashPriceController')->except(['create', 'show']);
    Route::post('/trashprice/restore/{id}', 'TrashPriceController@restore')->name('trashprice.restore');
    Route::post('/trashprice/force/{id}', 'TrashPriceController@force')->name('trashprice.force');
    Route::resource('admin', 'AdminController')->except(['create']);
    Route::post('/admin/restore/{id}', 'AdminController@restore')->name('admin.restore');
    Route::post('/admin/force/{id}', 'AdminController@force')->name('admin.force');
    Route::put('/admin/update/password/{id}', 'AdminController@updatePassword')->name('admin.update.password');
    Route::resource('/customer', 'CustomerController')->except(['create']);
    Route::post('/customer/restore/{id}', 'CustomerController@restore')->name('customer.restore');
    Route::post('/customer/force/{id}', 'CustomerController@force')->name('customer.force');
    Route::put('/customer/update/password/{id}', 'CustomerController@updatePassword')->name('customer.update.password');
    Route::resource('/transaction', 'TransactionController')->except(['create']);
    Route::post('/transaction/restore/{id}', 'TransactionController@restore')->name('transaction.restore');
    Route::post('/transaction/force/{id}', 'TransactionController@force')->name('transaction.force');
    Route::post('/transaction/filter', 'TransactionController@filter')->name('transaction.filter');
    Route::get('/earning', 'EarningController@index')->name('transaction.earning');
    Route::post('/earning/print', 'EarningController@print')->name('earning.print');
    Route::post('/earning/update/{id}', 'EarningController@withdrawUpdate')->name('withdraw.update');
    Route::post('/earning/{id}', 'EarningController@withdraw')->name('earning.withdraw');
    Route::resource('/detailtransaction', 'DetailTransactionController')->except(['create', 'edit']);
    Route::get('s/{id}', 'DetailTransactionController@edit')->name('detail.edit');
    Route::post('/detailtransaction/restore/{id}', 'DetailTransactionController@restore')->name('detailtransaction.restore');
    Route::post('/detailtransaction/force/{id}', 'DetailTransactionController@force')->name('detailtransaction.force');
    Route::post('/detailtransaction/print', 'DetailTransactionController@print')->name('detailtransaction.print');
    Route::post('/detailtransaction/restore/{id}', 'DetailTransactionController@restore')->name('detailtransaction.restore');
    Route::get('/getStates/{id}', 'TransactionController@getStates')->name('getStates');
    Route::resource('/director', 'DirectorController')->except(['create', 'edit']);
    Route::put('/director/update/password/{id}', 'DirectorController@updatePassword')->name('director.update.password');
    Route::post('/director/restore/{id}', 'DirectorController@restore')->name('director.restore');
    Route::post('/director/force/{id}', 'DirectorController@force')->name('director.force');


    //Route::post('/transaction/detailPost', 'DetailTransactionController@store')->name('transaction.post');
    
    //Route::get('/dropdown', 'TransController@index');
    Route::get('/dropdown/getprices/{id}', 'TransController@trashPrice');
    Route::get('/dropdown/prices/{id}', 'TransController@getPrice');
    Route::post('/transaction/detail/post', 'TransactionController@postDetail')->name('dropdown.post');
    Route::post('/dropdown/addmore', 'TransController@addMore')->name('addmore');
});

Route::group(['prefix' => 'customer'], function(){
    Route::get('/login', 'Auth\CustomerLoginController@showLoginForm');
    Route::post('/login', 'Auth\CustomerLoginController@login')->name('customer.login');
    Route::post('/logout', 'Auth\CustomerLoginController@logout')->name('customer.logout');
    Route::get('/', 'CustomerHomeController@home')->name('customer.home'); 
    Route::get('/transaction/{id}', 'CustomerHomeController@transactionShow')->name('customer.transactionShow');
    Route::get('/earning', 'CustomerHomeController@earning')->name('customer.earning');
    Route::post('/earning/withdraw/{id}', 'CustomerHomeController@withdraw')->name('customer_earning.withdraw');
    Route::get('/trashtype', 'CustomerHomeController@trashtype')->name('customer.trashtype');
    Route::get('/trashprice', 'CustomerHomeController@trashprice')->name('customer.trashprice');
});

Route::group(['prefix' => 'director'], function(){
    Route::get('/login', 'Auth\DirectorLoginController@showLoginForm');
    Route::post('/login', 'Auth\DirectorLoginController@login')->name('director.login');
    Route::post('/logout', 'Auth\DirectorLoginController@logout')->name('director.logout');
    Route::get('/home', 'DirectorHomeController@home')->name('director.home'); 
    Route::get('/admin', 'DirectorHomeController@admin')->name('director.admin'); 
    Route::get('/director', 'DirectorHomeController@director')->name('director.director'); 
    Route::get('/customer', 'DirectorHomeController@customer')->name('director.customer'); 
    Route::get('/trashtype', 'DirectorHomeController@trashtype')->name('director.trashtype'); 
    Route::get('/trashprice', 'DirectorHomeController@trashprice')->name('director.trashprice');
    Route::get('/transaction', 'DirectorHomeController@transaction')->name('director.transaction');
    Route::get('/transaction/{id}', 'DirectorHomeController@showTransaction')->name('director.transaction.show');
    Route::get('/earning', 'DirectorHomeController@earning')->name('director.earning');

});

Auth::routes();