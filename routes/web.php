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

Route::auth();

// Login
Route::get('/', 'Auth\LoginController@showLoginForm');

// ALL other routes goes in here...
Route::group(['middleware' => 'auth'], function()
{
    // Dashboard stuff...
    Route::get('dashboard', 'DashboardController@index');
    Route::get('logout', 'Auth\LoginController@logout');

    // Member routes...
    Route::group(['prefix' => 'members'], function () {
        Route::get('index', 'MembersController@index');
        Route::get('getIndex', [
            'as' => 'members.getIndex', 'uses' => 'MembersController@getIndex'
        ]);
        Route::get('details', 'MembersController@details');
        Route::get('create', 'MembersController@create');
        Route::get('edit', [
            'as' => 'member.edit', 'uses' => 'MembersController@edit'
        ]);
        Route::post('edit', [
            'as' => 'member.edit', 'uses' => 'MembersController@edit'
        ]);
        Route::get('emails', 'MembersController@listEmails');
        Route::get('phones', 'MembersController@listPhones');
        Route::get('print', 'PrintController@settings');
        Route::get('picture/show/{id}', 'MembersController@showImage');
        Route::post('search', 'MembersController@search');
        Route::post('update', [
            'as' => 'members.update', 'uses' => 'MembersController@update'
        ]);
        Route::post('update/payment/{id}', 'MembersController@updatePayment');
        Route::post('update/settings/{id}', 'MembersController@updateMemberSettings');
        Route::post('store', 'MembersController@store');
        Route::post('print', 'PrintController@printList');
        Route::post('picture/{id}', 'MembersController@updatePicture');
        Route::post('picture/rotate/{id}', 'MembersController@rotatePicture');
        Route::post('delete/{id}', 'MembersController@destroy');
    });


    // Volunteers routes...
    Route::group(['prefix' => 'volunteers'], function () {
        Route::get('index', 'VolunteersController@index');
        Route::get('details', 'VolunteersController@details');
        Route::get('create', 'VolunteersController@create');
        Route::get('edit', [
            'as' => 'volunteer.edit',
            'uses' => 'VolunteersController@edit'
        ]);
        Route::get('list/emails', 'VolunteersController@listEmails');
        Route::get('list/phones', 'VolunteersController@listPhones');
        Route::post('create', 'VolunteersController@create');
        Route::post('update/{id}', 'VolunteersController@update');
        Route::post('store', 'VolunteersController@store');
        Route::post('delete/{id}', 'VolunteersController@destroy');

        Route::group(['prefix' => 'quiz'], function () {
            Route::get('index', 'Volunteers\QuizmasterController@index')->name('quiz.index');
            Route::get('create', 'Volunteers\QuizmasterController@create')->name('quiz.create');
            Route::get('edit/{id}', 'Volunteers\QuizmasterController@edit')->name('quiz.edit');
            Route::get('emails', 'Volunteers\QuizmasterController@listEmails')->name('quiz.emails');
            Route::get('phones', 'Volunteers\QuizmasterController@listPhones')->name('quiz.phones');
            Route::post('store', 'Volunteers\QuizmasterController@store')->name('quiz.store');
            Route::post('update/{id}', 'Volunteers\QuizmasterController@update')->name('quiz.update');
            Route::post('delete/{id}', 'Volunteers\QuizmasterController@destroy')->name('quiz.delete');
        });

        Route::group(['prefix' => 'uka'], function () {
            Route::get('index', 'VolunteersUkaController@index');
            Route::get('details', 'VolunteersUkaController@details');
            Route::get('create', 'VolunteersUkaController@create');
            Route::post('delete/{id}', 'VolunteersUkaController@destroy');
            Route::post('store', 'VolunteersUkaController@store');
            Route::get('edit', [
                'as' => 'volunteer.uka.edit',
                'uses' => 'VolunteersUkaController@edit'
            ]);
            Route::post('update/{id}', [
                'as' => 'volunteer.uka.update',
                'uses' => 'VolunteersUkaController@update'
            ]);
        });
    });


    // Hemsedal routes...
    Route::group(['prefix' => 'hemsedal'], function () {
        Route::get('getIndex', [
            'as' => 'hemsedal.getIndex', 'uses' => 'HemsedalController@getIndex'
        ]);
        Route::get('/', 'HemsedalController@index');
        Route::get('details', 'HemsedalController@details');
        Route::get('create', 'HemsedalController@create');

        Route::get('edit', [
            'as' => 'hemsedal.edit',
            'uses' => 'HemsedalController@edit'
        ]);
        //Route::get('edit/{id}', 'HemsedalController@edit');
        Route::get('emails', 'HemsedalController@listEmails');
        Route::get('phones', 'HemsedalController@listPhones');
        Route::get('print', 'PrintController@settings');
        Route::post('create', [
            'as' => 'hemsedal.create',
            'uses' => 'HemsedalController@create'
        ]);
        Route::post('update', [
            'as' => 'hemsedal.update',
            'uses' => 'HemsedalController@update'
        ]);
        Route::post('update/payment/{id}', 'HemsedalController@updatePayment');
        Route::post('update/settings/{id}', 'HemsedalController@updateMemberSettings');
        Route::post('print', 'PrintController@printList');
        Route::post('store', [
            'as' => 'hemsedal.store',
            'uses' => 'HemsedalController@store'
        ]);
        Route::post('delete/{id}', 'HemsedalController@destroy');
    });

    // SMS
    Route::group(['prefix' => 'sms'], function () {
        Route::get('single', 'SMSController@single');
        Route::get('members', 'SMSController@members');
        Route::post('members', 'SMSController@members');
        Route::get('volunteers', 'SMSController@volunteers');
        Route::get('hemsedal', 'SMSController@hemsedal');
        Route::post('hemsedal', 'SMSController@hemsedal');
        Route::post('send', [
            'as' => 'sms.send',
            'uses' => 'SMSController@send_SMS'
        ]);
    });

    Route::get('settings/members', 'MembersController@settings');
    Route::post('settings/members/update', 'MembersController@settingsUpdate');
    Route::post('settings/members/add', 'MembersController@settingsAdd');
    Route::post('settings/members/delete', 'MembersController@settingsDelete');
    Route::get('settings/volunteers', 'VolunteersController@settings');
    Route::post('settings/volunteers/update', 'VolunteersController@settingsUpdate');
    Route::post('settings/volunteers/add', 'VolunteersController@settingsAdd');
    Route::post('settings/volunteers/delete', 'VolunteersController@settingsDelete');
    Route::get('settings/hemsedal', 'HemsedalController@settings');
    Route::post('settings/hemsedal/update', 'HemsedalController@settingsUpdate');
    Route::post('settings/hemsedal/add', 'HemsedalController@settingsAdd');
    Route::post('settings/hemsedal/delete', 'HemsedalController@settingsDelete');
    Route::post('settings/hemsedal/updateTrip', 'HemsedalController@updateTrip');
    Route::get('settings/users/roles', 'UserController@roles');
    Route::post('settings/users/roles', 'UserController@postRoles');
    Route::post('/settings/users/register', 'UserController@postRegister');
    Route::resource('/settings/users', 'UserController');
    Route::delete('/settings/activity', 'ActivityController@destroy');
    Route::resource('/settings/activity', 'ActivityController');
});