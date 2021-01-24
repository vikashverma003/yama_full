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

Route::get('get-user-details', function (Request $request) {
  
      return ['status' => 200, 'user' => $request->user() ];
})->middleware('auth:api');

Route::namespace('Api')->group(function () {
     
     Route::post('login', 'UserController@login');
     Route::post('signup', 'UserController@signup');
     Route::get('locations','UserController@locations');
     Route::post('verifyOtp', 'UserController@verifyOtp');
     Route::post('updatePasword', 'UserController@updatePasword');
    //Route::post('basicInfo', 'UserController@basicInfo');
     Route::post('forgotPasword', 'UserController@forgotPasword');
     Route::post('verifyforgotOtp', 'UserController@verifyforgotOtp');
     Route::post('changePassword', 'UserController@changePassword');


     Route::post('getServices', 'UserController@getServices');
     Route::post('getpresentation', 'UserController@getpresentation');

     Route::middleware(['auth:api'])->group(function () {
     Route::post('logout', 'UserController@logout');
     Route::post('basicInfo', 'UserController@basicInfo');
     Route::post('verifyImage', 'UserController@verifyImage');
     Route::post('patientProfileInfo', 'UserController@patientProfileInfo');
     Route::post('editProfile', 'UserController@editProfile');
     Route::post('freeChatDoctor', 'UserController@freeChatDoctor');
     Route::post('signleDoctorRequest', 'UserController@signleDoctorRequest');
     Route::post('editResedentialinfo', 'UserController@editResedentialinfo');

     Route::post('reciveRequest', 'UserController@reciveRequest');
     Route::post('requestStatus', 'UserController@requestStatus');
     Route::post('rejectStatus', 'UserController@rejectStatus');
     //Display Doctor Info After sending request to doctor
     Route::post('requestWaiting', 'UserController@requestWaiting');
     Route::post('skip', 'UserController@skip');
     //Chat Processs patient or Doctor
     
    Route::post('send-message', 'ChatController@sendChatMessage');
    Route::post('send-chat-message', 'ChatController@sendMessage');
    Route::get('get-conversations', 'ChatController@allConversations');
    Route::post('get-conversation-id', 'ChatController@ConversationId');
    Route::post('get-chat-messages', 'ChatController@allMessages');
    Route::post('init-chat', 'ChatController@initChat');
    Route::post('chatList', 'ChatController@chatList');
    Route::post('endChat', 'ChatController@endChat');

    Route::post('getDoctorchat', 'UserController@getDoctorchat');

    //Medicen recomend
    Route::post('medicineRecomend', 'DoctorsController@medicineRecomend');

    Route::post('editEedicineRecomend','DoctorsController@editEedicineRecomend');
    
    Route::post('getMedicine', 'DoctorsController@getMedicine'); 
    Route::post('chatHistorty', 'ChatController@chatHistorty');
    Route::post('addTrusted', 'UserController@addTrusted');
    Route::post('removeTrusted', 'UserController@removeTrusted');
    Route::post('trustedList', 'DoctorsController@trustedList');
    Route::post('recommendedMedications', 'DoctorsController@recommendedMedications');
    Route::post('recommendedMedicationsInfo','DoctorsController@recommendedMedicationsInfo');
          
    Route::post('vinkuproList', 'DoctorsController@vinkuproList');
    Route::post('doctorList', 'DoctorsController@doctorList');
    Route::post('singleDoctorInfo', 'DoctorsController@singleDoctorInfo');

    Route::post('ongoningCall', 'UserController@ongoningCall');
    Route::post('PatientongoningCall','UserController@PatientongoningCall');
    
    Route::post('ongoningChat', 'UserController@ongoningChat');
    Route::post('medical_advice', 'UserController@medical_advice');

    Route::post('patientTrusted', 'UserController@patientTrusted');

    Route::post('doctorChatHistory', 'UserController@doctorChatHistory');


    
   //Assign Rating to doctor
    Route::post('patientrating', 'UserController@patientrating'); //Giving rating to doctor
    Route::post('doctorrating', 'UserController@doctorrating'); //Giving rating to patient
    Route::get('getVideo','UserController@getVideo');
    Route::post('getPermotions','UserController@getPermotions');

    Route::get('notification','UserController@notification');
    Route::post('allmedicine','UserController@allmedicine');
    Route::post('medicalInfoEdit','UserController@medicalInfoEdit');
    Route::post('editAccountInfo','UserController@editAccountInfo');
    Route::post('consultationStatus','UserController@consultationStatus');
    Route::post('homeDashboard','UserController@homeDashboard');
    Route::post('deleteRequest','UserController@deleteRequest');
    Route::post('getroot','UserController@getroot');
    Route::post('totalearning','UserController@totalearning');
    Route::post('medicationReminder','UserController@medicationReminder');

    Route::post('addCard','UserController@addCard');
    Route::post('getCard','UserController@getCard');
    Route::post('createPayment','PaymentController@createPayment');
    
    Route::post('active_card','UserController@active_card');
    Route::post('patientPaymentHistory','PaymentController@patientPaymentHistory');

    Route::post('send_sms','UserController@send_sms');
    Route::post('updateSuperKids','UserController@updateSuperKids');
    Route::post('sameTime','UserController@sameTime');

    Route::get('getDoctorList','DoctorsController@getDoctorList');

    Route::post('updateMedicationTime','DoctorsController@updateMedicationTime');

    Route::get('getInfos','DoctorsController@getInfos');

    
    
     
     });
});