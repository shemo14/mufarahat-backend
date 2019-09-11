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
    });
// #Site Index

// Dashboard
    Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {

    // Auth user only
        Route::group(['middleware' => ['admin', 'check_role']], function () {
        // ============= home ==============
            Route::get('/', [
                'uses' => 'AuthController@dashboard',
                'as' => 'dashboard',
                'icon' => '<i class="fa fa-dashboard"></i>',
                'title' => 'الرئيسيه'
            ]);
        // ============= #home ==============

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
        // ============= #Permission ==============

        // ============= Cities ==============
            Route::get('cities-list', [
                'uses' => 'CitiesController@index',
                'as' => 'cities',
                'title' => 'المدن',
                'icon' => '<i class="fa fa-city"></i>',
                'child' => [
                    'addcity',
                    'editcity',
                    'deletecity',
                ]
            ]);

                // Add User
                Route::post('/add-city', [
                'uses' => 'CitiesController@store',
                'as' => 'addcity',
                'title' => 'اضافة مدينه'
            ]);

            // Update User
            Route::post('/update-city', [
                'uses' => 'CitiesController@update',
                'as' => 'editcity',
                'title' => 'تعديل مدينه'
            ]);

            // Delete User
            Route::post('/delete-city', [
                'uses' => 'CitiesController@delete',
                'as' => 'deletecity',
                'title' => 'حذف مدينه'
            ]);
        // ============= #Cities ==============

        // ============= warehouses ==============
            Route::get('warehouses-list', [
                'uses' => 'WarehousesController@index',
                'as' => 'warehouses',
                'title' => 'المستودعات',
                'icon' => '<i class="fa fa-city"></i>',
                'child' => [
                    'addwarehouse',
                    'editwarehouse',
                    'deletewarehouse',
                ]
            ]);

                // Add User
                Route::post('/add-warehouse', [
                'uses' => 'WarehousesController@store',
                'as' => 'addwarehouse',
                'title' => 'اضافة مستودع'
            ]);

            // Update User
            Route::post('/update-warehouse', [
                'uses' => 'WarehousesController@update',
                'as' => 'editwarehouse',
                'title' => 'تعديل مستودع'
            ]);

            // Delete User
            Route::post('/delete-warehouse', [
                'uses' => 'WarehousesController@delete',
                'as' => 'deletewarehouse',
                'title' => 'حذف مستودع'
            ]);
        // ============= #warehouses ==============

        // ============= المستخدمين ==============
            Route::get('/all-users2',[
                'uses'     =>'UsersController@index',
                'as'       =>'users2',
                'title'    =>'الاعضاء ',
                'subTitle' =>'المناديب',
                'subIcon'  =>'<i class="glyphicon glyphicon-film"></i>',
                'icon'     =>'<i class="fa fa-users"></i>',
                'child'    => [
                    'admins',
                    'addadmin',
                    'updateadmin',
                    'deleteadmin',
                    'deleteadmins',
                    'users',
                    'adduser',
                    'updateuser',
                    'deleteuser',
                    'deleteusers',
                    'send-fcm',
                    'delegates',
                    'adddelegate',
                    'editdelegate',
                    'deletedelegate',
                    'deletedelegates',
                ]
            ]);

            // ============= Admins ==============
                Route::get('/admins',[
                    'uses'=>'AdminController@index',
                    'as'=>'admins',
                    'icon'      =>'<i class="fa fa-user-circle"></i>',
                    'title'    => 'المشرفين',
                    'hasFather' =>true
                ]);

                Route::post('/add-admin', [
                    'uses' => 'AdminController@store',
                    'as' => 'addadmin',
                    'title' => 'اضافة مشرف'
                ]);

                // Update Admin
                Route::post('/update-admin', [
                    'uses' => 'AdminController@update',
                    'as' => 'updateadmin',
                    'title' => 'تعديل مشرف'
                ]);

                // Delete Admin
                Route::post('/delete-admin', [
                    'uses' => 'AdminController@delete',
                    'as' => 'deleteadmin',
                    'title' => 'حذف مشرف'
                ]);

                // Delete Admin
                Route::post('/delete-admins', [
                    'uses' => 'AdminController@deleteAllAdmins',
                    'as' => 'deleteadmins',
                    'title' => 'حذف اكتر من مشرف'
                ]);
            // ============= #Admins ==============

            // ============= users ==============
                Route::get('/users',[
                    'uses'=>'UsersController@index',
                    'as'=>'users',
                    'icon'      =>'<i class="fa fa-users"></i>',
                    'title'    => 'المستخدمين',
                    'hasFather' =>true
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
            // ============= #users ==============

            // ============= Delgates ==============
                Route::get('/delegates',[
                    'uses'=>'DelegateController@index',
                    'as'=>'delegates',
                    'icon'      =>'<i class="fa fa-users"></i>',
                    'title'    => 'المناديب',
                    'hasFather' =>true
                ]);

                // Add User
                Route::post('/add-delegate', [
                    'uses' => 'DelegateController@store',
                    'as' => 'adddelegate',
                    'title' => 'اضافة مندوب'
                ]);

                // Update User
                Route::post('/update-delegate', [
                    'uses' => 'DelegateController@update',
                    'as' => 'editdelegate',
                    'title' => 'تعديل مندوب'
                ]);

                // Delete User
                Route::post('/delete-delegate', [
                    'uses' => 'DelegateController@delete',
                    'as' => 'deletedelegate',
                    'title' => 'حذف مندوب'
                ]);

                // Delete Users
                Route::post('/delete-delegates', [
                    'uses' => 'DelegateController@deleteAll',
                    'as' => 'deletedelegates',
                    'title' => 'حذف اكتر من مندوب'
                ]);

            
           // ============= #Delgates ==============
            
            
        // ============= #المستخدمين ==============

        // ============= Categories ==============
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
        // ============= #Categories ==============

        // ============= Products ==============
            Route::get('/products', [
                'uses' => 'ProductsController@index',
                'as' => 'products',
                'title' => 'المنتجات ',
                'icon' => '<i class="fa fa-product-hunt"></i>',
                'child' => [
                    'addProduct',
                    'updateProduct',
                    'deleteProduct',
                    'deleteProducts',
                    'deleteImg',
                ]
            ]);

            // Add product
            Route::post('/add-product', [
                'uses' => 'ProductsController@store',
                'as' => 'addProduct',
                'title' => 'اضافة منتج'
            ]);

            // Update product
            Route::post('/update-product', [
                'uses' => 'ProductsController@update',
                'as' => 'updateProduct',
                'title' => 'تعديل منتج'
            ]);

            // Delete product
            Route::get('/delete-image/{id}', [
                'uses' => 'ProductsController@deleteImg',
                'as' => 'deleteImg',
                'title' => 'حذف صور المنتجات'
            ]);

            // Delete product
            Route::post('/delete-product', [
                'uses' => 'ProductsController@delete',
                'as' => 'deleteProduct',
                'title' => 'حذف منتج'
            ]);

            // // Delete products
            // Route::post('/delete-products', [
            //     'uses' => 'CategoriesController@deleteAllCategories',
            //     'as' => 'deleteProducts',
            //     'title' => 'حذف اكتر من منتج'
            // ]);
        // ============= #Products ==============

        // ============= Comman QUS ==============
			// ======= Comman QUS
			Route::get('/common-qus', [
				'uses' => 'QUAnsController@index',
				'as' => 'commonQus',
				'title' => 'الاسئلة الشائعة ',
				'icon' => '<i class="fa fa-question-circle-o"></i>',
				'child' => [
					'addQU',
					'updateQU',
					'deleteQU',
					'deleteQus',
				]
			]);

			// Add Qu
			Route::post('/add-qu', [
				'uses' => 'QUAnsController@addQU',
				'as' => 'addQU',
				'title' => 'اضافة سؤال'
			]);

			// Update Qu
			Route::post('/update-qu', [
				'uses' => 'QUAnsController@updateQU',
				'as' => 'updateQU',
				'title' => 'تعديل سؤال'
			]);

			// Delete Qu
			Route::post('/delete-qu', [
				'uses' => 'QUAnsController@deleteQU',
				'as' => 'deleteQU',
				'title' => 'حذف سؤال'
			]);

			// Delete Qus
			Route::post('/delete-qus', [
				'uses' => 'QUAnsController@deleteQus',
				'as' => 'deleteQus',
				'title' => 'حذف اكتر من سؤال'
			]);
        // ============= #Comman QUS ==============

        // ============= Reports ==============
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
        // ============= #Reports ==============
        
        // ============= Settings ==============
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
        // ============= #Settings ==============

        });
    // #Auth user only

        Route::any('/logout', 'AuthController@logout')->name('logout');
    });
// #Dashboard

