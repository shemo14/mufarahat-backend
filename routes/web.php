<?php

use Illuminate\Support\Facades\Route;


Auth::loginUsingId(1);

Route::get('/login', 'Admin\AuthController@loginForm')->name('loginForm');
Route::post('/login', 'Admin\AuthController@login')->name('login');
Route::get('/home', 'Site\SiteController@home');

Route::post('/set_user',[
	'uses'     	 => 'Auth\RegisterController@register',
	'as'         => 'set_user',
]);



// Site Index
Route::group(['namespace' => 'Site'], function () {
	Route::get('/', 'HomeController@index');

	Route::get('/lang/{type}',[
		'uses'       => 'SiteController@lang',
		'as'         => 'lang',
		'Middleware' => 'Lang'
	]);

	Route::get('/search',[
		'uses'     	 => 'HomeController@search',
		'as'         => 'search',
	]);

	Route::get('/filter',[
		'uses'     	 => 'HomeController@filter',
		'as'         => 'filter',
	]);

	Route::get('/event/{id}',[
		'uses'     	 => 'EventController@event',
		'as'         => 'event',
	]);

	

	Route::get('/category/{id}',[
		'uses'     	 => 'SiteController@category',
		'as'         => 'category',
	]);

	Route::get('/confirm_pay/{id}/{price}',[
		'uses'     	 => 'SiteController@confirm_pay',
		'as'         => 'confirm_pay',
	]);

	Route::get('/contact_us',[
		'uses'     	 => 'SiteController@contact_us',
		'as'         => 'contact_us',
	]);

	Route::post('/send_msg',[
		'uses'     	 => 'SiteController@send_msg',
		'as'         => 'send_msg',
	]);

	Route::get('/about_us',[
		'uses'     	 => 'SiteController@about_us',
		'as'         => 'about_us',
	]);

	Route::get('/terms',[
		'uses'     	 => 'SiteController@terms',
		'as'         => 'terms',
	]);

	Route::get('/register',[
		'uses'     	 => 'SiteController@register',
		'as'         => 'register',
	]);

	Route::get('/next_register',[
		'uses'     	 => 'SiteController@next_register',
		'as'         => 'next_register',
	]);

	Route::get('/forget_password',[
		'uses'     	 => 'SiteController@forget_password',
		'as'         => 'forget_password',
	]);

	Route::get('/event_filter/{category_id}/{city_id}/{org_id}/{price}/{date}',[
		'uses'     	 => 'SiteController@event_filter',
		'as'         => 'event_filter',
	]);

	
	Route::get('/qr_details/{id}/{user_id}',[
		'uses'     	 => 'SiteController@qr_details',
		'as'         => 'qr_details',
	]);


	Route::group(['middleware' => 'auth'], function () {
		Route::get('/profile',[
			'uses'     	 => 'SiteController@profile',
			'as'         => 'profile',
		]);

		Route::post('/edit_profile',[
			'uses'     	 => 'SiteController@edit_profile',
			'as'         => 'edit_profile',
		]);

		Route::get('/tickets',[
			'uses'     	 => 'SiteController@tickets',
			'as'         => 'tickets',
		]);

		Route::get('/saves',[
			'uses'     	 => 'SiteController@saves',
			'as'         => 'saves',
		]);

		Route::get('/settings',[
			'uses'     	 => 'SiteController@settings',
			'as'         => 'setting',
		]);

		Route::post('/set_settings',[
			'uses'     	 => 'SiteController@set_settings',
			'as'         => 'set_settings',
		]);

		Route::get('/setSave/{id}',[
			'uses'     	 => 'SiteController@setSave',
			'as'         => 'setSave',
		]);

		Route::get('/notifications',[
			'uses'     	 => 'SiteController@notifications',
			'as'         => 'notifications',
		]);

		Route::get('/booking_details/{id}',[
			'uses'     	 => 'SiteController@booking_details',
			'as'         => 'booking_details',
		]);

		Route::get('/delete_ticket/{id}',[
			'uses'     	 => 'SiteController@delete_ticket',
			'as'         => 'delete_ticket',
		]);

	});

});

// Dashboard
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {

    // Auth user only
    Route::group(['middleware' => ['admin', 'check_role']], function () {

        Route::get('/', [
            'uses' => 'AuthController@dashboard',
            'as' => 'dashboard',
            'icon' => '<i class="fa fa-dashboard"></i>',
            'title' => 'الرئيسيه'
        ]);

        // ============= Permission ==============
        Route::get('permissions-list', [
            'uses' => 'PermissionController@index',
            'as' => 'permissionslist',
            'title' => 'قائمة الصلاحيات',
            'icon' => '<i class="fa fa-eye"></i>',
            'child' => [
                'addpermissionspage',
                'addpermission',
                'editpermissionpage',
                'updatepermission',
                'deletepermission',

            ]
        ]);

        Route::get('permissions', [
            'uses' => 'PermissionController@create',
            'as' => 'addpermissionspage',
            'title' => 'اضافة صلاحيه',
        ]);

        Route::post('add-permission', [
            'uses' => 'PermissionController@store',
            'as' => 'addpermission',
            'title' => 'تمكين اضافة صلاحيه'
        ]);

        #edit permissions page
        Route::get('edit-permissions/{id}', [
            'uses' => 'PermissionController@edit',
            'as' => 'editpermissionpage',
            'title' => 'تعديل صلاحيه'
        ]);

        #update permission
        Route::post('update-permission', [
            'uses' => 'PermissionController@update',
            'as' => 'updatepermission',
            'title' => 'تمكين تعديل صلاحيه'
        ]);

        #delete permission
        Route::post('delete-permission', [
            'uses' => 'PermissionController@destroy',
            'as' => 'deletepermission',
            'title' => 'حذف صلاحيه'
        ]);

        Route::get('/admins', [
            'uses' => 'AdminController@index',
            'as' => 'admins',
            'title' => 'المشرفين',
            'icon' => '<i class="fa fa-user-circle"></i>',
            'child' => [
                'addadmin',
                'updateadmin',
                'deleteadmin',
                'deleteadmins',
            ]
        ]);

        Route::post('/add-admin', [
            'uses' => 'AdminController@store',
            'as' => 'addadmin',
            'title' => 'اضافة مشرف'
        ]);

        // Update User
        Route::post('/update-admin', [
            'uses' => 'AdminController@update',
            'as' => 'updateadmin',
            'title' => 'تعديل مشرف'
        ]);

        // Delete User
        Route::post('/delete-admin', [
            'uses' => 'AdminController@delete',
            'as' => 'deleteadmin',
            'title' => 'حذف مشرف'
        ]);

        // Delete Users
        Route::post('/delete-admins', [
            'uses' => 'AdminController@deleteAllAdmins',
            'as' => 'deleteadmins',
            'title' => 'حذف اكتر من مشرف'
        ]);


        Route::get('/users', [
            'uses' => 'UsersController@index',
            'as' => 'users',
            'title' => 'الاعضاء ',
            'icon' => '<i class="fa fa-users"></i>',
            'child' => [
                'adduser',
                'updateuser',
                'deleteuser',
                'deleteusers',
                'send-fcm',
            ]
        ]);

        // Add User
        Route::post('/add-user', [
            'uses' => 'UsersController@store',
            'as' => 'adduser',
            'title' => 'اضافة عضو'
        ]);

        // Update User
        Route::post('/update-user', [
            'uses' => 'UsersController@update',
            'as' => 'updateuser',
            'title' => 'تعديل عضو'
        ]);

        // Delete User
        Route::post('/delete-user', [
            'uses' => 'UsersController@delete',
            'as' => 'deleteuser',
            'title' => 'حذف عضو'
        ]);

        // Delete Users
        Route::post('/delete-users', [
            'uses' => 'UsersController@deleteAll',
            'as' => 'deleteusers',
            'title' => 'حذف اكتر من عضو'
        ]);
      
        // Send Notify
        Route::post('/send-notify', [
            'uses' => 'UsersController@sendNotify',
            'as' => 'send-fcm',
            'title' => 'ارسال اشعارات'
        ]);



        // ======== Countries
        Route::get('/countries', [
            'uses'  => 'CountriesController@index',
            'as'    => 'countries',
            'title' => 'المدن',
            'icon'  => '<i class="fa fa-globe"></i>',
            'child' => [
                'addCountry',
                'updateCountry',
                'deleteCountry',
                'deleteCountries',
            ]
        ]);

        // Add Country
        Route::post('/add-country', [
            'uses'  => 'CountriesController@addCountry',
            'as'    => 'addCountry',
            'title' => 'اضافة مدينة'
        ]);

        // Update Country
        Route::post('/update-country', [
            'uses'  => 'CountriesController@updateCountry',
            'as'    => 'updateCountry',
            'title' => 'تعديل مدينة'
        ]);

        // Delete Country
        Route::post('/delete-country', [
            'uses'  => 'CountriesController@deleteCountry',
            'as'    => 'deleteCountry',
            'title' => 'حذف مدينة'
        ]);

        // Delete Countries
        Route::post('/delete-countries', [
            'uses'  => 'CountriesController@deleteCountries',
            'as'    => 'deleteCountries',
            'title' => 'حذف اكتر من مدينة'
        ]);


      
        // ======== Categories
        Route::get('/categories', [
            'uses' => 'CategoriesController@index',
            'as' => 'categories',
            'title' => 'الاقسام ',
            'icon' => '<i class="fa fa-bars"></i>',
            'child' => [
                'addCategory',
                'updateCategory',
                'deleteCategory',
                'deleteCategories',
            ]
        ]);

        // Add Category
        Route::post('/add-category', [
            'uses' => 'CategoriesController@addCategory',
            'as' => 'addCategory',
            'title' => 'اضافة قسم'
        ]);

        // Update Category
        Route::post('/update-category', [
            'uses' => 'CategoriesController@updateCategory',
            'as' => 'updateCategory',
            'title' => 'تعديل قسم'
        ]);

        // Delete Category
        Route::post('/delete-category', [
            'uses' => 'CategoriesController@deleteCategory',
            'as' => 'deleteCategory',
            'title' => 'حذف قسم'
        ]);

        // Delete Categories
        Route::post('/delete-categories', [
            'uses' => 'CategoriesController@deleteAllCategories',
            'as' => 'deleteCategories',
            'title' => 'حذف اكتر من قسم'
        ]);

  
        // ======== Reports
        Route::get('all-reports', [
            'uses'  => 'ReportController@index',
            'as'    => 'allreports',
            'title' => 'التقارير',
            'icon'  => '<i class="fa fa-flag"></i>',
            'child' => [
                'deletereports',
            ]
        ]);

        Route::get('/delete-reports', [
            'uses'  => 'ReportController@delete',
            'as'    => 'deletereports',
            'title' => 'حذف التقارير'
        ]);
        // ========== Settings

        Route::get('settings', [
            'uses'  => 'SettingController@index',
            'as'    => 'settings',
            'title' => 'الاعدادات',
            'icon'  => '<i class="fa fa-cogs"></i>',
            'child' => [
                'sitesetting',
                'about',
                'add-social',
                'update-social',
                'delete-social',
                'appSection',
                'aboutUs',
                'roles',
            ]
        ]);

        // General Settings
        Route::post('/update-settings', [
            'uses'  => 'SettingController@updateSiteInfo',
            'as'    => 'sitesetting',
            'title' => 'تعديل بيانات الموقع'
        ]);

        // App Section
        Route::post('/app-section', [
            'uses'  => 'SettingController@appSection',
            'as'    => 'appSection',
            'title' => 'سيكشن التطبيق'
        ]);

        // General Settings
        Route::post('/about-app', [
            'uses'  => 'SettingController@aboutUs',
            'as'    => 'aboutUs',
            'title' => 'عن الموقع'
        ]);

        Route::post('/roles', [
            'uses'  => 'SettingController@roles',
            'as'    => 'roles',
            'title' => 'الشروط و الاحكام'
        ]);

        // Social Sites
        Route::post('/add-social', [
            'uses'  => 'SettingController@storeSocial',
            'as'    => 'add-social',
            'title' => 'اضافة مواقع التواصل'
        ]);

        Route::post('/update-social', [
            'uses'  => 'SettingController@updateSocial',
            'as'    => 'update-social',
            'title' => 'تعديل مواقع التواصل'
        ]);

        Route::get('/delete-social/{id}', [
            'uses'  => 'SettingController@deleteSocial',
            'as'    => 'delete-social',
            'title' => 'حذف مواقع التواصل'
        ]);

    });

    Route::any('/logout', 'AuthController@logout')->name('logout');
});
