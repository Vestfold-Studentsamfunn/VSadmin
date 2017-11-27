<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;

use App\Http\Requests\SMSValidator;

use Exception;
use Illuminate\Support\Facades\Input;
use Request;

use App\Http\Requests;
use Response;

use App\Members;
use App\Departments;
use App\VipGroups;
use App\VolunteerData;
use App\VolunteerJobs;
use App\Hemsedal;

class SMSController extends Controller
{
    /**
     * Display a listing of the members.
     *
     * @return Response
     */
    public function single()
    {
        if (\Request::ajax()) {
            $vipGroups = [];
            $departments = [];

            if (Input::has('vip')){
                foreach(Input::get('vip') as $vipGroupID) {
                    $vipGroup = VipGroups::find($vipGroupID);
                    $vipGroups[] = $vipGroup->name;
                }
            }

            if (Input::has('department')){
                foreach(Input::get('department') as $departmentID) {
                    $department = Departments::find($departmentID);
                    $departments[] = $department->short_name;
                }
            }

            $query = Members::select('phone');
            $query->whereIn('payed', ['-1', '1']);
            $query->whereNotIn('noPhone', ['1']);

            if($vipGroups)
            {
                $query->whereIn('vipGroup', $vipGroups);
            }

            if($departments)
            {
                $query->whereIn('department', $departments);
            }

            $query->distinct('phone');

            $members = $query->get();

            return $members;
            //return $vipGroups;
            //return json_encode($members);
        }
        else {
            $departments   = Departments::all();
            $vipGroups = VipGroups::all();

            return view('sms.single', compact('departments', 'vipGroups'));
        }


    }

    /**
     * Display a listing of the members.
     *
     * @return Response
     */
    public function members()
    {
        if (\Request::ajax()) {
            $vipGroups = [];
            $departments = [];

            if (Input::has('vip')){
                foreach(Input::get('vip') as $vipGroupID) {
                    $vipGroup = VipGroups::find($vipGroupID);
                    $vipGroups[] = $vipGroup->name;
                }
            }

            if (Input::has('department')){
                foreach(Input::get('department') as $departmentID) {
                    $department = Departments::find($departmentID);
                    $departments[] = $department->short_name;
                }
            }

            $query = Members::select('phone');
            $query->whereIn('payed', ['-1', '1']);
            $query->whereNotIn('noPhone', ['1']);

            if($vipGroups)
            {
                $query->whereIn('vipGroup', $vipGroups);
            }

            if($departments)
            {
                $query->whereIn('department', $departments);
            }

            $query->distinct('phone');

            $members = $query->get();

            return $members;
            //return $vipGroups;
            //return json_encode($members);
        }
        else {
            $departments   = Departments::all();
            $vipGroups = VipGroups::all();

            return view('sms.members', compact('departments', 'vipGroups'));
        }


    }

    /**
     * Display a listing of the members.
     *
     * @return Response
     */
    public function hemsedal()
    {
        if (\Request::ajax()) {
            if (Input::has('paymentStatus')){

                $query = Hemsedal::select('phone');

                foreach(Input::get('paymentStatus') as $status) {

                    if($status == 'unpaid')
                    {
                        $matchThese = ['depPayed' => '0', 'allPayed' => '0'];
                        $query->OrWhere($matchThese);
                    }

                    if($status == 'depositum')
                    {
                        $matchThese = ['depPayed' => '1', 'allPayed' => '0'];
                        $query->OrWhere($matchThese);
                    }

                    if($status == 'allPayed')
                    {
                        $matchThese = ['depPayed' => '1', 'allPayed' => '1'];
                        $query->OrWhere($matchThese);
                    }
                }
                $query->distinct('phone');

                $members = $query->get();

                return $members;
            }
        }
        else {
            return view('sms.hemsedal');
        }
    }

    /**
     * Display a listing of the members.
     *
     * @return Response
     */
    public function volunteers()
    {

        $volunteers = VolunteerData::select('id', 'name', 'phone')
            ->distinct('phone')
            ->get();

        $volunteerJobs  = VolunteerJobs::orderBy('name', 'asc')->get();

        return view('sms.volunteers', compact('volunteers', 'volunteerJobs'));
    }

    public function send_SMS(SMSValidator $request)
    {
        $smsUsername    = env('SMS_USERNAME');
        $smsPassword    = env('SMS_PASSWORD');
        $smsSender      = env('SMS_SENDER');

        if (Input::has('sms_from')){
            $smsSender = $request->sms_from;
        }

        $number     = $request->number;
        $message    = $request->message;

        // Check if Target number is empty.
        if (!$number) {
            $response = [
                'status' => 'error',
                'notification' => 'Meldingen har ingen mottaker!'
            ];

            return Response::json($response);
        }

        // Check if SMS is empty.
        if (!$message) {
            flash()->warning('OBS! Meldingen er tom.');
            return \Redirect::back();
        }

        // Create SMS object with params.
        $sms = new SMS($smsUsername, $smsPassword);

        if(Request::ajax()) {
            try {
                // Send SMS through the HTTP API.
                $result = $sms->Send($smsSender, $number, $message);

                // Check result object returned and give response to end user according to success or not.
                if ($result->success == true) {
                    return Response::json([
                        'status' => 'success',
                        'id' => $number,
                        'msg' => 'Sendt!'
                    ]);
                } else {
                    return Response::json([
                        'status' => 'error',
                        'id' => $number,
                        'msg' => 'Feil!' . $result->errorCode . ' : ' . $result->errorMessage
                    ]);
                }

            } catch (Exception $e) {
                //Error occurred while connecting to server.
                $message = $e->getMessage();

                //Give response to end user.
                $response = [
                    'status' => 'exception',
                    'msg' => 'Feil under sending av SMS! '. $message
                ];

                return Response::json($response);
            }
        }
    }
}

class SMS
{
    private $username;
    private $password;

    /*
     * Constructor with username and password to ViaNett gateway.
     * @param string $Username
     * @param string $Password
     */
    public function __construct($username, $password)
    {
        $this->username  = $username;
        $this->password  = $password;
    }

    /*
     * Send SMS message through the ViaNett HTTP API.
     * @param string $MsgSender
     * @param string $DestinationAddress
     * @param string $Message
     * @return Result $Result
     */
    public function Send($msgSender, $destinationAddress, $message)
    {
        // Build URL request for sending SMS.
        $url = "https://smsc.vianett.no/V3/CPA/MT/MT.ashx?username=%s&password=%s&tel=%s";
        $url = sprintf($url, $this->username, $this->password, $destinationAddress);

        $url .= "&SenderAddress=" . $msgSender;
        $url .= "&SenderAddressType=5";

        $min = 1;
        $max = 16777216;
        $refNo = rand ( $min , $max );
        $url .= "&msgid=".$refNo;

        $url .= "&msg=".$message;

        // Enable for URL debugging
        //dd($url);

        // Get response as xml.
        $xmlResponse = $this->GetResponseAsXML($url);
        // Parse XML.
        $result = $this->ParseXMLResponse($xmlResponse);

        //Fake result, disable both lines above first
        //$result = new Result;
        //$result->success = true;

        // Return the result object.
        return $result;
    }

    /*
     * Gets the respone from the given URL, and return the response as xml.
     * @param string $url
     * @return object Response as xml
     */
    private function GetResponseAsXML($url)
    {
        try {
            // Download webpage and return response as xml.
            return simplexml_load_file($url);
        } catch (Exception $e) {
            // Failed to connect to server. Throw an exception with a customized message.
            throw new Exception('Error occured while connecting to server: ' . $e->getMessage());
        }
    }

    /*
     * Parses the XML response
     * @param objec $XMLResponse
     * @return Result $Result
     */
    private function ParseXMLResponse($xmlResponse)
    {
        $result = new Result;
        $result->errorCode = $xmlResponse[0]["errorcode"];
        $result->errorMessage = $xmlResponse[0];
        $result->success = ($xmlResponse[0]["errorcode"] == 200);

        return $result;
    }
}

/*
 * The result object which is returned by the SendSMS function in the package ViaNettSMS.
 * @package Result
 */
class Result
{
    public $success;
    public $errorCode;
    public $errorMessage;
}