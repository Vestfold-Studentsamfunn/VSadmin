<?php

namespace App\Http\Controllers;

use App\Members;
use App\Departments;
use App\VipGroups;
use App\VolunteerData;
use App\Hemsedal;

use App\Http\Requests;
use App\Http\Requests\StoreMemberProfileRequest;
use App\Http\Requests\UpdateMemberProfileRequest;
use App\Http\Requests\UpdateMemberPaymentRequest;
use App\Http\Requests\UpdateMemberSettingsRequest;

use Auth;
use DB;
use Input;
use Activity;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Carbon\Carbon;

use Intervention\Image\Facades\Image;
use yajra\Datatables\Datatables;

class MembersController extends Controller
{
    /**
     * Display a listing of all the members.
     *
     * @return Response
     */
    public function index()
    {
		return view('members.index');
    }

    /**
     * Process index() ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getIndex()
    {
        $members = Members::select('id', 'name', 'phone', 'email', 'department', 'payed', 'vipGroup');

        return Datatables::of($members)
            ->addColumn('action', function ($member) {

                if ($member->payed == -1) {
                    $btnColor = 'success';
                }
                elseif ($member->payed == 0) {
                    $btnColor = 'danger';
                }
                elseif ($member->payed == 1) {
                    $btnColor = 'warning';
                }
                else {
                    $btnColor = 'info';
                }

                return '<a href="/members/edit?id='.$member->id.'" class="btn btn-block btn-'.$btnColor.'"><i class="glyphicon glyphicon-edit"></i> Vis info</a>';
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new member.
     *
     * @return Response
     */
    public function create()
    {
        $selectDepartment   = Departments::pluck('full_name', 'short_name');
        $selectVipGroup     = VipGroups::pluck('name', 'name');

        return view('members.create', compact('selectDepartment', 'selectVipGroup'));
    }

    /**
     * Store a newly created member.
     *
     * @param  StoreMemberProfileRequest  $request
     * @return Response
     */
    public function store(StoreMemberProfileRequest $request)
    {
        $storeMember = new Members;

        $storeMember->name          = $request->name;
        $storeMember->address       = $request->address;
        $storeMember->postalCode    = $request->postalCode;
        $storeMember->postalArea    = $request->postalArea;
        $storeMember->phone         = $request->phone;
        $storeMember->email         = $request->email;
        $storeMember->birthDate     = Carbon::createFromFormat('d.m.Y', $request->birthDate)->toDateString(); // Result = yyyy-mm-dd
        $storeMember->department    = $request->department;
        $storeMember->semesters     = $request->semesters;

        $image 			    = $request->file('picture');
        $resizedImage 	    = $this->resizeImage($image, 300, 400);
        $resizedImagePath   = $resizedImage->dirname. '/' .$resizedImage->basename;

        $storeMember->imageType   = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $resizedImagePath);
        $storeMember->imageSize   = filesize($resizedImagePath);
        $storeMember->imageBlob   = file_get_contents($resizedImagePath);

        @unlink($resizedImagePath);

        $storeMember->save();

        flash()->success('Medlem opprettet');
        return \Redirect::action('MembersController@edit', ['id' => $storeMember->id]);
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

        $member = Members::find($id);

        $selectDepartment   = Departments::pluck('full_name', 'short_name');
        $selectVipGroup     = VipGroups::pluck('name', 'name');

        $memberAge = Carbon::now()->diffInYears($member->birthDate);

        if ($member->banned == 1) {
            $banned_from = $member->banned_from->format('d.m.Y');
            $banned_to = $member->banned_to->format('d.m.Y');
            $panel_type = "panel-red";
            $banned = 1;
        } else {
            $banned_from = null;
            $banned_to = null;
            $panel_type = "panel-default";
            $banned = 0;
        }

        return view('members.edit', compact('member', 'selectDepartment', 'selectVipGroup', 'memberAge',
            'banned_from', 'banned_to', 'panel_type', 'banned'));
    }

    /**
     * Update the specified member.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(UpdateMemberProfileRequest $request)
    {
        $id = Input::get('id');
        $updateMember = Members::find($id);

        if (!($request->rotateLeft or $request->rotateRight))
        {
            $updateMember->name         = $request->name;
            $updateMember->address      = $request->address;
            $updateMember->postalCode   = $request->postalCode;
            $updateMember->postalArea   = $request->postalArea;
            $updateMember->phone        = $request->phone;
            $updateMember->email        = $request->email;
            $updateMember->birthDate    = Carbon::createFromFormat('d.m.Y', $request->birthDate)->toDateString(); // Result = yyyy-mm-dd
            $updateMember->department   = $request->department;
            $updateMember->semesters    = $request->semesters;


            if ($request->hasFile('picture'))
            {
                $image 			    = $request->file('picture');
                $resizedImage 	    = $this->resizeImage($image, 300, 400);
                $resizedImagePath   = $resizedImage->dirname. '/' .$resizedImage->basename;

                $updateMember->imageType   = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $resizedImagePath);
                $updateMember->imageSize   = filesize($resizedImagePath);
                $updateMember->imageBlob   = file_get_contents($resizedImagePath);

                @unlink($resizedImagePath);
            }

            Activity::log(Auth::user()->getFullName(). ' oppdaterte infomasjonen om medlem '.$id);
            flash()->success('Informasjon oppdatert');
        }

        if ($request->rotateLeft)
        {
            $image 			    = $updateMember->imageBlob;
            $rotatedImage 	    = $this->rotateImage($image, 90);
            $rotatedImagePath   = $rotatedImage->dirname. '/' .$rotatedImage->basename;

            $updateMember->imageType   = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $rotatedImagePath);
            $updateMember->imageSize   = filesize($rotatedImagePath);
            $updateMember->imageBlob   = file_get_contents($rotatedImagePath);

            @unlink($rotatedImagePath);
        }
        elseif ($request->rotateRight)
        {
            $image 			    = $updateMember->imageBlob;
            $rotatedImage 	    = $this->rotateImage($image, -90);
            $rotatedImagePath   = $rotatedImage->dirname. '/' .$rotatedImage->basename;

            $updateMember->imageType   = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $rotatedImagePath);
            $updateMember->imageSize   = filesize($rotatedImagePath);
            $updateMember->imageBlob   = file_get_contents($rotatedImagePath);

            @unlink($rotatedImagePath);
        }

        $updateMember->save();

        return \Redirect::back();
    }

    /**
     * Update the paymentstatus of the specified member.
     *
     * @param  UpdateMemberPaymentRequest  $request
     * @param  int  $id
     * @return Response
     */
    public function updatePayment(UpdateMemberPaymentRequest $request, $id)
    {
        $member = Members::find($id);

        if ($request->registerPayment == 1)
        {
            if ($member->payed == 0)
            {
                $member->payed = 1;
            }
            elseif ($member->payed == 2)
            {
                $member->payed = -1;
            }

            $member->payedDate = Carbon::now();
            Activity::log(Auth::user()->getFullName(). ' registrerte betaling av medlem '.$id);
            flash()->success('Betaling registrert!');
        }
        elseif ($request->printNewCard == 1)
        {
            $member->payed      = 1;
            $member->cardNumber = 0;
            Activity::log(Auth::user()->getFullName(). ' skrev ut nytt kort for medlem  '.$id);
            flash()->info('Nytt kort vil bli skrevet ut');
        }

        $member->save();

        return \Redirect::back();
    }

    /**
     * Update the settings of the specified member.
     *
     * @param  UpdateMemberSettingsRequest  $request
     * @param  int  $id
     * @return Response
     */
    public function updateMemberSettings(UpdateMemberSettingsRequest $request, $id)
    {
        $memberSettings = Members::find($id);

        $memberSettings->cardNumber = $request->cardNumber;
        $memberSettings->vipGroup   = $request->vipGroup;
        $memberSettings->u20        = $request->u20;
        $memberSettings->noEmail    = $request->noEmail;
        $memberSettings->noPhone    = $request->noPhone;
        $memberSettings->banned     = $request->banned;

        if ($request->banned == 1) {
            $memberSettings->banned_from    = Carbon::createFromFormat('d.m.Y', $request->banned_from)->toDateString(); // Result = yyyy-mm-dd
            $memberSettings->banned_to    = Carbon::createFromFormat('d.m.Y', $request->banned_to)->toDateString(); // Result = yyyy-mm-dd
        }

        $memberSettings->save();

        Activity::log(Auth::user()->getFullName(). ' oppdaterte infomasjonen om medlem '.$id);
        flash()->success('Informasjon oppdatert');

        return \Redirect::back();
    }

    /**
     * Remove the specified member.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Members::destroy($id);
        flash()->success('Medlemmet ble slettet!');
        return \Redirect::action('MembersController@index');
    }

    /**
     * Proxy for displaying image of the specified member from database
     *
     * @param  int  $id
     * @return Response
     */
    public function showImage($id)
    {
        $memberImage = Members::find($id);

        return response($memberImage->imageBlob)
            ->header('Content-Type', $memberImage->imageType)
            ->header('Content-length', $memberImage->imageSize);
    }

    /**
     * Show and edit settings for all members
     *
     * @return Response
     */
    public function settings()
    {
        $selectDepartment   = Departments::pluck('full_name', 'short_name');
        $selectVipGroup     = VipGroups::pluck('name', 'name');

        $members =      Members::whereIn('payed', ['-1', '1'])
                               ->count();

        $vip =          Members::whereIn('payed', ['-1', '1'])
                               ->whereNotIn('vipGroup', ['Ingen', 'Æresmedlem'])
                               ->count();

        $halfYear =     Members::whereIn('payed', ['-1', '1'])
                               ->whereIn('semesters', ['1'])
                               ->count();

        return view('settings.members', compact('selectDepartment', 'selectVipGroup', 'members', 'vip', 'halfYear'));
    }

    public function settingsUpdate(Request $request)
    {
        if ($request->_form == 'updateFaculty')
        {
            Departments::where('short_name', $request->selectedDepartment)
                ->update(['short_name' => $request->updateDepartmentShortName, 'full_name' => $request->updateDepartmentFullName]);

            Members::where('department', $request->selectedDepartment)
                ->update(['department' => $request->updateDepartmentShortName]);

            Activity::log(Auth::user()->getFullName(). ' oppdaterte informasjonen om fakultetet '.$request->selectedDepartment);
            flash()->success('Fakultetet ble lagret og eksisterende medlemmer er oppdatert');
        }

        if ($request->_form == 'updateVipGroup')
        {
            VipGroups::where('name', $request->selectedVipGroup)
                ->update(['name' => $request->updateVipGroup]);

            Members::where('vipGroup', $request->selectedVipGroup)
                ->update(['vipGroup' => $request->updateVipGroup]);

            Activity::log(Auth::user()->getFullName(). ' oppdaterte informasjonen om VIP-gruppen '.$request->selectedVipGroup);
            flash()->success('VIP gruppen ble lagret og eksisterende medlemmer er oppdatert');
        }

        if ($request->_form == 'updateStatus')
        {
            if ($request->memberType == 'vip'){
                Members::whereNotIn('vipGroup', ['Ingen', 'Æresmedlem'])->update(['vipGroup' => 'Ingen']);

                Activity::log(Auth::user()->getFullName(). ' nullstillte alle VIP');
                flash()->info('VIP statusen for samtlige medlemmer er nullstillt');
            }
            elseif ($request->memberType == 'allMembers'){
                Members::whereIn('payed', ['-1', '1'])
                    ->update(['payed' => '2']);

                Activity::log(Auth::user()->getFullName(). ' nullstillte betalingsstatus for alle medlemmer');
                flash()->info('Betalingsstatus for samtlige medlemmer er nullstillt');
            }
            elseif ($request->memberType == 'halfYear'){
                Members::whereIn('payed', ['-1', '1'])
                    ->whereIn('semesters', ['1'])
                    ->update(['payed' => '2']);

                Activity::log(Auth::user()->getFullName(). ' nullstillte betalingsstatus for alle halvtårsmedlemmer');
                flash()->info('Betalingsstatusen for halvtårsmedlemmer er nullstillt');
            }
        }

        return \Redirect::back();
    }

    public function settingsAdd(Request $request)
    {
        if ($request->_form == 'addFaculty')
        {
            Departments::create(['short_name' => $request->addDepartmentShortName, 'full_name' => $request->addDepartmentFullName]);
            Activity::log(Auth::user()->getFullName(). ' la til fakultetet '.$request->addDepartmentShortName);
            flash()->success('Fakultet lagt til');
        }

        if ($request->_form == 'addVipGroup')
        {
            VipGroups::create(['name' => $request->addVipGroup]);
            Activity::log(Auth::user()->getFullName(). ' la til VIP-gruppen '.$request->addVipGroup);
            flash()->success('VIP gruppe lagt til');
        }

        return \Redirect::back();
    }

    public function settingsDelete(Request $request)
    {
        if ($request->_form == 'deleteFaculty')
        {
            Departments::where('short_name', $request->deleteDepartment)->delete();
            Activity::log(Auth::user()->getFullName(). ' slettet fakultetet '.$request->deleteDepartment);
            flash()->success('Fakultet ble slettet');
        }

        if ($request->_form == 'deleteVipGroup')
        {
            VipGroups::where('name', $request->deleteVipGroup)->delete();
            Activity::log(Auth::user()->getFullName(). ' slettet VIP-gruppen '.$request->deleteVipGroup);
            flash()->success('VIP gruppen ble slettet');
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
        $members             = Members::select('email', 'noEmail')
                                        ->whereIn('payed', ['-1', '1'])
                                        ->whereNotIn('noEmail', ['1'])
                                        ->get();

        $selectDepartment   = Departments::pluck('full_name', 'short_name');
        $selectVipGroup     = VipGroups::pluck('name', 'name');

        return view('members.emails', compact('members', 'selectDepartment', 'selectVipGroup'));
    }

    /**
     * Show the form for editing the specified member.
     *
     * @param  int  $id
     * @return Response
     */
    public function listPhones()
    {
        $members             = Members::select('phone', 'noPhone')
                                        ->whereIn('payed', ['-1', '1'])
                                        ->whereNotIn('noPhone', ['1'])
                                        ->get();

        $selectDepartment   = Departments::pluck('full_name', 'short_name');
        $selectVipGroup     = VipGroups::pluck('name', 'name');

        return view('members.phones', compact('members', 'selectDepartment', 'selectVipGroup'));
    }

     public function details()
    {
        //['payed' => '-1'] Member has paid and has card
        //['payed' => '0']  Member has not paid and has no card
        //['payed' => '1']  Member has paid but no card
        //['payed' => '2']  Member has card but not paid

        $numberOfMembers        = Members::whereIn('payed', ['-1', '1'])
            ->count();

        $numberOfVolunteers     = VolunteerData::all()->count('name');

        $numberOfHemsedal       = Hemsedal::whereIn('depPayed', ['1'])
            ->count();

        $numberOfCards          = Members::whereIn('payed', ['1'])
            ->count();

        $numberOfDepartments    = Members::select(DB::raw('count(department) as amount, department'))
            ->whereIn('payed', ['-1', '1'])
            ->groupBy('department')
            ->orderBy('department', 'asc')
            ->get();

        $unpaidMembers          = Members::limit(10)->whereNotIn('payed', ['-1', '1'])
            ->orderBy('created_at', 'desc')
            ->get();

        $cardsWithoutNumber     = Members::limit(5)->where('payed', '-1')
            ->where('cardNumber', '0')
            ->orderBy('created_at', 'desc')
            ->get();

        $ageGroups              = $this->getAgeGroups();

        $registrations = Members::whereIn('payed', ['-1', '1'])
            ->whereNotIn('vipGroup', ['Ingen'])
            ->orWhereIn('vipGroup', ['Æresmedlem'])
            ->select('vipGroup', DB::raw('count(*) as total'))
            ->groupBy('vipGroup')
            ->pluck('total','vipGroup')->all();

        $payments = Members::whereIn('payed', ['-1', '1'])
            ->whereNotIn('vipGroup', ['Ingen'])
            ->orWhereIn('vipGroup', ['Æresmedlem'])
            ->select('vipGroup', DB::raw('count(*) as total'))
            ->groupBy('vipGroup')
            ->pluck('total','vipGroup')->all();

        $vipCount = Members::whereIn('payed', ['-1', '1'])
            ->whereNotIn('vipGroup', ['Ingen'])
            ->orWhereIn('vipGroup', ['Æresmedlem'])
            ->select('vipGroup', DB::raw('count(*) as total'))
            ->groupBy('vipGroup')
            ->pluck('total','vipGroup')->all();

        $banned = Members::whereIn('payed', ['-1', '1'])
            ->whereIn('banned', ['1'])
            ->orderBy('banned_to', 'desc')
            ->pluck('banned_to','name')
            ->all();

        $halfYear =     Members::whereIn('payed', ['-1', '1'])
            ->whereIn('semesters', ['1'])
            ->count();

        return view('members.details', compact('numberOfMembers', 'numberOfVolunteers', 'numberOfHemsedal', 'numberOfCards',
            'numberOfDepartments', 'ageGroups', 'unpaidMembers', 'cardsWithoutNumber', 'halfYear', 'vipCount', 'banned'));

        //return view('members.details', compact('numberOfMembers', 'numberOfVip', 'numberOfCards', 'numberOfDepartments', 'ageGroups'));
    }



    public function search() {
        $query      = Input::get('searchKeyWords');
        $members    = Members::where('name', 'LIKE', '%'. $query .'%')
                                ->orWhere('email', 'LIKE', '%'. $query .'%')
                                ->orWhere('phone', 'LIKE', '%'. $query .'%')
                                ->select('id', 'name', 'phone', 'email', 'department', 'payed', 'payedDate', 'created_at')
                                ->get();

        $title = 'Viser resultater for: <strong>' .$query. '</strong>';

        return view('members.index', compact('members', 'title'));
    }

    /**
     * Resize the picture of the specified member.
     *
     * @param  image  $image
     * @param  int  $width
     * @param  int  $height
     * @return Response
     */
    private function resizeImage($image, $width, $height)
    {
        try
        {
            $imageRealPath 	= 	$image->getRealPath();
            $tmpName 	    = 	$image->getFileName();

            $img = Image::make($imageRealPath);
            $img->resize(intval($width), intval($height), function($constraint) {
                $constraint->aspectRatio();
            });

            @unlink($imageRealPath);

            return $img->save(public_path('tmp'). '/'. $tmpName. '.jpg');
        }
        catch(Exception $e)
        {
            return false;
        }

    }

    /**
     * Rotate the picture of the specified member.
     *
     * @param  image  $image
     * @param  float $angle
     * @return Response
     */
    private function rotateImage($image, $angle)
    {
        try
        {
            $tmpName = Image::make($image);
            $tmpName->rotate($angle);

            return $tmpName->save(public_path('tmp'). '/'. $tmpName. '.jpg');
        }
        catch(Exception $e)
        {
            return false;
        }

    }

    private function getAgeGroups()
    {
        $membersDOB             = Members::select('birthDate')
            ->whereIn('payed', ['-1', '1'])
            ->get();

        foreach ($membersDOB as $key => $data) {
            $membersDOB[$key] = Carbon::now()->diffInYears($data->birthDate);
        }

        $membersDOB = array_count_values($membersDOB->toArray());

        $ageGroups = [
            "U20"   => null,
            "20"    => null,
            "21"    => null,
            "22"    => null,
            "23"    => null,
            "24"    => null,
            "25"    => null,
            "26"    => null,
            "27"    => null,
            "28"    => null,
            "29"    => null,
            "30+"    => null,
        ];

        foreach($membersDOB as $key => $data)
        {
            if ($key <= 19) {
                $ageGroups['U20'] += $membersDOB[$key];
            }
            elseif ($key == 20) {
                $ageGroups['20'] += $membersDOB[$key];
            }
            elseif ($key == 21) {
                $ageGroups['21'] += $membersDOB[$key];
            }
            elseif ($key == 22) {
                $ageGroups['22'] += $membersDOB[$key];
            }
            elseif ($key == 23) {
                $ageGroups['23'] += $membersDOB[$key];
            }
            elseif ($key == 24) {
                $ageGroups['24'] += $membersDOB[$key];
            }
            elseif ($key == 25) {
                $ageGroups['25'] += $membersDOB[$key];
            }
            elseif ($key == 26) {
                $ageGroups['26'] += $membersDOB[$key];
            }
            elseif ($key == 27) {
                $ageGroups['27'] += $membersDOB[$key];
            }
            elseif ($key == 28) {
                $ageGroups['28'] += $membersDOB[$key];
            }
            elseif ($key == 29) {
                $ageGroups['29'] += $membersDOB[$key];
            }
            elseif ($key >= 30) {
                $ageGroups['30+'] += $membersDOB[$key];
            }
        }

        return $ageGroups;
    }
}