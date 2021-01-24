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

// Route::get('/', function () {
//     return view('welcome');
// });




    
Route::namespace('Admin')->prefix('admin')->group(function () {
    Route::get('login','UserController@index')->name('login');
    Route::post('check_user','UserController@login');
    Route::get('term','UserController@term');
    Route::get('privacy','UserController@privacy');
    
    Route::middleware(['auth'])->group(function () {
        Route::get('dashboard','DashboardController@index');
        Route::get('viewPayment','PaymentController@viewPayment');
        Route::get('logout','UserController@logout');
        Route::get('users','UserController@users');
        Route::get('group','UserController@group');
        Route::get('patientInformation','UserController@patientInformation');
        
        //Route::get('viewUser/{id}','UserController@viewUser');
        Route::get('/viewUser/{id}',['as'=>'viewUser', 'uses' => 'UserController@viewUser']);
        Route::get('/trustedDoctor/{id}',['as'=>'trustedDoctor', 'uses' => 'UserController@trustedDoctor']);
        
        Route::get('/paidChatDoctor/{id}',['as'=>'paidChatDoctor', 'uses' => 'UserController@paidChatDoctor']);
        

        Route::get('/viewTransaction/{id}',['as'=>'viewTransaction', 'uses' => 'PaymentController@viewTransaction']);
        
        Route::get('/changeStatus/{id}',['as'=>'changeStatus', 'uses' => 'PaymentController@changeStatus']);
         
        
        Route::get('/user/block',['as'=>'block_user','uses' => 'UserController@block_user']);
        Route::get('/user/approved',['as'=>'block_users','uses' => 'UserController@approved']);
        Route::get('/user/delete',['as'=>'delete_user','uses' => 'UserController@delete_user']);

        //Doctors
        Route::get('doctors','DoctorsController@index');
        //approveddoctors
        Route::get('presentation','UserController@presentation');
        
        Route::get('viewDoctors','DoctorsController@viewDoctors');
        Route::get('approveddoctors','DoctorsController@approveddoctors');
        Route::get('adddoctors','DoctorsController@add');

      //Group
        Route::get('addGroup','UserController@addGroup');
        Route::post('updateGroup','UserController@updateGroup');
        Route::post('createGroup','UserController@createGroup');
        Route::get('viewadministrator','UserController@viewadministrator');
        Route::get('viewcollaborators','UserController@viewcollaborators');
        Route::get('viewowner','UserController@viewowner');
        Route::get('add_owner','UserController@add_owner');
        Route::post('createowner','UserController@createowner');
        
        

       Route::get('/viewGroup/{id}',['as'=>'viewGroup', 'uses' => 'UserController@editGroup']);


       //inventory
       Route::get('inventory','InventoryController@inventory');
       Route::get('addInventory','InventoryController@addInventory');
       Route::post('createInventory','InventoryController@createInventory');
       Route::get('/user/inventory', ['as' => 'get_inventory', 'uses' => 'InventoryController@get_inventory']);
        //Route::get('/hide/{id}',['as'=>'hide', 'uses' => 'InventoryController@hide']);
        Route::get('/user/hide',['as'=>'hide','uses' => 'InventoryController@hide']);

        //Bulding Floor

    Route::get('add_building','BuildingController@create_building');
    Route::post('store_building','BuildingController@store_building');
    Route::get('building_list','BuildingController@building_listing');
    Route::get('building_edit/{id}','BuildingController@building_edit');
    Route::post('building_edit/{id}','BuildingController@building_edit_update');
    Route::get('delete_building/{id}','BuildingController@delete_building');
    Route::get('add_floor_details/{id}','BuildingController@add_floor_details');
    Route::post('store_floor_details','BuildingController@store_floor_details');
    Route::get('floor_listing/{id}','BuildingController@floor_listing');
    Route::get('building_floor_listing','BuildingController@building_floor_listing');
        
    //Vendor

    Route::resource('vendor', 'VendorController');
    Route::post('vendor/{id}/update', ['as' => 'kitchen.update', 'uses' => 'VendorController@update']);
    Route::get('vendor/{id}/delete', ['as' => 'kitchen.delete', 'uses' => 'VendorController@destroy']);
    Route::get('vendor/random/image', ['as' => 'kitchen.image', 'uses' => 'VendorController@clickImage']);
    Route::get('vendor/random/data', function(){
        echo "Some Random Data";
    });




 
   //Space Type

    Route::resource('spacetype','SpaceTypeController');
    Route::post('spacetype/{id}/update', ['as' => 'spacetype.update', 'uses' => 'SpaceTypeController@update']);
    Route::get('spacetype/{id}/delete', ['as' => 'spacetype.delete', 'uses' => 'SpaceTypeController@destroy']);
       
   //Food Item

   Route::resource('food_item','FoodItemController');   
   Route::resource('space_details','SpaceController');
   Route::get('space_details/create/{building_id}/{floor_id}', ['as' => 'space_details.create', 'uses' => 'SpaceController@create']);
  
    Route::resource('food_ordering','FoodOrdering');
    Route::get('food_ordering/add_to_cart/{id}', ['as' => 'food_ordering.add_to_cart', 'uses' => 'FoodOrdering@add_to_cart']);
    Route::get('food_ordering/category_item/{id}', ['as' => 'food_ordering.category_item', 'uses' => 'FoodOrdering@category_item']);
    
    Route::get('food_ordering/cart/checkout', ['as' => 'food_ordering.cart', 'uses' => 'FoodOrdering@cart']);
    Route::patch('food_ordering/cart/update-cart', ['as' => 'food_ordering.update-cart', 'uses' => 'FoodOrdering@update_cart']);
    Route::delete('food_ordering/cart/remove-from-cart', ['as' => 'food_ordering.remove-from-cart', 'uses' => 'FoodOrdering@remove']);
    



    });
});

Route::namespace('Web')->group(function () {
    Route::get('/','HomeController@index')->name('home');
    Route::resource('login','LoginController');
    //Route::namespace('Owner')->prefix('admin')->group(function () {
    Route::get('owner/userlist','UserController@userlist');
    Route::post('owner/createUser','UserController@createUser');
    Route::get('owner/signin','UserController@signin');
    Route::post('loginUser','UserController@loginUser');
    
    Route::get('logout','UserController@logout');
    //Collaborations
    Route::get('collaborator/signin','CollaboratorController@collaborator_signin');
    Route::post('collaborator/loginCollaorator','CollaboratorController@loginCollaorator');
    Route::get('collaborator','CollaboratorController@index');
    
    //Aminstrator
   Route::get('administrator/signin','AdministratorController@administrator_signin');
   Route::post('administrator/loginAdministrator','AdministratorController@loginAdministrator');
   Route::get('administrator','AdministratorController@index');

    //});
     });