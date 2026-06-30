<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\City;
use App\Models\FamilyMember;
use App\Models\UserAddress;
use App\Models\Parameter;
use App\Models\Orders;
use DataTables;
use Session;
use App\Models\Profiles;
use App\Models\Labdetail;
use Auth;
use Carbon\Carbon;
use App\Models\Userprescription;
class UserController extends Controller
{

    public function show_manager()
    {
        return view("admin.manager.default");
    }
    public function show_sample()
    {
        return view("admin.manager.sample");
    }
    public function get_pre()
    {
        return view("manager.pre.default");
    }
    public function transport_show_manager()
    {
        return view("transport.manager.default");
    }
    public function show_sampleboy()
    {
        return view("manager.sampleboy.default");
    }
    public function user_prescription()
    {
        return view("admin.pre.default");
    }
    public function predataTable(){
          $user = Userprescription::select('city.name as br_name','userprescriptions.*')->join('city','city.id','userprescriptions.location_id')->get();
        return DataTables::of($user)
            ->editColumn('id', function ($user) {
                return $user->id;
            })
            ->editColumn('name', function ($user) {
                return $user->name;
            })
            ->editColumn('email', function ($user) {
                return $user->email;
            })
            ->editColumn('gender', function ($user) {
                return $user->gender;
            })
            ->editColumn('d_o_b', function ($user) {
    
                return Carbon::parse($user->d_o_b)->format('d-m-Y');;
            })
            ->editColumn('number', function ($user) {
                return $user->number;
            })
            ->editColumn('br_name', function ($user) {
                return $user->br_name;
            })

            ->editColumn('doc', function ($user) {
                return url("storage/app/public/profile") . "/" . $user->prescription;
            })

            
            ->make(true);
    }
    public function transport_show_ManagerTable()
    {
        $user = User::whereNull('deleted_at')->where("user_type", '2')->get();
        return DataTables::of($user)
            ->editColumn('id', function ($user) {
                return $user->id;
            })
            ->editColumn('name', function ($user) {
                return $user->name;
            })
            ->editColumn('email', function ($user) {
                return $user->email;
            })
            ->editColumn('city', function ($user) {
                return City::find($user->city) ? City::find($user->city)->name : '';
            })

            ->editColumn('image', function ($user) {
                return url("storage/app/public/profile") . "/" . $user->profile_pic;
            })

            ->editColumn('action', function ($user) {
                $testtext = 'Test';
                $edittext = __('message.Edit');
                $test = url('testuser', array('id' => $user->id));
                $edit = url('transportsavemanager', array('id' => $user->id));

                return '<a  href="' . $edit . '" rel="tooltip"  class="btn btn-primary" data-original-title="banner" style="margin-right: 10px;color: white !important;">' . $edittext . '</a>';
            })
            ->make(true);
    }

    public function show_ManagerTable()
    {
        // $user = User::whereNull('deleted_at')->whereIn("user_type", ['2','4'])->get();
        $user = User::whereNull('deleted_at')->whereIn("user_type", ['2'])->get();
        return DataTables::of($user)
            ->editColumn('id', function ($user) {
                return $user->id;
            })
            ->editColumn('name', function ($user) {
                return $user->name;
            })
            ->editColumn('email', function ($user) {
                return $user->email;
            })
            ->editColumn('user_type', function ($user) {
                if($user->user_type == 2){
                    return "Lab";
                }else{
                    return "sample Boy";
                }
                return $user->user_type;
            })
            ->editColumn('city', function ($user) {
                return City::find($user->city) ? City::find($user->city)->name : '';
            })

            ->editColumn('image', function ($user) {
                return url("storage/app/public/profile") . "/" . $user->profile_pic;
            })

            ->editColumn('action', function ($user) {
                
                $buttons ='';
                $edittext = __('message.Edit');
                $deletetext = __('message.Delete');
                $test = url('testuser', array('id' => $user->id));
                if($user->user_type == 2){
                    $edit = url('savemanager', array('id' => $user->id));
                }else{
                    $edit = url('save_cc_boy', array('id' => $user->id));
                }
                
                if($user->status == 1){
                    $status = url('update_user_status', array('id' => $user->id,'status'=>0));
                    $buttons .= '<a href="' . $status . '" rel="tooltip"  class="btn btn-success" data-original-title="status" style="margin-right: 10px;color:white !important">Active</a>';
                }else{
                    $status = url('update_user_status', array('id' => $user->id,'status'=>1));
                    $buttons .= '<a href="' . $status . '" rel="tooltip"  class="btn btn-danger" data-original-title="status" style="margin-right: 10px;color:white !important">In-Active</a>';
                }
                
                $delete = url('deleteuser', array('id' => $user->id));
                $buttons .= '<a  href="' . $edit . '" rel="tooltip"  class="btn btn-primary" data-original-title="banner" style="margin-right: 10px;color: white !important;">' . $edittext . '</a>
                <a onclick="delete_record(' . "'" . $delete . "'" . ')" rel="tooltip"  class="btn btn-danger" data-original-title="Remove" style="margin-right: 10px;color:white !important">' . $deletetext . '</a>';
                return $buttons;
            })
            ->make(true);
    }
    public function update_user_status($id , $status){
        $user  = User::find($id);
        $user->status = $status; 
        $user->save();
        $city = City::find($user->city);
        $city->status = $status; 
        $city->save();
        Session::flash('message', 'Status updated!');
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
        
    }
    public function show_sampleTable()
    {
        // $user = User::whereNull('deleted_at')->whereIn("user_type", ['2','4'])->get();
        $user = User::whereNull('deleted_at')->whereIn("user_type", ['4'])->get();
        return DataTables::of($user)
            
            ->editColumn('id', function ($user) {
                return $user->id;
            })
            ->editColumn('name', function ($user) {
                return $user->name;
            })
            ->editColumn('phone', function ($user) {
                return $user->phone;
            })
            ->editColumn('lab', function ($user) {
                $datalab = User::find($user->sample_branch);
                $nm = $datalab ? $datalab->name : '';
                
                return $nm;
            })
            

            ->editColumn('action', function ($user) {
                $testtext = 'Test';
                $edittext = __('message.Edit');
                $deletetext = __('message.Delete');
                $test = url('testuser', array('id' => $user->id));
                if($user->user_type == 2){
                    $edit = url('savemanager', array('id' => $user->id));
                }else{
                    $edit = url('save_cc_boy', array('id' => $user->id));
                }
                
                $delete = url('deleteuser', array('id' => $user->id));
                return '<a  href="' . $edit . '" rel="tooltip"  class="btn btn-primary" data-original-title="banner" style="margin-right: 10px;color: white !important;">' . $edittext . '</a>
                <a onclick="delete_record(' . "'" . $delete . "'" . ')" rel="tooltip"  class="btn btn-danger" data-original-title="Remove" style="margin-right: 10px;color:white !important">' . $deletetext . '</a>';
            })
            ->make(true);
    }
    public function show_sampleboyTable()
    {
        $user = User::whereNull('deleted_at')->where('sample_branch', Auth::id())->whereIn("user_type", [4, 5, 6, 8])->get();
        return DataTables::of($user)
            ->editColumn('id', function ($user) {
                return $user->id;
            })
            ->editColumn('name', function ($user) {
                return $user->name;
            })
            ->editColumn('email', function ($user) {
                return $user->email;
            })
            ->editColumn('city', function ($user) {
                return City::find($user->city) ? City::find($user->city)->name : '';
            })

            ->editColumn('image', function ($user) {
                return url("storage/app/public/profile") . "/" . $user->profile_pic;
            })

            ->editColumn('action', function ($user) {
                $testtext = 'Test';
                $edittext = __('message.Edit');
                $deletetext = __('message.Delete');
                $test = url('testuser', array('id' => $user->id));
                $edit = url('savesampleboy', array('id' => $user->id));
                $delete = url('deleteuser', array('id' => $user->id));
                return '<a  href="' . $edit . '" rel="tooltip"  class="btn btn-primary" data-original-title="banner" style="margin-right: 10px;color: white !important;">' . $edittext . '</a>
                <a onclick="delete_record(' . "'" . $delete . "'" . ')" rel="tooltip"  class="btn btn-danger" data-original-title="Remove" style="margin-right: 10px;color:white !important">' . $deletetext . '</a>';
            })
            ->make(true);
    }

    public function show_savemanager($id)
    {
        $data = User::find($id);
        $labs = User::where('is_head', 'Yes')->get();
        $city = City::where("is_deleted", '0')->get();
        return view("admin.manager.save")->with("data", $data)->with("id", $id)->with("city", $city)->with("labs", $labs);
    }
    public function transport_show_savemanager($id)
    {
        $data = User::find($id);
        $labs = User::where('is_head', 'Yes')->get();
        $city = City::where("is_deleted", '0')->get();
        return view("transport.manager.save")->with("data", $data)->with("id", $id)->with("city", $city)->with("labs", $labs);
    }
    public function save_cc_boy($id)
    {
        $data = User::find($id);
        $city = City::where("is_deleted", '0')->get();
        $labs = User::where('user_type', 2)->get();
        return view("admin.manager.samplesave")->with("city", $city)->with("data", $data)->with("id", $id)->with("labs", $labs);
    }
    public function savesampleboy($id)
    {
        $data = User::find($id);
        $city = City::where("is_deleted", '0')->get();
        return view("manager.sampleboy.save")->with("data", $data)->with("id", $id)->with("city", $city);
    }
    public function savelabuser($id)
    {
        $data = User::find($id);
        $lab = User::where('user_type', 2)->get();
        $city = City::where("is_deleted", '0')->get();
        return view("transport.manager.labuser.save")->with("lab", $lab)->with("data", $data)->with("id", $id)->with("city", $city);
    }
    public function show_update_transport_manager_profile(Request $request)
    {
        // dd($request->all());
        $store = User::find($request->get("id"));
        $store->is_head = $request->get("is_head");
        if ($request->get("is_head") == 'No') {
            if ($request->get("reciever_lab") != "") {
                $store->reciever_lab = implode(",", $request->get("reciever_lab"));
            }
        }
        $store->save();
        Session::flash('message', __('message.Profile Save Successfully'));
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }

    public function show_update_manager_profile(Request $request)
    {
        
        if ($request->get("id") == 0) {
            $getmanager = User::where("email", $request->get("email"))->first();
            if ($getmanager) {
                Session::flash('message', __('message.Email Already Exist'));
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            }
            $store = new User();
        } else {
            $getmanager = User::where("email", $request->get("email"))->where("id", "!=", $request->get("id"))->first();
            if ($getmanager) {
                Session::flash('message', __('message.Email Already Exist'));
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            }
            $store = User::find($request->get("id"));
        }
        $store->name = $request->get("name");
        $store->email = $request->get("email");
        if ($request->filled("password")) {
            if ($request->get("password") == $request->get("cpassword")) {
                $store->password = $request->get("password");
            } else {
                Session::flash('message', __('message.Password & Confirm Password Not Match'));
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            }
        }
        $store->city = $request->get("city");

        if ($request->get("phone") != "") {
            $store->phone = $request->get("phone");
        }
        $store->branch_code = $request->get("branch_code");
        $store->address = $request->get("address");
        $store->company_name = $request->get("company_name");
        $store->description = $request->get("description");

        $store->user_type = '2';
        if ($request->file("upload_image")) {
            if ($store->profile_pic != "") {
                $this->removeImage('profile/' . $store->profile_pic);
            }
            $store->profile_pic = $this->fileuploadFileImage($request, 'profile', 'upload_image');
        }
        $store->save();
        Session::flash('message', __('message.Profile Save Successfully'));
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }
    public function update_manager_profile_admin_sample(Request $request)
    {
        
        if ($request->get("id") == 0) {
            $getmanager = User::where("phone", $request->get("phone"))->first();
            if ($getmanager) {
                Session::flash('message','Phone Already Exist');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            }
            $store = new User();
        } else {
            $getmanager = User::where("phone", $request->get("phone"))->where("id", "!=", $request->get("id"))->first();
            if ($getmanager) {
                Session::flash('message', 'Phone Already Exist');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            }
            $store = User::find($request->get("id"));
        }
        $store->name = $request->get("name");
        // $store->email = $request->get("email");
        $store->password = "XRFSRDJJHIUYIUYI";
        $store->city = $request->get("city");

        if ($request->get("phone") != "") {
            $store->phone = $request->get("phone");
        }
        $store->sample_branch = $request->get("sample_branch");
        $store->address = $request->get("address");
        $store->company_name = $request->get("company_name");
        $store->description = $request->get("description");

        $store->user_type = '4';
        if ($request->file("upload_image")) {
            if ($store->profile_pic != "") {
                $this->removeImage('profile/' . $store->profile_pic);
            }
            $store->profile_pic = $this->fileuploadFileImage($request, 'profile', 'upload_image');
        }
        $store->save();
        Session::flash('message', __('message.Profile Save Successfully'));
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }
    public function show_update_sample_profile(Request $request)
    {
        if ($request->get("id") == 0) {
            if($request->get("user_type") != 4){
                $getmanager = User::where("email", $request->get("email"))->first();
                if ($getmanager) {
                Session::flash('message', __('message.Email Already Exist'));
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
                }   
            }
            
            $getmanagerphon = User::where("phone", $request->get("phone"))->first();
            if ($getmanagerphon) {
                Session::flash('message', 'Phone Already Exist');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            }
            $store = new User();
        } else {
            if($request->get("user_type") != 4){
                $getmanager = User::where("email", $request->get("email"))->where("id", "!=", $request->get("id"))->first();
                if ($getmanager) {
                    Session::flash('message', __('message.Email Already Exist'));
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->back();
                }
            }
            $getmanagerphone = User::where("phone", $request->get("phone"))->where("id", "!=", $request->get("id"))->first();
            if ($getmanagerphone) {
                Session::flash('message', 'Phone Already Exist');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            }
            $store = User::find($request->get("id"));
        }
        $store->name = $request->get("name");
        $store->email = $request->get("email");
        $store->password = "XRDCjhgjkhgkh";
        $store->phone = $request->get("phone");
        $store->city = Auth::user()->city;
        if ($request->get("lab_id") != null || $request->get("lab_id") != "") {
            $store->sample_branch = $request->get("lab_id");
        } else {

            $store->sample_branch = Auth::user()->id;
        }
        $store->user_type = $request->get("user_type");
        $store->address = $request->get("address");
        $store->description = $request->get("description");
        //  $store->user_type = '4';
        //  if($request->file("upload_image")){
        //      if($store->profile_pic!=""){
        //          $this->removeImage('profile/' . $store->profile_pic);
        //      }             
        //      $store->profile_pic = $this->fileuploadFileImage($request,'profile','upload_image');
        //  }        
        $store->save();
        Session::flash('message', __('message.Profile Save Successfully'));
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }
    public function show_update_transport_profile(Request $request)
    {
        if ($request->get("id") == 0) {
            $getmanager = User::where("email", $request->get("email"))->first();
            if ($getmanager) {
                Session::flash('message', __('message.Email Already Exist'));
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            }
            $getmanagerphon = User::where("phone", $request->get("phone"))->first();
            if ($getmanagerphon) {
                Session::flash('message', 'Phone Already Exist');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            }
            $store = new User();
        } else {
            $getmanager = User::where("email", $request->get("email"))->where("id", "!=", $request->get("id"))->first();
            if ($getmanager) {
                Session::flash('message', __('message.Email Already Exist'));
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            }
            $getmanagerphone = User::where("phone", $request->get("phone"))->where("id", "!=", $request->get("id"))->first();
            if ($getmanagerphone) {
                Session::flash('message', 'Phone Already Exist');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            }
            $store = User::find($request->get("id"));
        }

        $store->name = $request->get("name");
        $store->email = $request->get("email");
        $store->password = $request->get("password");
        $store->phone = $request->get("phone");
        $store->city = Auth::user()->city;
        $store->sample_branch = $request->get("lab_id");
        $store->user_type = $request->get("user_type");
        $store->save();
        Session::flash('message', __('message.Profile Save Successfully'));
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }

    public function deleteuser($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
        }
        Session::flash('message', __('message.Manager delete Successfully'));
        Session::flash('alert-class', 'alert-success');
        return redirect()->route('manager');
    }


    public function show_user()
    {
        return view("admin.manager.user");
    }
    public function transport_show_user()
    {
        return view("transport.manager.user");
    }
    public function testuser($id)
    {
        $datatest = Profiles::get();
        $ls = array();
        if ($datatest) {
            foreach ($datatest as $row) {
                $arr = explode(",", $row->no_of_parameter);
                $i = 0;
                foreach ($arr as $a) {
                    if ($i <= 3) {
                        $ls[] = Parameter::find($a) ? Parameter::find($a)->name : '';
                    }
                    $i++;
                }
                $row->paramater_data = implode(",", $ls);
                $ls = [];
            }
        }
        $data['test'] = $datatest;
        $data['user'] = User::find($id);
        return view("admin.manager.usertest")->with("data", $data);
    }
    public function addtest(Request $request)
    {
        $itemId = $request->input('item_id');
        $userID = $request->input('userID');
        $data = new Labdetail();
        $data->lab_id = $userID;
        $data->test_id = $itemId;
        $data->save();
        return response()->json(['message' => 'Test added successfully']);
    }
    public function updatetests(Request $request)
    {
        $userID = $request->input('userID');
        $status = $request->input('status');

        if ($status == 0) {
            Labdetail::where('lab_id', $userID)->delete();
        } else {
            
            $selectedItems = $request->input('selected_items');
            foreach ($selectedItems as $testID) {
                $data = new Labdetail();
                $data->lab_id = $userID;
                $data->test_id = $testID;
                $data->save();
            }
        }
        return response()->json(['message' => 'Test update successful']);
    }
    public function removetest(Request $request)
    {
        $itemId = $request->input('item_id');
        $userID = $request->input('userID');
        Labdetail::where('lab_id', $userID)->where('test_id', $itemId)->delete();
        return response()->json(['message' => 'Test removed successfully']);
    }
    public function Transportshow_UserTable()
    {
        $user = User::with('mylab')->whereNull('deleted_at')->whereIn("user_type", ['5', '6', '8'])->get();
        return DataTables::of($user)
            ->editColumn('id', function ($user) {
                return $user->id;
            })
            ->editColumn('name', function ($user) {
                return $user->name;
            })
            ->editColumn('email', function ($user) {
                return $user->email;
            })
            ->editColumn('city', function ($user) {
                $memertext = __('message.Members');
                return $user->mylab->name;
            })
            ->editColumn('member', function ($user) {
                if ($user->user_type == 5) {
                    return "Transport Boy";
                } elseif ($user->user_type == 8) {
                    return "Parcel Sender";
                } else {
                    return "Parcel Receiver";
                }

            })
            ->editColumn('image', function ($user) {
                if ($user->profile_pic != "") {
                    return url("storage/app/public/profile") . "/" . $user->profile_pic;
                } else {
                    return url("public/img") . "/default_user.png";
                }
            })
            ->editColumn('action', function ($user) {
                $edittext = __('message.Edit');
                $deletetext = __('message.Delete');
                $edit = url('savemanager', array('id' => $user->id));
                $delete = url('deleteuser_detail', array('id' => $user->id));
                return '<a onclick="delete_user_detail(' . "'" . $delete . "'" . ')" rel="tooltip"  class="btn btn-danger" data-original-title="Remove" style="margin-right: 10px;color:white !important">' . $deletetext . '</a>';
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function show_UserTable()
    {
        $user = User::whereNull('deleted_at')->where("user_type", '3')->get();
        return DataTables::of($user)
            ->editColumn('id', function ($user) {
                return $user->id;
            })
            ->editColumn('name', function ($user) {
                return $user->name;
            })
            ->editColumn('email', function ($user) {
                return $user->email;
            })
            ->editColumn('city', function ($user) {
                $memertext = __('message.Members');
                return '<a href="javascript:void(0)" onclick="view_member(' . "'" . $user->id . "'" . ')" data-bs-toggle="modal" data-bs-target="#normalmodal" rel="tooltip"  class="btn btn-info" data-original-title="Remove" style="margin-right: 10px;color:white !important">' . $memertext . '</a>';
            })
            ->editColumn('member', function ($user) {
                $addresstext = __('message.Address');
                return '<a href="javascript:void(0)" onclick="view_address(' . "'" . $user->id . "'" . ')" data-bs-toggle="modal" data-bs-target="#addressmodal" rel="tooltip"  class="btn btn-info" data-original-title="Remove" style="margin-right: 10px;color:white !important">' . $addresstext . '</a>';
            })
            ->editColumn('image', function ($user) {
                if ($user->profile_pic != "") {
                    return url("storage/app/public/profile") . "/" . $user->profile_pic;
                } else {
                    return url("public/img") . "/default_user.png";
                }
            })
            ->editColumn('action', function ($user) {
                $edittext = __('message.Edit');
                $deletetext = __('message.Delete');
                $edit = url('savemanager', array('id' => $user->id));
                $delete = url('deleteuser_detail', array('id' => $user->id));
                return '<a onclick="delete_user_detail(' . "'" . $delete . "'" . ')" rel="tooltip"  class="btn btn-danger" data-original-title="Remove" style="margin-right: 10px;color:white !important">' . $deletetext . '</a>';
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function deleteuser_detail($id)
    {
        $user = User::find($id);
        $familt_data = FamilyMember::where('user_id', $id)->get();
        $add_data = UserAddress::where('user_id', $id)->get();
        $order_data = Orders::where('user_id', $id)->get();

        if ($user) {
            foreach ($familt_data as $k) {
                $k->delete();
            }
            foreach ($add_data as $j) {
                $j->delete();
            }
            foreach ($order_data as $b) {
                $b->delete();
            }
            $user->delete();
        }
        
        Session::flash('message', __('message.User delete Successfully'));
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();

    }
    public function getmembersinfo($id)
    {
        $data = FamilyMember::where('user_id', $id)->get();
        $data_new = array("item_list" => $data);
        return $data_new;
    }
    public function getaddress($id)
    {
        $data = UserAddress::where('user_id', $id)->get();
        $data_new = array("item_list" => $data);
        return $data_new;
    }
}
