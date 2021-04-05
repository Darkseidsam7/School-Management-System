<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// Web Site
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Console\MakeControllerCommand;
use Illuminate\Routing\Controller;

Route::get('/api/csrf', function() {
    return Session::token();
});

Route::group(array('before'=>'api.csrf'),function(){
	Route::get('/upgrade','upgradeController@index');
	Route::post('/upgrade','upgradeController@proceed');

	Route::get('/install','InstallController@index');
	Route::post('/install','InstallController@proceed');

	Route::get('/login','LoginController@index');
	Route::post('/login','LoginController@attemp');
	Route::get('/logout','LoginController@logout');

	Route::get('/forgetpwd','LoginController@forgetpwd');
	Route::post('/forgetpwd','LoginController@forgetpwdStepOne');
	Route::get('/forgetpwd/{uniqid}','LoginController@forgetpwdStepTwo');
	Route::post('/forgetpwd/{uniqid}','LoginController@forgetpwdStepTwo');

	Route::get('/register/classes','LoginController@registerClasses');
	Route::get('/register/searchStudents/{student}','LoginController@searchStudents');
	Route::get('/register','LoginController@register');
	Route::post('/register','LoginController@registerPost');

	Route::get('/terms','LoginController@terms');
});

// Dashboard
Route::group(array('prefix'=>'/','before'=>'auth|api.csrf'),function(){
	Route::get('/','DashboardController@index');

	Route::get('/dashboard','DashboardController@dashboardData');
	Route::get('/dashboard/baseUser','DashboardController@baseUser');
	Route::get('/calender','DashboardController@calender');
	Route::post('/dashboard/polls','DashboardController@savePolls');
	Route::get('/uploads/{section}/{image}','DashboardController@image');
	
	//Languages & phrases
	Route::get('/languages','LanguagesController@index');
	Route::get('/languages/listAll','LanguagesController@listAll');
	Route::delete('/languages/{id}','LanguagesController@delete');
	Route::post('/languages','LanguagesController@create');
	Route::get('/languages/{id}','LanguagesController@fetch');
	Route::post('/languages/{id}','LanguagesController@edit');

	//Dormitories
	Route::get('/dormitories','DormitoriesController@index');
	Route::get('/dormitories/listAll','DormitoriesController@listAll');
	Route::delete('/dormitories/{id}','DormitoriesController@delete');
	Route::post('/dormitories','DormitoriesController@create');
	Route::get('/dormitories/{id}','DormitoriesController@fetch');
	Route::post('/dormitories/{id}','DormitoriesController@edit');

	//Admins
	Route::get('/admins','AdminsController@index');
	Route::get('/admins/listAll','AdminsController@listAll');
	Route::delete('/admins/{id}','AdminsController@delete');
	Route::post('/admins','AdminsController@create');
	Route::get('/admins/{id}','AdminsController@fetch');
	Route::post('/admins/{id}','AdminsController@edit');

	//Teachers
	Route::get('/teachers','TeachersController@index');
	Route::post('/teachers/import/{type}','TeachersController@import');
	Route::get('/teachers/export','TeachersController@export');
	Route::get('/teachers/exportpdf','TeachersController@exportpdf');
	Route::get('/teachers/exportcsv','TeachersController@exportcsv');
	Route::post('/teachers/upload','TeachersController@uploadFile');
	Route::get('/teachers/waitingApproval','TeachersController@waitingApproval');
	Route::post('/teachers/leaderBoard/{id}','TeachersController@leaderboard');
	Route::post('/teachers/approveOne/{id}','TeachersController@approveOne');
	Route::get('/teachers/profile/{id}','TeachersController@profile');
	Route::get('/teachers/listAll','TeachersController@listAll');
	Route::get('/teachers/listAll/{page}','TeachersController@listAll');
	Route::delete('/teachers/{id}','TeachersController@delete');
	Route::post('/teachers','TeachersController@create');
	Route::get('/teachers/{id}','TeachersController@fetch');
	Route::post('/teachers/{id}','TeachersController@edit');

	//Students
	Route::get('/students','StudentsController@index');
	Route::post('/students/import/{type}','StudentsController@import');
	Route::get('/students/export','StudentsController@export');
	Route::get('/students/exportpdf','StudentsController@exportpdf');
	Route::get('/students/exportcsv','StudentsController@exportcsv');
	Route::post('/students/upload','StudentsController@uploadFile');
	Route::get('/students/waitingApproval','StudentsController@waitingApproval');
	Route::post('/students/approveOne/{id}','StudentsController@approveOne');
	Route::get('/students/marksheet/{id}','StudentsController@marksheet');
	Route::get('/students/attendance/{id}','StudentsController@attendance');
	Route::get('/students/profile/{id}','StudentsController@profile');
	Route::post('/students/leaderBoard/{id}','StudentsController@leaderboard');
	Route::get('/students/listAll','StudentsController@listAll');
	Route::get('/students/listAll/{page}','StudentsController@listAll');
	Route::delete('/students/{id}','StudentsController@delete');
	Route::post('/students','StudentsController@create');
	Route::get('/students/{id}','StudentsController@fetch');
	Route::post('/students/{id}','StudentsController@edit');

	//Parents
	Route::get('/parents/search/{student}','ParentsController@searchStudents');
	Route::get('/parents/export','ParentsController@export');
	Route::get('/parents/exportpdf','ParentsController@exportpdf');
	Route::get('/parents/exportcsv','ParentsController@exportcsv');
	Route::get('/parents','ParentsController@index');
	Route::post('/parents/upload','ParentsController@uploadFile');
	Route::get('/parents/waitingApproval','ParentsController@waitingApproval');
	Route::get('/parents/profile/{id}','ParentsController@profile');
	Route::post('/parents/approveOne/{id}','ParentsController@approveOne');
	Route::get('/parents/listAll','ParentsController@listAll');
	Route::get('/parents/listAll/{page}','ParentsController@listAll');
	Route::delete('/parents/{id}','ParentsController@delete');
	Route::post('/parents','ParentsController@create');
	Route::get('/parents/{id}','ParentsController@fetch');
	Route::post('/parents/{id}','ParentsController@edit');

	//Classes
	Route::get('/classes','ClassesController@index');
	Route::get('/classes/listAll','ClassesController@listAll');
	Route::delete('/classes/{id}','ClassesController@delete');
	Route::post('/classes','ClassesController@create');
	Route::get('/classes/{id}','ClassesController@fetch');
	Route::post('/classes/{id}','ClassesController@edit');

	//subjects
	Route::get('/subjects','SubjectsController@index');
	Route::get('/subjects/listAll','SubjectsController@listAll');
	Route::delete('/subjects/{id}','SubjectsController@delete');
	Route::post('/subjects','SubjectsController@create');
	Route::get('/subjects/{id}','SubjectsController@fetch');
	Route::post('/subjects/{id}','SubjectsController@edit');

	//NewsBoardass
	Route::get('/newsboard','NewsBoardController@index');
	Route::get('/newsboard/listAll/{page}','NewsBoardController@listAll');
	Route::delete('/newsboard/{id}','NewsBoardController@delete');
	Route::post('/newsboard','NewsBoardController@create');
	Route::get('/newsboard/{id}','NewsBoardController@fetch');
	Route::post('/newsboard/{id}','NewsBoardController@edit');

	//Library
	Route::get('/library','LibraryController@index');
	Route::get('/library/listAll','LibraryController@listAll');
	Route::get('/library/listAll/{page}','LibraryController@listAll');
	Route::delete('/library/{id}','LibraryController@delete');
	Route::post('/library','LibraryController@create');
	Route::get('/library/{id}','LibraryController@fetch');
	Route::post('/library/{id}','LibraryController@edit');

	//Account Settings
	Route::get('/accountSettings','AccountSettingsController@index');
	Route::get('/accountSettings/langs','AccountSettingsController@langs');
	Route::get('/accountSettings/data','AccountSettingsController@listAll');
	Route::post('/accountSettings/profile','AccountSettingsController@saveProfile');
	Route::post('/accountSettings/email','AccountSettingsController@saveEmail');
	Route::post('/accountSettings/password','AccountSettingsController@savePassword');

	//Class Schedule
	Route::get('/classschedule','ClassScheduleController@index');
	Route::get('/classschedule/listAll','ClassScheduleController@listAll');
	Route::get('/classschedule/{id}','ClassScheduleController@fetch');
	Route::get('/classschedule/sub/{id}','ClassScheduleController@fetchSub');
	Route::post('/classschedule/sub/{id}','ClassScheduleController@editSub');
	Route::post('/classschedule/{id}','ClassScheduleController@addSub');
	Route::delete('/classschedule/{class}/{id}','ClassScheduleController@delete');
	
	//Site Settings
	Route::get('/siteSettings/langs','SiteSettingsController@langs');
	Route::get('/siteSettings/{title}','SiteSettingsController@listAll');
	Route::post('/siteSettings/{title}','SiteSettingsController@save');

	//Attendance
	Route::get('/attendance','AttendanceController@listAll');
	Route::post('/attendance/list','AttendanceController@listAttendance');
	Route::post('/attendance','AttendanceController@saveAttendance');
	Route::get('/attendance/stats','AttendanceController@getStats');
	Route::get('/attendance/stats/{date}','AttendanceController@getStats');
	Route::post('/attendance/stats','AttendanceController@search');
	
	//Grade Levels
	Route::get('/gradeLevels','GradeLevelsController@index');
	Route::get('/gradeLevels/listAll','GradeLevelsController@listAll');
	Route::delete('/gradeLevels/{id}','GradeLevelsController@delete');
	Route::post('/gradeLevels','GradeLevelsController@create');
	Route::get('/gradeLevels/{id}','GradeLevelsController@fetch');
	Route::post('/gradeLevels/{id}','GradeLevelsController@edit');
	
	//Exams List
	Route::get('/examsList','ExamsListController@index');
	Route::get('/examsList/listAll','ExamsListController@listAll');
	Route::post('/examsList/notify/{id}','ExamsListController@notifications');
	Route::delete('/examsList/{id}','ExamsListController@delete');
	Route::post('/examsList','ExamsListController@create');
	Route::get('/examsList/{id}','ExamsListController@fetch');
	Route::post('/examsList/{id}','ExamsListController@edit');
	Route::get('/examsList/getMarks/{exam}/{class}/{subject}','ExamsListController@fetchMarks');
	Route::post('/examsList/saveMarks/{exam}/{class}/{subject}','ExamsListController@saveMarks');	

	//Events
	Route::get('/events','EventsController@index');
	Route::get('/events/listAll','EventsController@listAll');
	Route::delete('/events/{id}','EventsController@delete');
	Route::post('/events','EventsController@create');
	Route::get('/events/{id}','EventsController@fetch');
	Route::post('/events/{id}','EventsController@edit');

	//Assignments
	Route::get('/assignments','AssignmentsController@index');
	Route::get('/assignments/listAll','AssignmentsController@listAll');
	Route::delete('/assignments/{id}','AssignmentsController@delete');
	Route::post('/assignments','AssignmentsController@create');
	Route::get('/assignments/{id}','AssignmentsController@fetch');
	Route::post('/assignments/{id}','AssignmentsController@edit');

	//Mail / SMS
	Route::get('/mailsms','MailSmsController@index');
	Route::get('/mailsms/listAll','MailSmsController@listAll');
	Route::post('/mailsms','MailSmsController@create');
	Route::get('/mailsms/settings','MailSmsController@settings');
	Route::post('/mailsms/settings','MailSmsController@settingsSave');

	//Messages
	Route::get('/messages','MessagesController@index');
	Route::post('/messages','MessagesController@create');
	Route::get('/messages/listAll/{page}','MessagesController@listMessages');
	Route::post('/messages/read','MessagesController@read');
	Route::post('/messages/unread','MessagesController@unread');
	Route::post('/messages/delete','MessagesController@delete');
	Route::get('/messages/{id}','MessagesController@fetch');
	Route::post('/messages/{id}','MessagesController@reply');
	Route::get('/messages/ajax/{from}/{to}/{before}','MessagesController@ajax');
	Route::get('/messages/before/{from}/{to}/{before}','MessagesController@before');

	//Online Exams
	Route::get('/onlineExams','OnlineExamsController@index');
	Route::get('/onlineExams/listAll','OnlineExamsController@listAll');
	Route::post('/onlineExams/took/{id}','OnlineExamsController@took');
	Route::get('/onlineExams/marks/{id}','OnlineExamsController@marks');
	Route::get('/onlineExams/export/{id}/{type}','OnlineExamsController@export');
	Route::delete('/onlineExams/{id}','OnlineExamsController@delete');
	Route::post('/onlineExams','OnlineExamsController@create');
	Route::get('/onlineExams/{id}','OnlineExamsController@fetch');
	Route::post('/onlineExams/{id}','OnlineExamsController@edit');

	//Transportation
	Route::get('/transports','TransportsController@index');
	Route::get('/transports/listAll','TransportsController@listAll');
	Route::get('/transports/list/{id}','TransportsController@fetchSubs');
	Route::delete('/transports/{id}','TransportsController@delete');
	Route::post('/transports','TransportsController@create');
	Route::get('/transports/{id}','TransportsController@fetch');
	Route::post('/transports/{id}','TransportsController@edit');

	//Media
	Route::get('/media','MediaController@index');
	Route::get('/media/listAll','MediaController@listAlbum');
	Route::get('/media/listAll/{id}','MediaController@listAlbumById');
	Route::get('/media/resize/{file}/{width}/{height}','MediaController@resize');
	
	Route::post('/media/newAlbum','MediaController@newAlbum');
	Route::delete('/media/album/{id}','MediaController@deleteAlbum');
	Route::get('/media/editAlbum/{id}','MediaController@fetchAlbum');
	Route::post('/media/editAlbum/{id}','MediaController@editAlbum');
	
	Route::post('/media','MediaController@create');

	Route::get('/media/{id}','MediaController@fetch');
	Route::post('/media/{id}','MediaController@edit');
	Route::delete('/media/{id}','MediaController@delete');

	//Static pages
	Route::get('/static','StaticPagesController@index');
	Route::get('/static/listAll','StaticPagesController@listAll');
	Route::get('/static/active/{id}','StaticPagesController@active');
	Route::delete('/static/{id}','StaticPagesController@delete');
	Route::post('/static','StaticPagesController@create');
	Route::get('/static/{id}','StaticPagesController@fetch');
	Route::post('/static/{id}','StaticPagesController@edit');

	//Polls
	Route::get('/polls','PollsController@index');
	Route::get('/polls/listAll','PollsController@listAll');
	Route::post('/polls/active/{id}','PollsController@makeActive');
	Route::delete('/polls/{id}','PollsController@delete');
	Route::post('/polls','PollsController@create');
	Route::get('/polls/{id}','PollsController@fetch');
	Route::post('/polls/{id}','PollsController@edit');

	//Mail / SMS Templates
	Route::get('/mailSMSTemplates','MailSMSTemplatesController@index');
	Route::get('/MailSMSTemplates/listAll','MailSMSTemplatesController@listAll');
	Route::get('/MailSMSTemplates/{id}','MailSMSTemplatesController@fetch');
	Route::post('/MailSMSTemplates/{id}','MailSMSTemplatesController@edit');

	//Payments
	Route::get('/payments','PaymentsController@index');
	Route::get('/payments/listAll','PaymentsController@listAll');
	Route::get('/payments/failed','PaymentsController@paymentFailed');
	Route::get('/payments/invoice/{id}','PaymentsController@invoice');
	Route::get('/payments/export/{id}','PaymentsController@export');
	Route::get('/payments/details/{id}','PaymentsController@PaymentData');
	Route::delete('/payments/{id}','PaymentsController@delete');
	Route::post('/payments','PaymentsController@create');
	Route::get('/payments/{id}','PaymentsController@fetch');
	Route::post('/payments/{id}','PaymentsController@edit');

	//Promotion
	Route::get('/promotion/listData','promotionController@listAll');
	Route::get('/promotion/listStudents/{class}','promotionController@listStudents');
	Route::post('/promotion','promotionController@promoteNow');

});

Route::post('/payments/success/{id}','PaymentsController@paymentSuccess');

//Auth filtering
Route::filter('auth', function()
{
	if (Auth::guest())
		return Redirect::to('/login');
});

Route::filter('api.csrf', function($route, $request)
{
	if ( Request::isMethod('post') )
	{
		if( !((Input::has('_token') AND Session::token() == Input::get('_token')) || ($request->header('X-Csrf-Token') != "" AND Session::token() == $request->header('X-Csrf-Token')) ) ){
			return Response::json('CSRF does not match', 400);
		}		
	}
});