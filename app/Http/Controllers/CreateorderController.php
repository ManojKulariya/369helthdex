<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use App\Models\Offer;
use App\Models\FamilyMember;
use DataTables;
use Session;
use Auth;
use App\Models\Package;
use App\Models\Timeslote;
use App\Models\Profiles;
use App\Models\Parameter;
use App\Models\City;
use Hash;
use Storage;
use Config;

class CreateorderController extends Controller
{
    // public function save_user_(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'phone' => 'required|string|max:15|unique:users,phone,NULL,id', 
    //     ]);
    //     try {
    //           $store = new User();
    //         $store->name = $request->get("name");
    //         $store->email = $request->get("email");
    //         $store->d_o_b = $request->get("d_o_b");
    //         $store->age = $request->get("age");
    //         $store->sex = $request->get("sex");
    //         $store->phone = $request->get("phone");
    //         $store->password = '123456rdc';
    //         $store->user_type = '3';
    //         $store->save();
    //         return response()->json(['success' => true, 'message' => 'User saved successfully!', 'user' => $store]);
    //     } catch (\Exception $e) {
    //         return response()->json(['success' => false, 'message' => $e->getMessage()]);
    //     }
    // }
    public function save_user_(Request $request)
    {
    try {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|unique:users',
        ]);

        $store = new User();
        $store->name = $request->name;
        $store->email = $request->email;
        $store->d_o_b = $request->d_o_b;
        $store->age = $request->age;
        $store->sex = $request->sex;
        $store->phone = $request->phone;
        $store->password = bcrypt('123456rdc'); // Always hash passwords!
        $store->user_type = '3'; 
        $store->save();

        return response()->json(['success' => true, 'message' => 'User saved successfully!', 'data' => $store]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        $msg = $e->errors();
        $msgs='';
        foreach ($msg as $m) {
                $msgs .= $m[0] . ", ";
            }
        return response()->json(['success' => false, 'message' => $msgs]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
}

    public function index(){
        // dd(Config::get("mapdetail.key"));
        $package   = $this->getpkglist();
        // dd($package[0]);
        $profiles  = $this->gettestlist();
        $timeslot = Timeslote::get();
        $labs = $this->getUserlist(2);
        $parameter = $this->getparmslist();
        $getcity = City::select('*')->where('is_deleted', '0')->get();
        return view("admin.orders.makeorder")->with('timeslot', $timeslot)->with('labs',$labs)->with('package',$package)->with('profiles',$profiles)->with('parameter',$parameter)->with("city", $getcity);
    }
    
    public function getUser(Request $request){
        
        $user = $this->getUserlist($request->role);
        $response =[
            'status'=>true,
            'msg'=>'User list',
            'data'=>$user
            ];
        return json_encode($response);
    }
    // public function save_user_(Request $request)
    // {
    //     $getuser = User::where("email", $request->get("email"))->where("user_type", '3')->first();
    //     $getuserno = User::where("phone", $request->get("phone"))->where("user_type", '3')->first();
    //     if ($getuser) {
    //         $msg = __("message.Email Id Already Exist");
    //         Session::flash('message', $msg);
    //         Session::flash('alert-class', 'alert-success');
    //         return redirect()->back();
    //     } elseif ($getuserno) {
    //         $msg = "Mobile Already Exist";
    //         Session::flash('message', $msg);
    //         Session::flash('alert-class', 'alert-success');
    //         return redirect()->back();
    //     } else {
    //         $store = new User();
    //         $store->name = $request->get("name");
    //         $store->email = $request->get("email");
    //         $store->d_o_b = $request->get("d_o_b");
    //         $store->age = $request->get("age");
    //         $store->sex = $request->get("sex");
    //         $store->phone = $request->get("phone");
    //         $store->password = '123456rdc';
    //         $store->user_type = '3';
    //         $store->save();

    //         $storeFamily = new FamilyMember();
    //         $storeFamily->name = $request->get("name");
    //         $storeFamily->mobile_no = $request->get("phone");
    //         $storeFamily->age = $request->get("age");
    //         $storeFamily->email = $request->get("email");
    //         $storeFamily->dob = $request->get("d_o_b");
    //         $storeFamily->relation = 'Self';
    //         $storeFamily->gender = $request->get("sex");
    //         $storeFamily->user_id = $store->id;
    //         $storeFamily->save();
    //         // Session::flash('message',"Your Profile Register Successfully");
    //         Session::flash('message', __('message.Your Profile Register Successfully'));
    //         Session::flash('alert-class', 'alert-success');
    //         return redirect()->back();
    //     }
    // }
    
}