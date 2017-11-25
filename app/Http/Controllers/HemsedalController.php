<?php

namespace App\Http\Controllers;

use App\Hemsedal;
use App\Members;
use App\Departments;
use App\VipGroups;
use App\VolunteerData;
use App\VolunteerJobs;

use App\Http\Requests;
use App\Http\Requests\StoreHemsedalRequest;
use App\Http\Requests\UpdateMemberProfileRequest;
use App\Http\Requests\UpdateMemberPaymentRequest;
use App\Http\Requests\UpdateMemberSettingsRequest;

use DB;
use Input;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Carbon\Carbon;

use Intervention\Image\Facades\Image;

use yajra\Datatables\Datatables;

use Activity;
use Auth;

class HemsedalController extends Controller
{
    /**
     * Display a listing of the members.
     *
     * @return Response
     */
    public function index()
    {
        return view('hemsedal.index');
    }

    /**
     * Process index() ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getIndex()
    {
        $participants = Hemsedal::select('id', 'name', 'phone', 'email', 'depPayed', 'allPayed');

        return Datatables::of($participants)
            ->addColumn('action', function ($participant) {

                if ($participant->allPayed == '1') {
                    $btnColor = 'success';
                }
                elseif ($participant->depPayed == '0' AND $participant->allPayed == '0') {
                    $btnColor = 'danger';
                }
                elseif ($participant->depPayed == '1' AND $participant->allPayed == '0') {
                    $btnColor = 'warning';
                }
                else {
                    $btnColor = 'info';
                }

                return '<a href="/hemsedal/edit?id='.$participant->id.'" class="btn btn-'.$btnColor.'"><i class="glyphicon glyphicon-edit"></i> Vis info</a>';
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new participant.
     *
     * @return Response
     */
    public function create()
    {
        $sweater_sizes = ['S' => 'Small', 'M' => 'Medium', 'L' => 'Large', 'XL' => 'X-Large', 'XXL' => 'XX-Large'];
        $bus_home = ['n.a' => 'Gjelder ikke', 'Tidlig' => 'Tidlig', 'Sent' => 'Sent'];

        if (Input::has('memberID')) {
            $query      = Input::get('memberID');

            $participant    = Members::find($query);

            if ($participant) {
                flash()->info('Info hentet fra medlemsregisteret');
                return view('hemsedal.create', compact('participant', 'sweater_sizes', 'bus_home'));
            }
            else{
                flash()->warning('Fant ikke medlemmet, fyll inn info');
            }
        }

        $participant = new Members();
        $participant->id = '';
        $participant->name = '';
        $participant->email = '';
        $participant->phone = '';

        return view('hemsedal.create', compact('participant', 'sweater_sizes', 'bus_home'));
    }

    /**
     * Store a newly created participant.
     *
     * @param  StoreHemsedalRequest  $request
     * @return Response
     */
    public function store(StoreHemsedalRequest $request)
    {
        $storeParticipant = new Hemsedal;

        $storeParticipant->member_id     = $request->id;
        $storeParticipant->name          = $request->name;
        $storeParticipant->phone         = $request->phone;
        $storeParticipant->email         = $request->email;
        $storeParticipant->sweaterSize   = $request->sweaterSize;
        $storeParticipant->busHome       = $request->busHome;
        $storeParticipant->room          = $request->room;

        if ($request->has('depositum')){
            $storeParticipant->depPayed  = 1;
            $storeParticipant->depPayed_at = Carbon::now();
        }

        if ($request->has('completePayment')){
            $storeParticipant->allPayed  = 1;
            $storeParticipant->allPayed_at = Carbon::now();
        }

        $storeParticipant->save();

        flash()->success('Påmelding registrert');

        return \Redirect::action('HemsedalController@index');
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

        $participant = Hemsedal::find($id);
        $sweater_sizes = ['S' => 'Small', 'M' => 'Medium', 'L' => 'Large', 'XL' => 'X-Large', 'XXL' => 'XX-Large'];
        $bus_home = ['n.a' => 'Gjelder ikke', 'Tidlig' => 'Tidlig', 'Sent' => 'Sent'];

        return view('hemsedal.edit', compact('participant', 'sweater_sizes', 'bus_home'));
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

        Hemsedal::where('id', $id)
            ->update(['member_id' => $request->member_id, 'name' => $request->name, 'phone' => $request->phone,
                      'email' => $request->email, 'sweaterSize' => $request->sweaterSize, 'busHome' => $request->busHome, 'room' => $request->room]);

        Activity::log(Auth::user()->getFullName(). ' oppdaterte informasjon om Hemsedalpåmeldt: '.$request->name);
        flash()->success('Informasjon oppdatert.');

        return \Redirect::back();
    }

    /**
     * Update the specified member.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function updateTrip(Request $request)
    {
        if ($request->selection == "removeUnpaid") {
            flash()->success('Test');
        }
        elseif ($request->selection == "newTrip") {
            Hemsedal::truncate();
        }

        flash()->success('Informasjon oppdatert.');

        return \Redirect::back();
    }

    /**
     * Update the paymentstatus of the specified member.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function updatePayment(Request $request, $id)
    {
        if (Input::has('depositum_payment'))
        {
            $participant = Hemsedal::find($id);

            $participant->depPayed = 1;
            $participant->depPayed_at = Carbon::now();

            $participant->save();

            Activity::log(Auth::user()->getFullName(). ' registrerte depositum for Hemsedalpåmeldt: '.$participant->name);
            flash()->success('Betaling av depositum registrert!');

        }
        elseif ($request->has('final_payment'))
        {
            $participant = Hemsedal::find($id);

            $participant->allPayed = 1;
            $participant->allPayed_at = Carbon::now();

            $participant->save();

            Activity::log(Auth::user()->getFullName(). ' registrerte sluttsum for Hemsedalpåmeldt: '.$participant->name);
            flash()->success('Betaling av sluttsum registrert!');

        }

        return \Redirect::back();
    }

    /**
     * Remove the specified participant.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Hemsedal::destroy($id);

        flash()->info('Den påmeldte ble fjernet!');

        return \Redirect::action('HemsedalController@index');
    }

    /**
     * Show and edit settings for all members
     *
     * @return Response
     */
    public function settings()
    {
        $participants       =   Hemsedal::all()->count();

        $matchThese = ['depPayed' => null, 'allPayed' => null];
        $unpaidParticipants =   Hemsedal::OrWhere($matchThese)
                                        ->count();
        return view('settings.hemsedal', compact('participants', 'unpaidParticipants'));
    }

    public function settingsUpdate(Request $request)
    {
        if ($request->_form == 'updateJob')
        {
            VolunteerJobs::where('id', $request->selectedVolunteerJob)
                ->update(['name' => $request->updateJobName]);

            flash()->success('Frivilligjobben ble oppdatert');
        }

        if ($request->_form == 'updateStatus')
        {
            if ($request->memberType == 'vip'){
                Members::whereNotIn('vipGroup', ['Ingen', '�resmedlem'])->update(['vipGroup' => 'Ingen']);

                flash()->success('VIP statusen for samtlige medlemmer er nullstillt');
            }
            elseif ($request->memberType == 'allMembers'){
                Members::whereIn('payed', ['-1', '1'])
                    ->update(['payed' => '2']);

                flash()->success('Betalingsstatus for samtlige medlemmer er nullstillt');
            }
            elseif ($request->memberType == 'halfYear'){
                Members::whereIn('payed', ['-1', '1'])
                    ->whereIn('semesters', ['1'])
                    ->update(['payed' => '2']);

                flash()->success('Betalingsstatusen for halvt�rsmedlemmer er nullstillt');
            }
        }

        return \Redirect::back();
    }

    public function settingsAdd(Request $request)
    {
        if ($request->_form == 'addJob')
        {
            VolunteerJobs::create(['name' => $request->addVolunteerJobName]);

            flash()->success('Frivilligjobb lagt til');
        }

        return \Redirect::back();
    }

    public function settingsDelete(Request $request)
    {
        if ($request->_form == 'deleteJob')
        {
            VolunteerJobs::where('id', $request->deleteVolunteerJob)->delete();

            flash()->info('Frivilligjobben ble fjernet');
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
        $participants   = Hemsedal::select('email')
                                    ->get();

        return view('hemsedal.emails', compact('participants'));
    }

    /**
     * Show the form for editing the specified member.
     *
     * @param  int  $id
     * @return Response
     */
    public function listPhones()
    {
        $participants   = Hemsedal::select('phone', 'name')
                                    ->get();

        return view('hemsedal.phones', compact('participants'));
    }

    public function details()
    {
        //['payed' => '-1'] Member has paid and has card
        //['payed' => '0']  Member has not paid and has no card
        //['payed' => '1']  Member has paid but no card
        //['payed' => '2']  Member has card but not paid

        $numberOfHemsedal       = Hemsedal::all()
            ->count();

        $numberOfCards          = Members::whereIn('payed', ['1'])
            ->count();

        $hemsedalAll            = Hemsedal::all()->count();

        $hemsedalAllPayed       = Hemsedal::where('allPayed', '1')
            ->count();

        $hemsedalOnlyDep       = Hemsedal::where('depPayed', '1')
            ->where('allPayed', '0')
            ->count();

        $hemsedalNothing       = Hemsedal::whereNotIn('depPayed', ['1'])
            ->whereNotIn('allPayed', ['1'])
            ->count();

        $sweaterSizes = Hemsedal::selectRaw('*, count(*)')
            ->where('allPayed', '1')
            ->groupBy('sweaterSize')
            ->get();

        $sweaterSizesAll = Hemsedal::selectRaw('sweaterSize, COUNT(*) as count')
            ->where('depPayed', '1')
            ->groupBy('sweaterSize')
            ->orderBy('count', 'desc')
            ->get();

        $sweaterSizesNotDep = Hemsedal::selectRaw('sweaterSize, COUNT(*) as count')
            ->where('allPayed', '1')
            ->groupBy('sweaterSize')
            ->orderBy('count', 'desc')
            ->get();

        $hemsedalNonMembers       = Hemsedal::where('depPayed', '1')
            ->where('member_id', '0')
            ->count();

        return view('hemsedal.details', compact('numberOfMembers',
            'numberOfVolunteers', 'numberOfHemsedal', 'numberOfCards', 'hemsedalAll', 'hemsedalAllPayed',
            'hemsedalOnlyDep', 'hemsedalNothing', 'sweaterSizesAll', 'sweaterSizesNotDep', 'hemsedalNonMembers'));
    }

    public function search() {
        $query      = Input::get('memberID');
        var_dump($query);

        $member    = Members::find($query)
            ->select('id', 'name', 'phone', 'email')
            ->first();

        $volunteerJobs      = VolunteerJobs::orderBy('name', 'asc')->get();

        if ($member) {
            return view('hemsedal.create', compact('member', 'volunteerJobs'));
            //return \Redirect::to('volunteers/create')->with($member, $volunteerJobs);
            //return view(\Redirect::back(), compact('member', 'volunteerJobs'));
        }
    }
}