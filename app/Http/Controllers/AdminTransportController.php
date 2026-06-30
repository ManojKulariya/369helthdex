<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\City;
use App\Models\Category;
use App\Models\Setting;
use App\Models\PaymentGateway;
use App\Models\Orders;
use App\Models\Package;
use App\Models\Parameter;
use App\Models\Profiles;
use App\Models\Transport;
use App\Models\Popular_package;
use Session;
use App\Models\News;
use Hash;
use Mail;
use Auth;
use DateTimeZone;
use DateTime;
use App\Models\Contactus;
use DataTables;

class AdminTransportController extends Controller
{
    public function show_login()
    {
        $setting = Setting::find(1);
        return view("transport.login")->with("setting", $setting);
    }
    public function post_login(Request $request)
    {
        $checkuser = User::where("email", $request->get("email"))->where("password", $request->get("password"))->where("user_type", '7')->first();
        if ($checkuser) {
            Auth::login($checkuser, true);
            Session::put("id", $checkuser->id);
            Session::put("name", $checkuser->name);
            $setting = Setting::find(1);
            Session::put("is_rtl", $setting->is_rtl);
            Session::put("is_demo", $setting->is_demo);
            Session::put("logo", asset('public/img') . '/' . $setting->footer_logo);
            Session::put("favicon", asset('public/img') . '/' . $setting->favicon);
            if ($request->get("rem_me") == 1) {
                setcookie('email', $request->get("email"), time() + (86400 * 30), "/");
                setcookie('password', $request->get("password"), time() + (86400 * 30), "/");
                setcookie('remember', 1, time() + (86400 * 30), "/");
            }
            return redirect()->route("transport-admin-dashboard");
        } else {
            Session::flash('message', __('message.Login credentials are wrong'));
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
    }
    public function show_dashboard()
    {
        $totalcategory = count(Transport::where("status", 2)->get());
        $totalcity = count(City::get());
        $getcurrency = Setting::find(1);
        $currency = explode("-", $getcurrency->currency);
        $totalsales = Orders::sum('final_total');
        $totalorder = count(Transport::all());
        $completeorder = count(Transport::where("status", "1")->get());
        $pendingorders = count(Transport::where("status", 0)->get());
        $totalusers = count(User::whereIn("user_type", ['5', '6','8'])->get());
        $totalmanager = count(User::where("user_type", "2")->get());
        $totalpackage = count(Package::all());
        $totalprofile = count(Profiles::all());
        $totalparameter = count(Parameter::all());
        $totalpopular = count(Popular_package::all());

        return view("transport.dashboard")->with("totalcategory", $totalcategory)->with("totalcity", $totalcity)->with("totalsales", $totalsales)->with("currency", $currency[1])->with("totalorder", $totalorder)->with("completeorder", $completeorder)->with("pendingorders", $pendingorders)->with("totalusers", $totalusers)->with("totalmanager", $totalmanager)->with("totalpackage", $totalpackage)->with("totalprofile", $totalprofile)->with("totalparameter", $totalparameter)->with("totalpopular", $totalpopular);
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('transport-login');
    }
    
    static public function generate_timezone_list()
    {
        static $regions = array(
        DateTimeZone::AFRICA,
        DateTimeZone::AMERICA,
        DateTimeZone::ANTARCTICA,
        DateTimeZone::ASIA,
        DateTimeZone::ATLANTIC,
        DateTimeZone::AUSTRALIA,
        DateTimeZone::EUROPE,
        DateTimeZone::INDIAN,
        DateTimeZone::PACIFIC,
        );

        $timezones = array();
        foreach ($regions as $region) {
            $timezones = array_merge($timezones, DateTimeZone::listIdentifiers($region));
        }

        $timezone_offsets = array();
        foreach ($timezones as $timezone) {
            $tz = new DateTimeZone($timezone);
            $timezone_offsets[$timezone] = $tz->getOffset(new DateTime);
        }

        asort($timezone_offsets);

        $timezone_list = array();

        foreach ($timezone_offsets as $timezone => $offset) {
            $offset_prefix = $offset < 0 ? '-' : '+';
            $offset_formatted = gmdate('H:i', abs($offset));
            $pretty_offset = "UTC${offset_prefix}${offset_formatted}";
            $timezone_list[] = "(${pretty_offset}) $timezone";
        }

        return $timezone_list;
        ob_end_flush();
    }
   
}
