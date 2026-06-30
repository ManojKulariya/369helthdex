<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\City;
use App\Models\Category;
use Session;
use Auth;
use DB;
class ManagerController extends Controller
{
    public function show_manager_login()
    {
        return view("manager.login");
    }
    public function post_login(Request $request)
    {
        $checkuser = User::where("email", $request->get("email"))
            ->where("password", $request->get("password"))
            ->where(function ($query) {
                $query->where("user_type", '2')
                    ->orWhere("user_type", '4');
            })
            ->first();

        if ($checkuser) {
            Auth::login($checkuser, true);
            Session::put("id", $checkuser->id);
            Session::put("name", $checkuser->name);
            if ($request->get("rem_me") == 1) {
                setcookie('email', $request->get("email"), time() + (86400 * 30), "/");
                setcookie('password', $request->get("password"), time() + (86400 * 30), "/");
                setcookie('remember', 1, time() + (86400 * 30), "/");
            }
            return redirect()->route("manager-dashboard");
        } else {
            Session::flash('message', __('message.Login credentials are wrong'));
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
    }
    public function show_manager_dashboard()
    {
         $user = User::whereNull('deleted_at')->where('sample_branch', Auth::user()->id)->where("user_type", '4')->get();
       
        $totalorder = count(DB::table('orders')->select('orders.id', 'orders.user_id', 'orders.sample_collection_address_id', 'orders.date', 'orders.time', 'orders.payment_method', 'orders.final_total', 'orders.status')->orderby('orders.id', 'DESC')->join('user_addresses', 'user_addresses.id', '=', 'orders.sample_collection_address_id')->where('orders.manager_id', Auth::user()->id)->get());
        $totalcomplete = count(DB::table('orders')->select('orders.id', 'orders.user_id', 'orders.sample_collection_address_id', 'orders.date', 'orders.time', 'orders.payment_method', 'orders.final_total', 'orders.status')->orderby('orders.id', 'DESC')->join('user_addresses', 'user_addresses.id', '=', 'orders.sample_collection_address_id')->where('orders.status', '7')->where('orders.manager_id', Auth::user()->id)->get());
        $totalpending = count(DB::table('orders')->select('orders.id', 'orders.user_id', 'orders.sample_collection_address_id', 'orders.date', 'orders.time', 'orders.payment_method', 'orders.final_total', 'orders.status')->orderby('orders.id', 'DESC')->join('user_addresses', 'user_addresses.id', '=', 'orders.sample_collection_address_id')->whereIn('orders.status', array('1', '2', '5', '6'))->where('orders.manager_id', Auth::user()->id)->get());
        $totalreject = count(DB::table('orders')->select('orders.id', 'orders.user_id', 'orders.sample_collection_address_id', 'orders.date', 'orders.time', 'orders.payment_method', 'orders.final_total', 'orders.status')->orderby('orders.id', 'DESC')->join('user_addresses', 'user_addresses.id', '=', 'orders.sample_collection_address_id')->whereIn('orders.status', array(3, 4))->where('orders.manager_id', Auth::user()->id)->get());

        return view("manager.dashboard")->with('user',$user)->with("totalorder", $totalorder)->with("totalcomplete", $totalcomplete)->with("totalpending", $totalpending)->with("totalreject", $totalreject);
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('manager-login');
    }
    public function show_manager_profile()
    {
        return view("manager.editprofile");
    }
    public function show_update_manager_profile(Request $request)
    {
        $store = User::find(Auth::id());
        $store->name = $request->get("name");
        $store->email = $request->get("emailId");
        if ($request->file("upload_image")) {
            if (Auth::user()->profile_pic != "") {
                $this->removeImage('profile/' . $store->profile_pic);
            }
            $store->profile_pic = $this->fileuploadFileImage($request, 'profile', 'upload_image');
        }
        $store->save();
        Session::flash('message', __('message.Profile Update Successfully'));
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }
    public function change_password(Request $request)
    {
        return view("manager.changepassword");
    }
    public function update_check_manager_password($val)
    {
        if ($val == Auth::user()->password) {
            return 0;
        }
        return 1;
    }
    public function show_update_manager_password(Request $request)
    {
        $store = User::find(Auth::id());
        $store->password = $request->get("newPassword");
        $store->save();
        Session::flash('message', __('message.Password Update Successfully'));
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }
    public function show_update_manager_change_password(Request $request)
    {
        $store = User::find(Auth::id());
        $store->password = $request->get("newPassword");
        $store->save();
        Session::flash('message', __('message.Password Update Successfully'));
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }

}
