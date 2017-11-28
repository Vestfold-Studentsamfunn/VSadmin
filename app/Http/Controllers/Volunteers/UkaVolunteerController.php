<?php

namespace App\Http\Controllers\Volunteers;

use App\Models\Volunteers\UkaVolunteer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Volunteers\UkaVolunteerRequest;
use Illuminate\Http\Response;
//use Activity;

class UkaVolunteerController extends Controller
{
    /**
     * Display a listing of volunteers for UKA.
     *
     * @return Response
     */
    public function index()
    {
        $ukaVolunteers = UkaVolunteer::select('id', 'name', 'phone', 'email', 'jobs')
            ->distinct()
            ->get();

        return view('volunteers.uka.index', compact('ukaVolunteers'));
    }

    /**
     * Show the form for creating a new volunteer.
     *
     * @return Response
     */
    public function create()
    {
        $ukaVolunteer = new UkaVolunteer;

        return view('volunteers.uka.create', compact( 'ukaVolunteer'));
    }

    /**
     * Store a newly created volunteer.
     *
     * @param UkaVolunteerRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UkaVolunteerRequest $request)
    {
        $storeUkaVolunteer = new UkaVolunteer();

        $storeUkaVolunteer->name    = $request->name;
        $storeUkaVolunteer->phone   = $request->phone;
        $storeUkaVolunteer->email   = $request->email;
        $storeUkaVolunteer->jobs    = $request->jobs;

        $storeUkaVolunteer->save();

        //Activity::log(Auth::user()->getFullName(). ' la til '.$request->name.' som frivillig');
        flash()->success('Frivillig opprettet');

        return \Redirect::action('Volunteers\UkaVolunteerController@index');
    }

    /**
     * Show the form for editing the specified volunteer.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $volunteerUka = UkaVolunteer::find($id);

        return view('volunteers.uka.edit', compact('volunteerUka'));
    }

    /**
     * Update the specified volunteer.
     *
     * @param UkaVolunteerRequest $request
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UkaVolunteerRequest $request, $id)
    {
        $updateUkaVolunteer = UkaVolunteer::find($id);

        $updateUkaVolunteer->name   = $request->name;
        $updateUkaVolunteer->phone  = $request->phone;
        $updateUkaVolunteer->email  = $request->email;
        $updateUkaVolunteer->jobs   = $request->jobs;


        flash()->success('Informasjon oppdatert');

        $updateUkaVolunteer->save();

        return \Redirect::back();
    }

    /**
     * Remove the specified volunteer.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $UkaVolunteer = UkaVolunteer::find($id);

        $UkaVolunteer->delete();

        flash()->success('Den frivillige ble fjernet!');

        return \Redirect::action('Volunteers\UkaVolunteerController@index');
    }

    /**
     * Show all emails for UKA volunteers.
     *
     * @return Response
     */
    public function listEmails()
    {
        $ukaVolunteers = UkaVolunteer::select('email')
            ->distinct()
            ->get();

        return view('volunteers.uka.emails', compact('ukaVolunteers'));
    }

    /**
     * Show all phones for UKA volunteers.
     *
     * @return Response
     */
    public function listPhones()
    {
        $ukaVolunteers = UkaVolunteer::select('phone', 'name')
            ->distinct()
            ->get();

        return view('volunteers.uka.phones', compact('ukaVolunteers'));
    }
}