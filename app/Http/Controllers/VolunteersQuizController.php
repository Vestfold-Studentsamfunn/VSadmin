<?php

namespace App\Http\Controllers;

use App\VolunteerQuiz;

use App\Http\Requests;

use DB;
use Input;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Activity;
use Auth;

use Carbon\Carbon;

use Intervention\Image\Facades\Image;

class VolunteersQuizController extends Controller
{
    /**
     * Display a listing of the quizmasters.
     *
     * @return Response
     */
    public function index()
    {

        $quizmasters = VolunteerQuiz::select('id', 'name_q1', 'phone_q1', 'email_q1', 'name_q2')
            ->distinct()
            ->get();

        return view('volunteers.quiz.index', compact('quizmasters'));
    }

    /**
     * Show the form for creating a new volunteer.
     *
     * @return Response
     */
    public function create()
    {
        $volunteerJobs      = VolunteerJobs::orderBy('name', 'asc')->get();

        if (Input::has('memberID')) {
            $query      = Input::get('memberID');

            $member    = Members::find($query);

            if ($member) {
                flash()->info('Frivilliginfo hentet fra medlemsregisteret');
                return view('volunteers.create', compact('member', 'volunteerJobs'));
            }
            else{
                flash()->warning('Fant ikke medlemmet, fyll inn frivilliginfo');
            }
        }

        $member    = new Members();
        $member->id = '';
        $member->name = '';
        $member->email = '';
        $member->phone = '';

        return view('volunteers.create', compact('member', 'volunteerJobs'));
    }

    /**
     * Store a newly created volunteer.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $storeVolunteer = new VolunteerData;

        $storeVolunteer->member_id     = $request->memberID;
        $storeVolunteer->name          = $request->name;
        $storeVolunteer->phone         = $request->phone;
        $storeVolunteer->email         = $request->email;

        $storeVolunteer->save();

        $storeVolunteer->volunteerJobs()->sync($request->jobs, false);

        Activity::log(Auth::user()->getFullName(). ' la til '.$request->name.' som frivillig');
        flash()->success('Frivillig opprettet');

        return \Redirect::action('VolunteersController@edit', ['id' => $storeVolunteer->id]);
    }

    /**
     * Show the form for editing the specified member.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit()
    {
        $id = Input::get('id');

        $quizmaster = VolunteerQuiz::find($id);

        return view('volunteers.quiz.edit', compact('quizmaster'));
    }

    /**
     * Update the specified member.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request)
    {
        $id = Input::get('id');
        $updateQuizmaster = VolunteerQuiz::find($id);

        $updateQuizmaster->name_q1         = $request->name_q1;
        $updateQuizmaster->phone_q1        = $request->phone_q1;
        $updateQuizmaster->email_q1        = $request->email_q1;
        $updateQuizmaster->name_q2         = $request->name_q2;
        $updateQuizmaster->phone_q2        = $request->phone_q2;
        $updateQuizmaster->email_q2        = $request->email_q2;


        flash()->success('Informasjon oppdatert');

        $updateQuizmaster->save();

        return \Redirect::back();
    }

    /**
     * Remove the specified volunteer.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $quizmaster = VolunteerQuiz::find($id);

        $quizmaster->delete();

        flash()->success('Quizmasteren ble fjernet!');

        return \Redirect::action('VolunteersQuizController@index');
    }

    /**
     * Show the form for editing the specified member.
     *
     * @return Response
     */
    public function listEmails()
    {
        $volunteers = VolunteerData::select('email')
                                    ->distinct()
                                    ->get();

        return view('volunteers.emails', compact('volunteers'));
    }

    /**
     * Show the form for editing the specified member.
     *
     * @param  int  $id
     * @return Response
     */
    public function listPhones()
    {
        $volunteers = VolunteerData::select('phone', 'name')
                                    ->distinct()
                                    ->get();

        return view('volunteers.phones', compact('volunteers'));
    }

    public function details()
    {
        $numberOfMembers        = Members::whereIn('payed', ['-1', '1'])
            ->count();

        $numberOfVip            = Members::whereIn('payed', ['-1', '1'])
            ->whereNotIn('vipGroup', ['Ingen'])
            ->count();

        $numberOfCards          = Members::whereIn('payed', ['1'])
            ->count();

        $numberOfDepartments    = Members::select(DB::raw('count(department) as amount, department'))
                                            ->whereIn('payed', ['-1', '1'])
                                            ->groupBy('department')
                                            ->orderBy('department', 'asc')
                                            ->get();

        return view('volunteers.details', compact('numberOfMembers', 'numberOfVip', 'numberOfCards', 'numberOfDepartments', 'ageGroups'));
    }
}