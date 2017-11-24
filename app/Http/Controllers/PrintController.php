<?php

namespace App\Http\Controllers;

use App\Hemsedal;
use DateTime;
use Illuminate\Http\Request;

use App\Members;
use App\Departments;
use App\VipGroups;

use URL;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class PrintController extends Controller
{
    public function settings()
    {
        $referrer = URL::current();

        if (strpos($referrer,'hemsedal')) {
            return view('print.hemsedal');
        }
        elseif (strpos($referrer,'members')) {
            return view('print.members');
        }
        elseif (strpos($referrer,'volunteers')) {
            return view('print.volunteers');
        }
    }

    public function printList(Request $request)
    {
        $list = $this->createList($request->list);
        $data = $this->getData($request->list);

        return view('print.output.'.$list->get('list_name'), compact('list', 'data'));
    }

    private function createList($selection)
    {
        $list = collect(['year' => date('Y')]);

        $referrer = URL::current();

        if (strpos($referrer,'hemsedal')) {
            $list->put('list_name', 'hemsedal');

            if ($selection == 'allPayed') {
                $list->put('page-header', 'Alt betalt');
            }
            elseif ($selection == 'onlyDepositum') {
                $list->put('page-header', 'Kun depositum');
            }
            elseif ($selection == 'nothing') {
                $list->put('page-header', 'Ingenting betalt');
            }
            elseif ($selection == 'everyone') {
                $list->put('page-header', 'Alle registrerte');
            }

            return $list;
        }
        elseif (strpos($referrer,'members')) {
            if ($selection == 'GeneralAssembly') {
                $list->put('list_name', 'generalAssembly');
                $list->put('page-header', 'Stemmeberettigede generalforsamling');
                $list->put('limit', Carbon::now()->subDays(30));
            }
            elseif ($selection == 'U20') {
                $list->put('list_name', 'u20');
                $list->put('page-header', 'U20 liste');
                //$list->put('limit', Carbon::now()->subDays(30));
            }

            return $list;
        }
        elseif (strpos($referrer,'volunteers')) {
            $list->put('list_name', 'volunteers');
            return $list;
        }
    }

    private function getData($selection)
    {
        $now = Carbon::now();

        $referrer = URL::current();

        if (strpos($referrer,'hemsedal')) {
            if ($selection == 'allPayed') {
                $matchThese = ['depPayed' => '1', 'allPayed' => '1'];
                $data = Hemsedal::select('name', 'phone', 'sweaterSize', 'busHome', 'room')
                    ->OrWhere($matchThese)
                    ->get();
            }
            elseif ($selection == 'onlyDepositum') {
                $matchThese = ['depPayed' => '1', 'allPayed' => '0'];
                $data = Hemsedal::select('name', 'phone', 'sweaterSize', 'busHome', 'room')
                    ->OrWhere($matchThese)
                    ->get();
            }
            elseif ($selection == 'nothing') {
                $matchThese = ['depPayed' => '0', 'allPayed' => '0'];
                $data = Hemsedal::select('name', 'phone', 'sweaterSize', 'busHome', 'room')
                    ->OrWhere($matchThese)
                    ->get();
            }
            elseif ($selection == 'everyone') {
                $data = Hemsedal::select('name', 'phone', 'sweaterSize', 'busHome', 'room')
                    ->get();
            }
            return $data;
        }
        elseif (strpos($referrer,'members')) {
            if ($selection == 'GeneralAssembly') {
                $notAfter = Carbon::now()->subDays(30);

                $data = Members::select('id', 'name', 'created_at', 'payedDate')
                    ->whereIn('payed', ['-1', '1'])
                    ->whereNotBetween('payedDate', array($notAfter, $now))
					->orderBy('name', 'asc')
                    ->get();
            }
            elseif ($selection == 'U20') {

                $date = new DateTime;
                $date->modify('-20 years');
                $formatted_date = $date->format('Y-m-d H:i:s');

                $data = Members::select('id', 'name', 'birthDate', 'banned', 'banned_to')
                    ->whereIn('payed', ['-1', '1'])
                    ->where('u20','=',1)
                    ->where('birthDate','>=',$formatted_date)
                    ->get();
                //dd($data);
            }

            return $data;
        }
        elseif (strpos($referrer,'volunteers')) {
            return view('print.volunteers');
        }
    }
}