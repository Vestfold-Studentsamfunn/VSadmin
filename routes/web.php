<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group.
|
*/

Route::auth();

// Login
Route::get('/', 'Auth\LoginController@showLoginForm');

// ALL other routes goes here so they are protected by auth
Route::group(['middleware' => 'auth'], function()
{
    // Dashboard stuff
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    // Member routes
    Route::group(['prefix' => 'members'], function () {
        Route::get('/', 'MembersController@index')->name('members.index');
        Route::get('getIndex', 'MembersController@getIndex')->name('members.indexAjax');
        Route::get('details', 'MembersController@details')->name('members.details');
        Route::get('create', 'MembersController@create')->name('members.create');
        Route::get('edit/{id}', 'MembersController@edit')->name('members.edit');
        Route::get('picture/show/{id}', 'MembersController@showImage')->name('members.showImage');
        Route::post('search', 'MembersController@search')->name('members.search');
        Route::post('update', 'MembersController@update')->name('members.update');
        Route::post('update/payment/{id}', 'MembersController@updatePayment')->name('members.updatePayment');
        Route::post('update/settings/{id}', 'MembersController@updateMemberSettings')->name('members.updateSettings');
        Route::post('store', 'MembersController@store')->name('members.store');
        Route::post('update/picture/{id}', 'MembersController@updatePicture')->name('members.updatePicture');
        Route::post('update/picture/rotate/{id}', 'MembersController@rotatePicture')->name('members.rotatePicture');
        Route::post('delete/{id}', 'MembersController@destroy')->name('members.delete');
        Route::get('sms', 'SMSController@members')->name('members.sms');
        Route::post('sms', 'SMSController@members')->name('members.sms');
        Route::group(['prefix' => 'lists'], function () {
            Route::get('emails', 'MembersController@listEmails')->name('members.emails');
            Route::get('phones', 'MembersController@listPhones')->name('members.phones');
            Route::get('print', 'PrintController@members')->name('members.print');
            Route::post('print', 'PrintController@printList')->name('members.print');
        });
    });


    // Volunteers routes
    Route::group(['prefix' => 'volunteers'], function () {
        Route::get('/', 'VolunteersController@index')->name('volunteers.index');
        Route::get('details', 'VolunteersController@details')->name('volunteers.details');
        Route::get('create', 'VolunteersController@create')->name('volunteers.create');
        Route::get('edit', 'VolunteersController@edit')->name('volunteers.edit');
        Route::post('create', 'VolunteersController@create')->name('volunteers.create');
        Route::post('update/{id}', 'VolunteersController@update')->name('volunteers.update');
        Route::post('store', 'VolunteersController@store')->name('volunteers.store');
        Route::post('delete/{id}', 'VolunteersController@destroy')->name('volunteers.delete');
        Route::get('sms', 'SMSController@volunteers')->name('volunteers.sms');
        Route::group(['prefix' => 'lists'], function () {
            Route::get('emails', 'VolunteersController@listEmails')->name('volunteers.emails');
            Route::get('phones', 'VolunteersController@listPhones')->name('volunteers.phones');
            Route::get('print', 'PrintController@volunteers')->name('volunteers.print');
            Route::post('print', 'PrintController@printList')->name('volunteers.print');
        });

        // Quizmaster routes
        Route::group(['prefix' => 'quiz'], function () {
            Route::get('/', 'Volunteers\QuizmasterController@index')->name('quiz.index');
            Route::get('create', 'Volunteers\QuizmasterController@create')->name('quiz.create');
            Route::get('edit/{id}', 'Volunteers\QuizmasterController@edit')->name('quiz.edit');
            Route::post('store', 'Volunteers\QuizmasterController@store')->name('quiz.store');
            Route::post('update/{id}', 'Volunteers\QuizmasterController@update')->name('quiz.update');
            Route::post('delete/{id}', 'Volunteers\QuizmasterController@destroy')->name('quiz.delete');
            Route::get('sms', 'SMSController@volunteers')->name('quiz.sms');
            Route::group(['prefix' => 'lists'], function () {
                Route::get('emails', 'Volunteers\QuizmasterController@listEmails')->name('quiz.emails');
                Route::get('phones', 'Volunteers\QuizmasterController@listPhones')->name('quiz.phones');
                Route::get('print', 'PrintController@volunteers')->name('quiz.print');
                Route::post('print', 'PrintController@printList')->name('quiz.print');
            });
        });

        // UKA Volunteers routes
        Route::group(['prefix'=>'uka'], function () {
            Route::get('/', 'Volunteers\UkaVolunteerController@index')->name('uka.index');
            Route::get('create', 'Volunteers\UkaVolunteerController@create')->name('uka.create');
            Route::get('edit/{id}', 'Volunteers\UkaVolunteerController@edit')->name('uka.edit');
            Route::post('store', 'Volunteers\UkaVolunteerController@store')->name('uka.store');
            Route::post('update/{id}', 'Volunteers\UkaVolunteerController@update')->name('uka.update');
            Route::post('delete/{id}', 'Volunteers\UkaVolunteerController@destroy')->name('uka.delete');
            Route::get('sms', 'SMSController@volunteers')->name('uka.sms');
            Route::group(['prefix' => 'lists'], function () {
                Route::get('emails', 'Volunteers\QuizmasterController@listEmails')->name('uka.emails');
                Route::get('phones', 'Volunteers\QuizmasterController@listPhones')->name('uka.phones');
                Route::get('print', 'PrintController@volunteers')->name('uka.print');
                Route::post('print', 'PrintController@printList')->name('uka.print');
            });
        });
    });


    // Hemsedal routes
    Route::group(['prefix' => 'hemsedal'], function () {
        Route::get('/', 'HemsedalController@index')->name('hemsedal.index');
        Route::get('getIndex', 'HemsedalController@getIndex')->name('hemsedal.indexAjax');
        Route::get('details', 'HemsedalController@details')->name('hemsedal.details');
        Route::get('create', 'HemsedalController@create')->name('hemsedal.create');
        Route::get('edit{id}', 'HemsedalController@edit')->name('hemsedal.edit');
        Route::get('print', 'PrintController@hemsedal')->name('hemsedal.print');
        Route::post('create', 'HemsedalController@create')->name('hemsedal.create');
        Route::post('update/{id}', 'HemsedalController@update')->name('hemseal.update');
        Route::post('update/payment/{id}', 'HemsedalController@updatePayment')->name('hemsedal.updatePayment');
        Route::post('update/settings/{id}', 'HemsedalController@updateMemberSettings')->name('hemsedal.updateSettings');
        Route::post('print', 'PrintController@printList')->name('hemsedal.print');
        Route::post('store', 'HemsedalController@store')->name('hemsedal.store');
        Route::post('delete/{id}', 'HemsedalController@destroy')->name('hemsedal.delete');
        Route::get('sms', 'SMSController@hemsedal')->name('hemsedal.sms');
        Route::post('sms', 'SMSController@hemsedal')->name('hemsedal.sms');
        Route::group(['prefix' => 'lists'], function () {
            Route::get('emails', 'HemsedalController@listEmails')->name('hemsedal.emails');
            Route::get('phones', 'HemsedalController@listPhones')->name('hemsedal.phones');
            Route::get('print', 'PrintController@hemsedal')->name('hemsedal.print');
            Route::post('print', 'PrintController@printList')->name('hemsedal.print');
        });
    });

    // SMS routes
    Route::group(['prefix' => 'sms'], function () {
        Route::get('single', 'SMSController@single')->name('sms.single');
        Route::post('send', 'SMSController@send_SMS')->name('sms.send');
    });

    // Settings routes
    Route::group(['prefix' => 'settings'], function () {
        Route::get('members', 'MembersController@settings')->name('settings.members');
        Route::post('members/update', 'MembersController@settingsUpdate');
        Route::post('members/add', 'MembersController@settingsAdd');
        Route::post('members/delete', 'MembersController@settingsDelete');
        Route::get('volunteers', 'VolunteersController@settings')->name('settings.volunteers');
        Route::post('volunteers/update', 'VolunteersController@settingsUpdate');
        Route::post('volunteers/add', 'VolunteersController@settingsAdd');
        Route::post('volunteers/delete', 'VolunteersController@settingsDelete');
        Route::get('hemsedal', 'HemsedalController@settings')->name('settings.hemsedal');
        Route::post('hemsedal/update', 'HemsedalController@settingsUpdate');
        Route::post('hemsedal/add', 'HemsedalController@settingsAdd');
        Route::post('hemsedal/delete', 'HemsedalController@settingsDelete');
        Route::post('hemsedal/updateTrip', 'HemsedalController@updateTrip');
        Route::get('users/edit/{id}', 'UserController@edit')->name('settings.edituser');
        Route::get('users/roles', 'UserController@roles');
        Route::post('users/roles', 'UserController@postRoles');
        Route::get('users/create', 'UserController@create');
        Route::post('users/register', 'UserController@postRegister');
        Route::get('users', 'UserController@index')->name('settings.users');
        Route::delete('activity', 'ActivityController@destroy');
        Route::resource('activity', 'ActivityController');
    });
});
// ./auth