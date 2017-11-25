<?php

namespace App\Http\Controllers;

use App\VolunteerUka;

use App\Http\Requests;

use DB;
use Input;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Activity;
use Auth;

use Carbon\Carbon;

use Intervention\Image\Facades\Image;

class VolunteersUkaController extends Controller
{
    /**
     * Display a listing of the members.
     *
     * @return Response
     */
    public function index()
    {

        $volunteersUka = VolunteerUka::select('id', 'name', 'phone', 'email', 'jobs')
            ->distinct()
            ->get();

        return view('volunteers.uka.index', compact('volunteersUka'));
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
     * Display the specified member.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
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

        $volunteerUka = VolunteerUka::find($id);

        return view('volunteers.uka.edit', compact('volunteerUka'));
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
        dd($id);
        $updateUkaVolunteer = VolunteerUka::find($id);
        dd($updateUkaVolunteer);

        $updateUkaVolunteer->name         = $request->name;
        $updateUkaVolunteer->phone        = $request->phone;
        $updateUkaVolunteer->email        = $request->email;
        $updateUkaVolunteer->jobs         = $request->jobs;


        flash()->success('Informasjon oppdatert');

        $updateUkaVolunteer->save();

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
        $UkaVolunteer = VolunteerUka::find($id);

        $UkaVolunteer->delete();

        flash()->success('Den frivillige ble fjernet!');

        return \Redirect::action('VolunteersUkaController@index');
    }

    /**
     * Show and edit settings for all members
     *
     * @return Response
     */
    public function settings()
    {
        $selectVolunteerJob   = VolunteerJobs::orderBy('name', 'asc')->pluck('name', 'id');

        $cleanDate = Carbon::now()->subYear();

        return view('settings.volunteers', compact('selectVolunteerJob','cleanDate'));
    }

    public function settingsUpdate(Request $request)
    {
        if ($request->_form == 'updateJob')
        {
            VolunteerJobs::where('id', $request->selectedVolunteerJob)
                ->update(['name' => $request->updateJobName]);

            Activity::log(Auth::user()->getFullName(). ' oppdaterte frivilligjobben '.$request->selectedVolunteerJob);
            flash()->success('Frivilligjobben ble oppdatert');
        }

        if ($request->_form == 'updateStatus')
        {
            if ($request->clean == 'volunteers'){

                //dd(VolunteerData::where('created_at', '<', Carbon::now()->subYear()));
                VolunteerData::where('created_at', '<', Carbon::now()->subYear())
                    //->volunteerJobs()->detach()
                    ->delete();

                flash()->success('Frivillige registrert før ' .Carbon::now()->subYear(). ' ble fjernet');
            }
        }

        return \Redirect::back();
    }

    public function settingsAdd(Request $request)
    {
        if ($request->_form == 'addJob')
        {
            VolunteerJobs::create(['name' => $request->addVolunteerJobName]);

            Activity::log(Auth::user()->getFullName(). ' la til frivilligjobben '.$request->addVolunteerJobName);
            flash()->success('Frivilligjobb lagt til');
        }

        return \Redirect::back();
    }

    public function settingsDelete(Request $request)
    {
        if ($request->_form == 'deleteJob')
        {
            VolunteerJobs::where('id', $request->deleteVolunteerJob)->delete();

            Activity::log(Auth::user()->getFullName(). ' fjernet frivilligjobben '.$request->deleteVolunteerJob);
            flash()->success('Frivilligjobben ble fjernet');
        }

        return \Redirect::back();
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

    public function search() {
        $query      = Input::get('memberID');
        var_dump($query);

        $member    = Members::find($query)
            ->select('id', 'name', 'phone', 'email')
            ->first();

        $volunteerJobs      = VolunteerJobs::orderBy('name', 'asc')->get();

        if ($member) {
            return view('volunteers.create', compact('member', 'volunteerJobs'));
            //return \Redirect::to('volunteers/create')->with($member, $volunteerJobs);
            //return view(\Redirect::back(), compact('member', 'volunteerJobs'));
        }
    }
}