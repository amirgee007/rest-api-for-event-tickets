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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(["namespace"  =>  "Api"], function () {

    Route::get('index','TestController@index');
    Route::post('update/{id}','TestController@update');


    Route::group(["prefix"  =>  "ticket"], function () {

        Route::get('/','TicketsController@index');
        Route::post('/','TicketsController@store');
        Route::get('/{id}','TicketsController@show');
        Route::post('/{id}','TicketsController@update');
        Route::delete('/{id}/','TicketsController@destroy');

    });

    Route::group(["prefix"  =>  "event-ticket-setting"], function () {

        Route::get('/','EventTicketSettingController@index');
        Route::post('/','EventTicketSettingController@store');
        Route::get('/{event_id}','EventTicketSettingController@show');
        Route::post('/{id}','EventTicketSettingController@update');
        Route::delete('/{id}/','EventTicketSettingController@destroy');

    });

    Route::post('/purchase-ticket','EventTicketPurchaseController@purchaseTicket');
    Route::post('/purchase-ticket-order/{order_id}/confirm-payment','EventTicketPurchaseController@confirmTicketPayment');

    Route::get('/all-purchase-tickets','EventTicketPurchaseController@allPurchaseOrderLogs');
    Route::get('/all-orders','EventTicketPurchaseController@allOrders');
    Route::get('/all-ticket-stubs','EventTicketPurchaseController@allTicketStubs');


});
