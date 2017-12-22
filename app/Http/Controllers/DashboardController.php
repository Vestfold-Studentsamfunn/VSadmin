<?php

namespace App\Http\Controllers;

use App\VolunteerJobs;
use Illuminate\Http\Request;

use DB;
use App\Models\Members;
use App\VolunteerData;
use App\Hemsedal;
use App\Http\Requests;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
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

        return view('dashboard', compact('numberOfMembers', 'numberOfVolunteers', 'numberOfHemsedal', 'numberOfCards',
                                        'numberOfDepartments', 'ageGroups', 'unpaidMembers', 'cardsWithoutNumber'));
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
