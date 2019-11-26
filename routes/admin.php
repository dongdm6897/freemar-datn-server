<?php
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles','Admin\RoleController');
    Route::resource('users','Admin\UserController');
    Route::resource('brands','Admin\BrandController');
    Route::resource('categories','Admin\CategoryController');
    Route::resource('withdraws','Admin\WithdrawController');
    Route::resource('collections','Admin\MasterCollectionController');
    Route::resource('orders','Admin\OrderController');

    Route::group(
        [
            'prefix' => 'user'
        ], function () {
        Route::get('status/{id}', 'Admin\UserController@status')->name('users.status');
        Route::post('updateStatus/{id}', 'Admin\UserController@updateStatus')->name('users.updateStatus');
        Route::get('get_all', 'Admin\UserController@getAll')->name('users.getAll');
    });

    Route::group(
        [
            'prefix' => 'withdraws'
        ], function () {
        Route::post('submit/{payment_id}','Admin\WithdrawController@submit')->name('withdraws.submit');
        Route::get('show/{payments_id}/{money_account_id}','Admin\WithdrawController@show')->name('withdraws.shows');
    });

});
