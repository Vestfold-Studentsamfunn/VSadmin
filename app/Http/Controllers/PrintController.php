<?php

namespace App\Http\Controllers;

use App\Hemsedal;
use DateTime;
use Illuminate\Http\Request;

use App\Models\Members;
use App\Departments;
use App\VipGroups;

use URL;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class PrintController extends Controller
{
    protected function members()
    {
        return view('print.members');
    }

    protected function volunteers()
    {
        return view('print.volunteers');
    }

    protected function hemsedal()
    {
        return view('print.hemsedal');
    }

    protected function printList(Request $request)
    {
        $list = $this->createList($request);
        $data = $this->getData($request);

        return view('print.output.' . $list->get('listName'), compact('list', 'data'));
    }

    private function createList($selection)
    {
        $list = collect(['year' => date('Y')]);

        switch ($selection->typeOfList) {
            case 'members':
                switch ($selection->nameOfList) {
                    case 'GeneralAssembly':
                        $list->put('listName', 'generalAssembly');
                        $list->put('title', 'Stemmeberettigede generalforsamling');
                        $list->put('limit', Carbon::now()->subDays(30)->format('d.m.Y'));
                        break;

                    case 'U20':
                        $list->put('listName', 'u20');
                        $list->put('title', 'U20 liste');
                        $list->put('limit', Carbon::now()->subYears(20)->format('d.m.Y'));
                        break;

                    default:
                        //
                        break;
                }
                break;

            case 'volunteers':
                $list->put('listName', 'volunteers');
                //
                break;

            case 'hemsedal':
                $list->put('listName', 'hemsedal');

                switch ($selection->nameOfList) {
                    case 'allPayed':
                        $list->put('title', 'Alt betalt');
                        break;

                    case 'onlyDepositum':
                        $list->put('title', 'Kun depositum');
                        break;

                    case 'nothing':
                        $list->put('title', 'Ingenting betalt');
                        break;

                    case 'everyone':
                        $list->put('title', 'Alle registrerte');
                        break;

                    default:
                        //
                        break;
                }
                break;

            default:
                //
                break;
        }

        return $list;
    }

    private function getData($selection)
    {
        $now = Carbon::now();
        $data = NULL;

        switch ($selection->typeOfList) {
            case 'members':
                switch ($selection->nameOfList) {
                    case 'GeneralAssembly':
                        $notAfter = Carbon::now()->subDays(30);

                        $data = Members::select('id', 'name', 'created_at', 'payedDate')
                            ->whereIn('payed', ['-1', '1'])
                            ->whereNotBetween('payedDate', array($notAfter, $now))
                            ->orderBy('name', 'asc')
                            ->get();
                        break;

                    case 'U20':
                        $data = Members::select('id', 'name', 'birthDate', 'banned', 'banned_to')
                            ->whereIn('payed', ['-1', '1'])
                            ->where('u20', '=', 1)
                            ->where('birthDate', '>', $now->subYears(20))
                            ->get();
                        break;

                    default:
                        //
                        break;
                }
                break;

            case 'volunteers':
                //
                break;

            case 'hemsedal':
                switch ($selection->nameOfList) {
                    case 'allPayed':
                        $data = Hemsedal::select('name', 'phone', 'sweaterSize', 'busHome', 'room')
                            ->where('allPayed', '1')
                            ->get();
                        break;

                    case 'onlyDepositum':
                        $data = Hemsedal::select('name', 'phone', 'sweaterSize', 'busHome', 'room')
                            ->where(['depPayed' => '1', 'allPayed' => '0'])
                            ->get();
                        break;

                    case 'nothing':
                        $data = Hemsedal::select('name', 'phone', 'sweaterSize', 'busHome', 'room')
                            ->OrWhere(['depPayed' => '0', 'allPayed' => '0'])
                            ->get();
                        break;

                    case 'everyone':
                        $data = Hemsedal::select('name', 'phone', 'sweaterSize', 'busHome', 'room')
                            ->get();
                        break;

                    default:
                        //
                        break;
                }
                break;

            default:
                //
                break;
        }

        return $data;
    }
}
