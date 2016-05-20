<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => 'auth'], function(){

	Route::get('unauthorized', function(){
		return view('unauthorized');
	});
	Route::get('/', 'dashboardController@index');
	

	// School
	Route::get('school', 'schoolController@index');
	Route::post('school/new', array(
		'uses' => 'schoolController@create',
		'as' => 'create.School'
	));
	Route::post('school/delete', array(
		'uses' => 'schoolController@delete',
		'as' => 'delete.school'
	));
	Route::get('school/edit/{id}', array(
		'uses' => 'schoolController@edit',
		'as' => 'edit.school'
	));
	Route::post('school/update', array(
		'uses' => 'schoolController@update',
		'as' => 'update.school'
	));
	// School

	

	// Colearners
	Route::get('colearner', 'coleController@index');
	Route::post('colearner/new', array(
		'uses' => 'coleController@create',
		'as' => 'create.cole'
	));
	Route::post('colearner/delete', array(
		'uses' => 'coleController@delete',
		'as' => 'delete.cole'
	));
	Route::get('colearner/edit/{id}', array(
		'uses' => 'coleController@edit',
		'as' => 'edit.cole'
	));
	Route::post('colearner/update', array(
		'uses' => 'coleController@update',
		'as' => 'update.cole'
	));
	// Colearners


	// Donors
	Route::get('donor', 'donorController@index');
	Route::post('donor/new', array(
		'uses' => 'donorController@create',
		'as' => 'create.donor'
	));
	Route::post('donor/delete', array(
		'uses' => 'donorController@delete',
		'as' => 'delete.donor'
	));
	Route::get('donor/edit/{id}', array(
		'uses' => 'donorController@edit',
		'as' => 'edit.donor'
	));
	Route::post('donor/update', array(
		'uses' => 'donorController@update',
		'as' => 'update.donor'
	));
	Route::get('donor/email/send/{id}/{email}', array(
		'uses' => 'donorController@EmailSend',
		'as' => 'send.donor'
	));
	Route::post('donor/sponsoredlearners', array(
		'uses' => 'donorController@addSponsoredLearners',
		'as' => 'sponsored.donor'
	));
	Route::post('donor/donee/delete', array(
		'uses' => 'donorController@deleteDonee',
		'as' => 'deleteDonee.donor'
	));
	// Donors

	// Sessions
	Route::get('session', 'sessionController@index');
	Route::post('session/new', array(
		'uses' => 'sessionController@create',
		'as' => 'create.session'
	));
	Route::post('session/delete', array(
		'uses' => 'sessionController@delete',
		'as' => 'delete.session'
	));
	Route::get('session/edit/{id}', array(
		'uses' => 'sessionController@edit',
		'as' => 'edit.session'
	));
	Route::post('session/update', array(
		'uses' => 'sessionController@update',
		'as' => 'update.session'
	));
	// Sessions



	// user profile
	Route::get('user/profile', array(
		'uses' => 'userController@profile',
		'as' => 'profile.user'
	));
	Route::post('user/profile/update', array(
		'uses' => 'userController@update',
		'as' => 'profile.update'
	));
	Route::post('user/password', array(
		'uses' => 'userController@changepassword',
		'as' => 'profile.password'
	));


	// School Day
	Route::post('schoolday/new', array(
		'uses' => 'schooldayController@create',
		'as' => 'create.schoolday'
	));
	Route::post('schoolday/delete', array(
		'uses' => 'schooldayController@delete',
		'as' => 'delete.schoolday'
	));
	Route::post('schoolday/learner', array(
		'uses' => 'schooldayController@learner',
		'as' => 'learner.schoolday'
	));
	Route::post('schoolday/learner/present', array(
		'uses' => 'schooldayController@addPresentLearners',
		'as' => 'learner.schoolday'
	));
	Route::get('schoolday/{id}/{sesname}', array(
		'uses' => 'schooldayController@index',
		'as' => 'index.schoolday'
	));
	// School Day

	// Learner
	Route::get('learner', 'learnerController@index');
	Route::get('learner/new', array(
		'uses' => 'learnerController@newlearner',
		'as' => 'create.learner'
	));
	Route::post('learner/create', array(
		'uses' => 'learnerController@create',
		'as' => 'create.learner'
	));
	Route::post('learner/profile', array(
		'uses' => 'learnerController@profile',
		'as' => 'profile.learner'
	));
	Route::post('learner/update', array(
		'uses' => 'learnerController@update',
		'as' => 'update.learner'
	));
	Route::post('learner/grade', array(
		'uses' => 'learnerController@addGrade',
		'as' => 'grade.learner'
	));
	Route::post('learner/grade/delete', array(
		'uses' => 'learnerController@deleteGrade',
		'as' => 'gradedelete.learner'
	));
	Route::post('learner/attendance', array(
		'uses' => 'learnerController@addAttendance',
		'as' => 'attendance.learner'
	));
	Route::post('learner/attendance/delete', array(
		'uses' => 'learnerController@deleteAttendance',
		'as' => 'attdelete.learner'
	));
	Route::post('learner/stories', array(
		'uses' => 'learnerController@addStory',
		'as' => 'story.learner'
	));
	Route::post('learner/stories/update', array(
		'uses' => 'learnerController@updateStory',
		'as' => 'story.learner'
	));
	Route::post('learner/stories/delete', array(
		'uses' => 'learnerController@deleteStory',
		'as' => 'story.learner'
	));
	Route::post('learner/grades/update', array(
		'uses' => 'learnerController@updateGrades',
		'as' => 'updateGrades.learner'
	));
	Route::get('view/grades/breakdown/{intGrdLvl}/{strLearCode}', array(
		'uses' => 'learnerController@ViewGrades',
		'as' => 'ViewGrades.learner'
	));
	// Users
	Route::group(['middleware' => 'admin'], function()
	{
		//User
	    Route::get('user', array(
			'uses' => 'userController@index',
			'as' => 'index.user'
		));
		Route::post('user/create', array(
			'uses' => 'userController@create',
			'as' => 'create.user'
		));
		Route::post('user/delete', array(
			'uses' => 'userController@delete',
			'as' => 'delete.user'
		));
		//User

		// Program
		Route::get('program', 'programController@index');
		Route::post('program/new', array(
			'uses' => 'programController@create',
			'as' => 'create.program'
		));
		Route::post('program/delete', array(
			'uses' => 'programController@delete',
			'as' => 'delete.program'
		));
		Route::get('program/edit/{id}', array(
			'uses' => 'programController@edit',
			'as' => 'edit.program'
		));
		Route::post('program/update', array(
			'uses' => 'programController@update',
			'as' => 'update.program'
		));
		// Program

		// Learning Center
		Route::get('learningcenter', 'LearningCenterController@index');

		Route::post('learningcenter/new', array(
			'uses' => 'LearningCenterController@create',
			'as' => 'createLearningCenter'
		));
		Route::post('learningcenter/delete', array(
			'uses' => 'LearningCenterController@delete',
			'as' => 'delete.LearningCenter'
		));
		Route::get('learningcenter/edit/{id}', array(
			'uses' => 'LearningCenterController@edit',
			'as' => 'edit.LearningCenter'
		));
		Route::post('learningcenter/update', array(
			'uses' => 'LearningCenterController@update',
			'as' => 'update.LearningCenter'
		));
		// Learning Center

		// Reports
		Route::get('report/attendance', 'ReportController@attendance');
		Route::post('report/attendance/generate', 'ReportController@attGenerate');

		Route::get('report/grades', 'ReportController@grades');
		Route::post('report/grades/generate', 'ReportController@grdGenerate');

	});
});



Route::get('donee/profile/{code}', 'doneeController@index');
Route::post('donee/profile/stories', array(
			'uses' => 'doneeController@stories',
			'as' => 'donee.story'
		));

// Login
// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');