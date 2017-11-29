<?php

namespace App\Http\Controllers\Volunteers;

use App\Models\Volunteers\Quizmaster;
use App\Http\Controllers\Controller;
use App\Http\Requests\Volunteers\QuizmasterRequest;
use Illuminate\Http\Response;
//use Activity;

class QuizmasterController extends Controller
{
    /**
     * Display a listing of the quizmasters.
     *
     * @return Response
     */
    public function index()
    {
        $quizmasters = Quizmaster::select('id', 'name_q1', 'phone_q1', 'email_q1', 'name_q2')
            ->distinct()
            ->get();

        return view('volunteers.quiz.index', compact('quizmasters'));
    }

    /**
     * Show the form for creating a new quizmaster.
     *
     * @return Response
     */
    public function create()
    {
        $quizmaster = new Quizmaster;

        return view('volunteers.quiz.create', compact('quizmaster'));
    }

    /**
     * Store a newly created quizmaster.
     *
     * @param QuizmasterRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(QuizmasterRequest $request)
    {
        $storeQuizmaster = new Quizmaster;

        $storeQuizmaster->name_q1   = $request->name_q1;
        $storeQuizmaster->phone_q1  = $request->phone_q1;
        $storeQuizmaster->email_q1  = $request->email_q1;
        $storeQuizmaster->name_q2   = $request->name_q2;
        $storeQuizmaster->phone_q2  = $request->phone_q2;
        $storeQuizmaster->email_q2  = $request->email_q2;

        $storeQuizmaster->save();

        //Activity::log(Auth::user()->getFullName(). ' la til '.$request->name.' som frivillig');
        flash()->success('Quizmaster opprettet');

        return \Redirect::action('Volunteers\QuizmasterController@index');
    }

    /**
     * Show the form for editing the specified quizmaster.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $quizmaster = Quizmaster::find($id);

        return view('volunteers.quiz.edit', compact('quizmaster'));
    }

    /**
     * Update the specified quizmaster.
     *
     * @param QuizmasterRequest $request
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(QuizmasterRequest $request, $id)
    {
        $updateQuizmaster = Quizmaster::find($id);

        $updateQuizmaster->name_q1  = $request->name_q1;
        $updateQuizmaster->phone_q1 = $request->phone_q1;
        $updateQuizmaster->email_q1 = $request->email_q1;
        $updateQuizmaster->name_q2  = $request->name_q2;
        $updateQuizmaster->phone_q2 = $request->phone_q2;
        $updateQuizmaster->email_q2 = $request->email_q2;

        $updateQuizmaster->save();

        flash()->success('Informasjon oppdatert');

        return \Redirect::back();
    }

    /**
     * Remove the specified quizmaster.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $quizmaster = Quizmaster::find($id);

        $quizmaster->delete();

        flash()->success('Quizmasteren ble fjernet!');

        return \Redirect::action('Volunteers\QuizmasterController@index');
    }

    /**
     * Show all emails for quizmasters.
     *
     * @return Response
     */
    public function listEmails()
    {
        $quizmasters = Quizmaster::select('email_q1', 'email_q2')
            ->distinct()
            ->get();

        return view('volunteers.quiz.emails', compact('quizmasters'));
    }

    /**
     * Show all phone numbers for quizmasters.
     *
     * @return Response
     */
    public function listPhones()
    {
        $quizmasters = Quizmaster::select('phone_q1', 'name_q1', 'phone_q2', 'name_q2')
            ->distinct()
            ->get();

        return view('volunteers.quiz.phones', compact('quizmasters'));
    }
}