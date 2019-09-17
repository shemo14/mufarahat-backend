<?php
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'localization'], function (){
	// language
	Route::post('set_lang'                  , 'Api\AppController@set_lang');

	// auth
	Route::post('login'                     , 'Api\AuthController@login');
	Route::post('register'                  , 'Api\AuthController@register');
	Route::post('forget_password'           , 'Api\AuthController@forget_password');
	Route::post('renew_password'            , 'Api\AuthController@renew_password');
	Route::post('active_account'            , 'Api\AuthController@active_account');

	// roles
	Route::post('roles'              		, 'Api\AppController@roles');


	// common questions
	Route::post('common_questions'          , 'Api\AppController@common_questions');

	// testing uploading video
	Route::post('uploading_video'           , 'Api\AppController@uploading_video');

	// about app
	Route::post('about_app'          		, 'Api\AppController@about_app');

	// contact us details
	Route::post('app_info'    		 		, 'Api\AppController@app_info');

	// send report
	Route::post('send_report'    	 		, 'Api\AppController@send_report');

	// categories
	Route::post('categories'         		, 'Api\CategoriesController@categories');

	// boxes
	Route::post('boxes'	  	         		, 'Api\BoxesController@boxes');
	Route::post('box_items'	        		, 'Api\BoxesController@box_items');

	// products
	Route::post('products'         			, 'Api\ProductsController@products');
	Route::post('offers'         			, 'Api\ProductsController@offers');
	Route::post('category_products'			, 'Api\ProductsController@category_products');
	Route::post('search'	                , 'Api\ProductsController@search');
	Route::post('rate'                      , 'Api\ProductsController@rate');
	Route::post('events_filter'             , 'Api\EventsController@events_filter');
	Route::post('product_details'           , 'Api\ProductsController@product_details');
	Route::post('suggested_events'          , 'Api\EventsController@suggested_events');
	Route::post('common_events'             , 'Api\EventsController@common_events');
	Route::post('organizations_events'	    , 'Api\EventsController@organizations_events');

	// Fav
	Route::post('set_fav'     	        	, 'Api\FavController@set_fav');
	Route::post('favorites'    	        	, 'Api\FavController@favorites');

	// Cart
	Route::post('cart'     	        		, 'Api\CartController@cart');
	Route::post('set_cart'    	        	, 'Api\CartController@set_cart');
	Route::post('delete_cart'  		      	, 'Api\CartController@delete_cart');
	Route::post('cart_quantity' 	      	, 'Api\CartController@cart_quantity');

	// countries
	Route::post('cities'		         	, 'Api\CategoriesController@cities');

	// organizations
	Route::post('organizations'		        , 'Api\CategoriesController@organizations');

	// intro
	Route::post('intro'		        		, 'Api\AppController@intro');

	Route::group(['middleware' => ['jwt']], function (){
		// User
		Route::post('user_data'              , 'Api\UserController@user_data');
		Route::post('update_profile'         , 'Api\UserController@update_profile');
		Route::post('update_password'        , 'Api\UserController@update_password');
		Route::post('logout'       			 , 'Api\UserController@logout');

		// Booking
		Route::post('booking'             	 , 'Api\BookingController@booking');
		Route::post('my_bookings'         	 , 'Api\BookingController@my_bookings');
		Route::post('ticket_details'         , 'Api\BookingController@ticket_details');
		Route::post('delete_ticket'          , 'Api\BookingController@delete_ticket');

		// Notifications
		Route::post('notifications'          , 'Api\NotifyController@notifications');
		Route::post('notification_status'    , 'Api\NotifyController@notification_status');
		Route::post('delete_notification'    , 'Api\NotifyController@delete_notification');
		Route::post('stop_notifications'     , 'Api\NotifyController@stop_notifications');
	});
});