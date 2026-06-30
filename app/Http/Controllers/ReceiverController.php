<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Setting;
use App\Models\Transport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ReceiverController extends Controller
{
    public function show_login() {
        $setting = Setting::find(1);
        return view("receiver.login")->with("setting", $setting);
    }

    public function post_login(Request $request) {
        $checkuser = User::where("email", $request->get("email"))
            ->where("password", $request->get("password"))
            ->where("user_type", '6')  // Receiver user_type
            ->first();

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

            return redirect()->route("receiver-dashboard");
        } else {
            Session::flash('message', __('message.Login credentials are wrong'));
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
    }

    public function show_dashboard() {
             $totalcategory = count(Transport::where("status", 2)->get());
        return view("receiver.dashboard")->with("totalcategory", $totalcategory);
    }
public function markAsReceived(Request $request)
{
    try {
        $request->validate([
            'order_id' => 'required|integer|exists:transports,id',
        ]);

        $order = Transport::findOrFail($request->order_id);
        $order->status = 2;
        $order->save();

        return response()->json(['message' => 'Parcel marked as received successfully.']);
    } catch (\Exception $e) {
        \Log::error('Mark Received Error: ' . $e->getMessage());
        return response()->json([
            'message' => 'Something went wrong!',
            'error' => $e->getMessage()
        ], 500);
    }
}


    public function logout() {
        Auth::logout();
        return redirect()->route('receiver-login');
    }

    public function show_profile() {
        $user = Auth::user();
        return view('receiver.profile', compact('user'));
    }

    public function update_profile(Request $request) {
        $user = Auth::user();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->save();

        Session::flash('message', 'Profile updated successfully');
        Session::flash('alert-class', 'alert-success');
        return back();
    }
}
