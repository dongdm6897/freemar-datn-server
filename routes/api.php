<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


//Authenticate
Route::group(
    [
        'namespace' => 'Auth',
        'middleware' => 'api',
        'prefix' => 'auth'
    ], function () {
    Route::post('login', 'AuthController@login');
    Route::post('login_social', 'AuthController@loginSocial');
    Route::post('signup', 'AuthController@signup');
    Route::get('signup/activate/{token}', 'AuthController@signupActivate');
    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::get('logout', 'AuthController@logout');
        Route::get('profile', 'AuthController@profile');
    });
});

Route::group([
    'namespace' => 'Auth',
    'middleware' => 'api',
    'prefix' => 'password'
], function () {
    Route::post('create', 'PasswordResetController@create');
    Route::get('find/{token}', 'PasswordResetController@find');
    Route::post('reset', 'PasswordResetController@reset');
});

//Client
Route::group(['namespace' => 'Client'], function () {
    Route::resource('products', 'ProductController');
    Route::resource('brands', 'BrandController');
    Route::resource('category', 'CategoryController');
    Route::resource('users', 'UserController');
    Route::resource('objects', 'ObjectController');
    Route::post('webhook', 'WebhookController@handle');
    Route::get('webhook', 'WebhookController@receive');
    Route::get('get_master_data', 'MasterDataController@getMasterData');

    //User
    Route::group(
        [
            'prefix' => 'user'
        ], function () {
        Route::get('get_all_seller', 'UserController@getAllSeller');
        Route::get('get_related', 'UserController@getRelated');
        Route::get('get_user', 'UserController@getUser');
        Route::get('get_shipping_address', 'UserController@getShippingAddress');
        Route::get('get_follow_user', 'UserController@getFollowUser');
        Route::group([
            'middleware' => 'auth:api'
        ], function () {
            Route::post('set_favorite_product', 'UserController@setFavoriteProduct');
            Route::post('create_favorite_brand', 'UserController@createFavoriteBrand');
            Route::delete('delete_favorite_brand', 'UserController@deleteFavoriteBrand');
            Route::post('create_favorite_category', 'UserController@createFavoriteCategory');
            Route::delete('delete_favorite_category', 'UserController@deleteFavoriteCategory');
            Route::put('update_user_status', 'UserController@updateUserStatus');
            Route::post('set_watched_product', 'UserController@setWatchedProduct');
            Route::post('set_shipping_address', 'UserController@setShippingAddress');
            Route::delete('delete_shipping_address','UserController@deleteShippingAddress');
            Route::post('set_follow_user', 'UserController@setFollowUser');
            Route::post('set_user', 'UserController@setUser');
        });
    });

    //BrandController
    Route::group(
        [
            'prefix' => 'brand'
        ], function () {
        Route::get('get_all', 'BrandController@getAllBrand');
        Route::put('update', 'BrandController@updateById');
        Route::post('create', 'BrandController@create');
        Route::post('destroy/{id}', 'BrandController@destroy');
        Route::get('get/{id}', 'BrandController@getById');
        Route::get('get_products', 'BrandController@getProductBrand');
        Route::get('get_favorite', 'BrandController@getFavoriteBrand');

    });

    //CategoryController
    Route::group(
        [
            'prefix' => 'categories'
        ], function () {
        Route::put('update', 'CategoryController@updateById');
        Route::post('create', 'CategoryController@create');
        Route::post('destroy/{id}', 'CategoryController@destroy');
        Route::get('get_all', 'CategoryController@getAllCategory');
    });

    //Product
    Route::group(
        [
            'prefix' => 'product'
        ], function () {
        Route::get('get_recently', 'ProductController@getRecentlyProduct');
        Route::get('get_new', 'ProductController@getNewProduct');
        Route::get('get_sold_out', 'ProductController@getSoldProduct');
        Route::get('get_ordering', 'ProductController@getOrderingProduct');
        Route::get('get_selling', 'ProductController@getSellingProduct');
        Route::get('get_favorite', 'ProductController@getFavoriteProduct');
        Route::get('get_commented', 'ProductController@getCommentedProduct');
        Route::get('get_by_owner', 'ProductController@getByOwner');
        Route::get('get_related', 'ProductController@getRelated');
        Route::get('get_product_brand','ProductController@getProductBrand');
        Route::get('get_product_category','ProductController@getProductCategory');
        Route::get('get_watched','ProductController@getWatched');
        Route::get('get_free','ProductController@getFree');

        Route::group(
            [
                'middleware' => 'auth:api'
            ], function () {
            Route::get('get_draft', 'ProductController@getDraft');
            Route::post('set_product', 'ProductController@setProduct');
            Route::get('get_new_auth', 'ProductController@getNewProduct');
            Route::get('get_sold_out_auth', 'ProductController@getSoldProduct');
            Route::get('get_ordering_auth', 'ProductController@getOrderingProduct');
            Route::get('get_buying', 'ProductController@getBuyingProduct');
            Route::get('get_bought', 'ProductController@getBoughtProduct');
            Route::get('get_product','ProductController@getProductById');
            Route::delete('delete_product','ProductController@delete');
        });

    });

    //Shipping Provider

    Route::group(
        [
            'prefix' => 'ship'
        ], function () {
        Route::get('/fee-estimate', 'ShipController@getEstimateFee');
        Route::post('/order-status', 'ShipController@getOrderStatus');
        Route::post('/create-order/{order_id}', 'ShipController@createShippingOrder');
        Route::get('/ship_providers', 'ShipController@getShipProviders');
        Route::get('/provider_services/{provider_id}', 'ShipController@getShippingServiceByProviderId');

    });


    //CollectionController
    Route::group(
        [
            'prefix' => 'collection'
        ], function () {
        Route::get('get_all', 'MasterCollectionController@getAllCollection');
        Route::get('get_product_collection', 'MasterCollectionController@getProductCollection');
    });

    //Search
    Route::group(
        ['prefix' => 'search'], function () {
        Route::get('search_product', 'SearchController@searchProduct');
        Route::get('search_brand', 'SearchController@searchBrand');
        Route::get('search_category', 'SearchController@searchCategory');
        Route::get('search_everything', 'SearchController@searchEverything');
        Route::get('get_product_search_tmp', 'SearchController@getProductSearchTmp');
        Route::group([
            'middleware' => 'auth:api'
        ], function () {
            Route::post('save_search_history','SearchController@saveSearchHistory');
            Route::post('create_search_product', 'SearchController@createSearchProduct');
            Route::delete('delete_search_product', 'SearchController@deleteSearchProduct');
        });

    }
    );

    //Order
    Route::group(
        [
            'prefix' => 'order',
            'middleware' => 'auth:api'
        ], function () {
        Route::post('set_order', 'OrderController@setOrder');
        Route::post('set_order_status', 'OrderController@setOrderStatus');
        Route::get('get', 'OrderController@getOrder');
        Route::post('delete_all', 'OrderController@deleteOrder');
        Route::post('delete_by_id', 'OrderController@deleteOrderById');
        Route::post('set_order_assessment', 'OrderController@setOrderAssessment');
    }
    );

    //Message
    Route::group(
        [
            'prefix' => 'message'
        ], function () {
        Route::get('get_message', 'MessageController@getMessage');
        Route::post('create_channel', 'MessageController@createChannel');
        Route::group([
            'middleware' => 'auth:api'
        ], function () {
            Route::post('set_message', 'MessageController@setMessage');
        });
    });

    //Upload
    Route::group(
        [
            'prefix' => 'upload'
        ], function () {
        Route::group([
            'middleware' => 'auth:api'
        ], function () {
            Route::post('images', 'UploadFileController@uploadImages');
            Route::post('files', 'UploadFileController@uploadFiles');
            Route::post('image', 'UploadFileController@upload');
        });
    });

    //Address
    Route::group(
        [
            'prefix' => 'address'
        ], function () {
        Route::get('get_province', 'AddressController@getProvince');
        Route::get('get_district', 'AddressController@getDistrict');
        Route::get('get_ward', 'AddressController@getWard');
        Route::get('get_street', 'AddressController@getStreet');
    });

    //Identity
    Route::group(
        [
            'prefix' => 'identity'
        ], function () {
        Route::group([
            'middleware' => 'auth:api'
        ], function () {
            Route::post('verify_photo', 'IdentityController@verifyPhoto');
            Route::post('verify_address', 'IdentityController@verifyAddress');
            Route::get('get_photo_verified', 'IdentityController@getPhotoVerified');
        });
    });

    //Notification
    Route::group(
        [
            'prefix' => 'notification'
        ], function () {
        Route::get('count_unread', 'NotificationController@countUnread');
        Route::get('get_system', 'NotificationController@getSystem');
        Route::group([
            'middleware' => 'auth:api'
        ], function () {
            Route::get('get_your', 'NotificationController@getYour');
            Route::post('set_unread', 'NotificationController@setUnread');
        });
    });

    //Revenue
    Route::group(
        [
            'prefix' => 'revenue'
        ], function () {
        Route::group([
            'middleware' => 'auth:api'
        ], function () {
            Route::get('get_balance', 'Revenue@getYour');
        });
    });

    //Payment
    Route::group(
        [
            'prefix' => 'payment'
        ], function () {
        Route::group([
            'middleware' => 'auth:api'
        ], function () {
            Route::post('create_payment', 'PaymentController@createPayment');
            Route::get('get_payment','PaymentController@getPayment');
            Route::get('get_revenue','PaymentController@getRevenue');
            Route::get('get_revenue_chart','PaymentController@getRevenueChart');
            Route::post('request_withdrawal','PaymentController@requestWithdrawal');
        });
    });

    //Rank
    Route::group(
        ['prefix' => 'rank'], function () {
        Route::get('get_all', 'RankController@getAll');
    }
    );
});



