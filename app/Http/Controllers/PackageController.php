<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use App\Models\Subcategory;
use DataTables;
use App\Models\Package;
use App\Models\ProfileBranch;
use App\Models\PackageBranch;
use App\Models\ParameterBranch;
use App\Models\Package_FRQ;
use App\Models\Parameter;
use App\Models\Profiles;
use App\Models\TestDetails;
use App\Models\Popular_package;
use App\Models\SampleType;
use App\Models\City;
use Session;
use Auth;
use Hash;
use Cviebrock\EloquentSluggable\Services\SlugService;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
class PackageController extends Controller
{
 
    public function upload(Request $request)
    {
    if ($request->hasFile('upload')) {
        $file = $request->file('upload');

        $request->validate([
            'upload' => 'required|image|mimes:jpeg,png,jpg,webp,gif|max:2048',
        ]);

        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('public/Blog', $filename);

        $url = 'https://rdccare.com/storage/app/public/Blog/' . $filename;
        
        return response()->json([
            'uploaded' => 1,
            'fileName' => $filename,
            'url' => $url,
        ]);
    }

    return response()->json([
        'uploaded' => 0,
        'error' => ['message' => 'No file uploaded.']
    ]);
}



    public function get_parameter_slug(Request $request)
    {
        // New version: to generate unique slugs
        $slug = SlugService::createSlug(Parameter::class, 'slug', $request->name);
        return response()->json(['slug' => $slug]);
    }
    public function show_package()
    {
        $branch = User::where('user_type', 2)->get();
        return view("admin.package.default")->with("branch", $branch);
        
    }
    
    public function update_status($id , $status){
        Package::where('id',$id)->update(['status'=>$status]);
        Session::flash('message', 'Status updated!');
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }
    public function copy_parameter($id)
    {
        $originalPackage = Parameter::find($id);
        
        if (!$originalPackage) {
            return redirect()->back()->with('error', 'Parameter not found.');
        }
    
        // Duplicate the package data
        $newPackage = $originalPackage->replicate();
        $newPackage->created_at = now();
        $newPackage->updated_at = now();
        $newPackage->save();
        
        dd("Parameter copied successfully.");
    
        return redirect()->back()->with('success', 'Parameter copied successfully.');
    }
    public function copy_profile($id)
    {
        $originalPackage = Profiles::find($id);
        
        if (!$originalPackage) {
            return redirect()->back()->with('error', 'Parameter not found.');
        }
    
        // Duplicate the package data
        $newPackage = $originalPackage->replicate();
        $newPackage->created_at = now();
        $newPackage->updated_at = now();
        $newPackage->save();
        
        dd("Profiles copied successfully.");
    
        return redirect()->back()->with('success', 'Profiles copied successfully.');
    }
    public function copy_package($id)
    {
        $originalPackage = Package::find($id);
        $originalPackage->copy +=1;
        $originalPackage->save();
        if (!$originalPackage) {
            return redirect()->back()->with('error', 'Package not found.');
        }
    
        // Duplicate the package data
        $newPackage = $originalPackage->replicate();
        $newPackage->copy=0;
        $newPackage->created_at = now();
        $newPackage->updated_at = now();
        $newPackage->save();
        
        
        $testDetails = TestDetails::where('package_id', $originalPackage->id)->get();

        // Insert copied test_details with the new package ID
        foreach ($testDetails as $test) {
            TestDetails::create([
                'type' => $test->type,
                'type_id' => $test->type_id,
                'package_id' => $newPackage->id, // Assign new package ID
            ]);
        }
    
        return redirect()->back()->with('success', 'Package copied successfully.');
    }

    public function package_datatable()
    {
        // $package = Package::whereNull("deleted_at")->get();
        $package = $this->getpkglist();
        return DataTables::of($package)
            ->editColumn('id', function ($package) {
                return $package->id;
            })
            ->editColumn('name', function ($package) {
                    $copy_package = url('copy_package', array('id' => $package->id));
                    $p_data = json_encode($package->paramater_data);
                    $reco = $package->test_recommended_for . ' ' . $package->test_recommended_for_age;

                    return '<span class="adm-cart-name">'.$package->name.' - '.$package->no_of_parameter.'</span>'
                        .'<div class="adm-row-actions" style="margin-top:.4rem;">'
                        .'<button type="button" class="adm-cat-eye" title="View parameter" onclick="showPackageDetails('
                            . htmlspecialchars(json_encode('Package'), ENT_QUOTES, 'UTF-8') . ','
                            . htmlspecialchars($p_data, ENT_QUOTES, 'UTF-8') . ','
                            . htmlspecialchars(json_encode($package->name), ENT_QUOTES, 'UTF-8') . ','
                            . htmlspecialchars(json_encode($package->sample_type), ENT_QUOTES, 'UTF-8') . ','
                            . htmlspecialchars(json_encode($package->fasting_time), ENT_QUOTES, 'UTF-8') . ','
                            . htmlspecialchars(json_encode($reco), ENT_QUOTES, 'UTF-8') . ','
                            . htmlspecialchars(json_encode($package->report_time), ENT_QUOTES, 'UTF-8') . ')">'
                            .'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>'
                        .'</button>'
                        .'<a href="'.$copy_package.'" class="adm-cat-eye" title="Copy package"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg></a>'
                        .'<small style="color:var(--adm-ink-400);">'.$package->copy.'</small>'
                        .'</div>';
                })


            ->editColumn('price', function ($package) {
                return $package->price.' - '.$package->mrp;
            })
            ->editColumn('test_recommended_for', function ($package) {
                return $package->test_recommended_for_age.' , '.$package->test_recommended_for;
            })
            ->editColumn('status', function ($package) {
                $statuspath =  url('update_status', array('id' => $package->id,'status'=>$package->status == 1 ? 0 : 1 ));
                if($package->status == 1){
                    return '<a href="' . $statuspath . '" class="adm-act adm-act--green" style="width:auto;display:inline-flex !important;">Active</a>';
                }else{
                    return '<a href="' . $statuspath . '" class="adm-act adm-act--gray" style="width:auto;display:inline-flex !important;">Inactive</a>';
                }

            })
            ->editColumn('action', function ($package) {
                $path = url('frq', array('id' => $package->id, 'tab' => '1'));

                $frqtext = 'View FRQ';
                $edittext = __('message.Edit');
                $deletetext = __('message.Delete');
                $edit = url('save_package', array('id' => $package->id, 'tab' => '1'));
                $delete = url('deletepackage', array('id' => $package->id));

                return '<div class="adm-row-actions" style="flex-wrap:wrap;">'
                    .'<a href="'.$edit.'" class="adm-act adm-act--green"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>'.$edittext.'</a>'
                    .'<a onclick="delete_record(' . "'" . $delete . "'" . ')" class="adm-act adm-act--red"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>'.$deletetext.'</a>'
                    .'<a href="'.$path.'" class="adm-act adm-act--green">'.$frqtext.'</a>'
                    .'</div>';
            })
            ->rawColumns(['name', 'status', 'action'])
            ->make(true);
    }

    public function show_save_package($id, $tab)
    {
        $branch = User::where('user_type', 2)->get();
        $sampleType = SampleType::get();
        $data = Package::with('branches')->find($id);
        if($data){
          $data->branch_id =   $data->branches->pluck('branch_id')->toArray();
        }
        $category = Subcategory::where("is_deleted", '0')->get();
        $get_all_package = Package::whereNull("deleted_at")->get();
        $get_all_paramter = Parameter::whereNull("deleted_at")->get();
        $get_profiles = Profiles::all();
        foreach($get_profiles as $get_profile){
            $mrp = 0;
            $arr = explode(",", $get_profile->no_of_parameter);
            foreach ($arr as $l) {
                $mrp += Parameter::find($l) ? Parameter::find($l)->mrp : 0;
            }
            $get_profile->price = $mrp;    
        }
        $test_details = TestDetails::where("package_id", $id)->get();
        return view("admin.package.save_package")
            ->with("branch", $branch)
            ->with("id", $id)->with("category", $category)->with('sampleType',$sampleType)->with("packages", $get_all_package)->with("data", $data)->with("get_all_paramter", $get_all_paramter)->with("tab", $tab)->with("get_profiles", $get_profiles)->with("test_details", $test_details);
    }
    public function show_package_basic_info(Request $request)
    {
        // dd($request->post("mrp"));
        if ($request->get("id") == 0) {
            $data = new Package();
        } else {
            $data = Package::find($request->get("id"));
        }
        
        $data->sample_type =implode(',',$request->get("sample_type"));
        $data->is_featured = $request->has('is_featured') ? 1 : 0;
        $data->name = $request->get("name");
        $data->tag = $request->get("tag");
        $data->short_desc = $request->get("short_desc");
        $data->description = $request->get("description");
        $data->sort_order = (int)$request->get("sort_order");
        $data->category_id = implode(",", $request->get("category"));
        //  $data->subcategory_id = $request->get("subcategory_id");
        $data->mrp = $request->get("mrp");
        // $data->price = $request->get("price");
        $data->save();
        Session::flash('message', __('message.Package Basic Information Save Successfully'));
        Session::flash('alert-class', 'alert-success');
        return redirect('save_package/' . $data->id . '/2');
    }

    public function show_package_lab_info(Request $request)
    {
        if ($request->get("id") == 0) {
            Session::flash('message', __('message.Please First Save Package Basic Information Then Proceed Ahead'));
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
        $data = Package::find($request->get("id"));
        $data->paramter_included = $request->get("paramter_included");
        $data->report_time = $request->get("report_time");
        $data->sample_collection = $request->get("sample_collection");
        $data->sample_collection_fee = $request->get("sample_collection_fee");
        $data->fasting_time = $request->get("fasting_time");
        $data->fast_time = $request->get("fast_time");
        $data->test_recommended_for = implode(",", $request->get("test_recommended_for"));
        $data->test_recommended_for_age = $request->get("test_recommended_for_age");
        if ($request->get("realted_package")) {
            $data->realted_package = implode(",", $request->get("realted_package"));
        }
        if ($request->hasfile("lab_report")) {
            $old_report = $data->lab_report;
            $file = $request->file('lab_report');
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension() ?: 'png';
            $picture = rand() . time() . '.' . $extension;
            $destinationPath = Storage_path("app/public/sample_report");
            $request->file('lab_report')->move($destinationPath, $picture);
            $data->lab_report = $picture;
            if ($old_report != "") {
                $this->removeImage("sample_report" . "/" . $old_report);
            }
        }
        $data->save();
        Session::flash('message', __('message.Package Lab Information Save Successfully'));
        Session::flash('alert-class', 'alert-success');
        return redirect('save_package/' . $data->id . '/3');
    }

    public function show_save_package_test_info(Request $request)
    {
        if ($request->get("id") == 0) {
            // Session::flash('message',"Please First Save Package Basic Information Then Proceed Ahead");
            Session::flash('message', __('message.Please First Save Package Basic Information Then Proceed Ahead'));
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
        TestDetails::where("package_id", $request->get("id"))->delete();
        $arr = $request->get("testdetail");
        foreach ($arr as $a) {
            $store = new TestDetails();
            $store->type = $a['type'];
            $store->type_id = $a['type_id'];
            $store->package_id = $request->get("id");
            $store->save();
        }
        Session::flash('message', __('message.Package Test Information Save Successfully'));
        Session::flash('alert-class', 'alert-success');
        return redirect()->route('show-package');
    }
    public function show_save_package_branch_info(Request $request)
    {
        if ($request->get("id") == 0) {
            Session::flash('message', __('message.Please First Save Package Basic Information Then Proceed Ahead'));
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
        $data = Package::find($request->get("id"));
      
        $branchIds = $request->get("branch_id", []); // checkbox values
        if (!is_array($branchIds)) {
            $branchIds = [$branchIds];
        }
    
        // Clear old branches
        PackageBranch::where('package_id', $data->id)->delete();
        $mrps = $request->get("branchmrp", []);
        $prices = $request->get("branchprice", []);
        // Insert new branches
        foreach ($branchIds as $branchId) {
            PackageBranch::create([
                'package_id' => $data->id,
                'branch_id'  => $branchId,
                'price'        => $mrps[$branchId] ?? 0,
                'mrp'      => $prices[$branchId] ?? 0,
            ]);
        }
        Session::flash('message', 'Package Branch User Save Successfully');
        Session::flash('alert-class', 'alert-success');
        return redirect()->route('show-package');
    }
    public function show_save_parameter_branch_info(Request $request)
    {
        if ($request->get("id") == 0) {
            Session::flash('message', __('message.Please First Save Parameter Basic Information Then Proceed Ahead'));
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
        $data = Parameter::find($request->get("id"));
        // $data->branch_id = is_array($request->get("branch_id")) ? implode(",", $request->get("branch_id")) : '';
        // $data->save();
        
        $branchIds = $request->get("branch_id", []); // checkbox values
        if (!is_array($branchIds)) {
            $branchIds = [$branchIds];
        }
    
        // Clear old branches
        ParameterBranch::where('parameter_id', $data->id)->delete();
        $mrps = $request->get("branchmrp", []);
        $prices = $request->get("branchprice", []);
        // Insert new branches
        foreach ($branchIds as $branchId) {
            ParameterBranch::create([
                'parameter_id' => $data->id,
                'branch_id'  => $branchId,
                'price'        => $mrps[$branchId] ?? 0,
                'mrp'      => $prices[$branchId] ?? 0,
            ]);
        }
       
      
        Session::flash('message', 'Parameter Branch User Save Successfully');
        Session::flash('alert-class', 'alert-success');
        return redirect()->route('parameter_get');
    }

    public function show_save_parameter($id, $tab)
    {
        $data = Parameter::with('branches')->find($id);
        if($data){
          $data->branch_id =   $data->branches->pluck('branch_id')->toArray();
        }
        $branch = User::where('user_type', 2)->get();
        $sampleType = SampleType::get();
        $category = Subcategory::where('is_deleted', '0')->get();
        return view("admin.parameter.save_parameter")->with('branch', $branch)->with('sampleType',$sampleType)->with("id", $id)->with("data", $data)->with("tab", $tab)->with("category", $category);
    }
    public function getlistofparameter()
    {
        $data = Parameter::whereNull('deleted_at')->get();
        return $data;
    }
    public function show_getsubcategorybycategory($id)
    {
        $data = Subcategory::where("category_id", $id)->where('is_deleted', '0')->get();
        $txt = "";
        foreach ($data as $k) {
            $txt = $txt . '<option value="' . $k->id . '">' . $k->name . '</option>';
        }
        return $txt;
    }
    public function show_save_parameter_basic_info(Request $request)
    {
        if ($request->get("id") == 0) {
            $data = new Parameter();
        } else {
            $data = Parameter::find($request->get("id"));
        }
        $data->sample_type =implode(',',$request->get("sample_type"));
        $data->sort_order = (int)$request->get("sort_order");
        $data->name = $request->get("name");
        $data->short_desc = $request->get("short_desc");
        $data->description = $request->get("description");
        $data->mrp = $request->get("mrp");
        $data->price = $request->get("mrp");
        // $data->price = $request->get("price");
        $data->category_id = implode(",", $request->get("category_id"));
        $data->save();

        Session::flash('message', __('message.Parameter Basic Information Save Successfully'));
        Session::flash('alert-class', 'alert-success');
        return redirect('save_parameter/' . $data->id . '/2');
    }

    public function show_save_parameter_lab_info(Request $request)
    {
        $data = Parameter::find($request->get("id"));
        $data->report_time = $request->get("report_time");
        $data->sample_collection = $request->get("sample_collection");
        $data->sample_collection_fee = $request->get("sample_collection_fee");
        $data->fasting_time = $request->get("fasting_time");
        $data->fast_time = $request->get("fast_time");
        $data->test_recommended_for = implode(",", $request->get("test_recommended_for"));
        $data->test_recommended_for_age = $request->get("test_recommended_for_age");
        if ($request->hasfile("lab_report")) {
            $old_report = $data->lab_report;
            $file = $request->file('lab_report');
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension() ?: 'png';
            $picture = rand() . time() . '.' . $extension;
            $destinationPath = Storage_path("app/public/sample_report");
            $request->file('lab_report')->move($destinationPath, $picture);
            $data->lab_report = $picture;
            if ($old_report != "") {
                $this->removeImage("sample_report" . "/" . $old_report);
            }

        }
        $data->save();
        Session::flash('message', __('message.Parameter Lab Information Save Successfully'));
        Session::flash('alert-class', 'alert-success');
        return redirect('save_parameter/' . $data->id . '/2');
    }
    public function show_parameter()
    {
        $branch = User::where('user_type', 2)->get();
        return view("admin.parameter.default")->with("branch", $branch);
    }
    public function parameter_datatable()
    {
        $parameter = Parameter::whereNull("deleted_at")->get();
        return DataTables::of($parameter)
            ->editColumn('id', function ($parameter) {
                return $parameter->id;
            })
            ->editColumn('name', function ($parameter) {
                return $parameter->name;
            })
            ->editColumn('short_desc', function ($parameter) {
                return $parameter->short_desc;
            })
            ->editColumn('mrp', function ($parameter) {
                return $parameter->mrp;
            })
            ->editColumn('frq', function ($parameter) {
                return $parameter->id;
            })
            ->editColumn('action', function ($parameter) {
                $edittext = __('message.Edit');
                $deletetext = __('message.Delete');
                $edit = url('save_parameter', array('id' => $parameter->id, 'tab' => '1'));
                $delete = url('delete_parameter', array('id' => $parameter->id));

                return '<div class="adm-row-actions">'
                    .'<a href="'.$edit.'" class="adm-act adm-act--green"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>'.$edittext.'</a>'
                    .'<a onclick="delete_record(' . "'" . $delete . "'" . ')" class="adm-act adm-act--red"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>'.$deletetext.'</a>'
                    .'</div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function show_delete_parameter($id)
    {
        $store = Parameter::find($id);
        if ($store) {
            $store->delete();
            Session::flash('message', __('message.Parameter Delete Successfully'));
            Session::flash('alert-class', 'alert-success');
            return redirect()->back();
        } else {
            Session::flash('message', __('message.Parameter Not Found'));
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
    }
    public function delete_package($id)
    {
        $store = Package::find($id);
        if ($store) {
            $store->delete();
            Session::flash('message', __('message.Package Delete Successfully'));
            Session::flash('alert-class', 'alert-success');
            return redirect()->back();
        } else {
            Session::flash('message', __('message.Package Not Found'));
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
    }
    public function delete_profile($id)
    {
        $store = Profiles::find($id);
        if ($store) {
            $store->delete();
            Session::flash('message', "Profile Delete Successfully");
            Session::flash('alert-class', 'alert-success');
            return redirect()->back();
        } else {
            Session::flash('message', "Profile Not Found");
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
    }

    public function viewfrq($id, $type)
    {
        return view("admin.frq.default")->with("id", $id)->with("type", $type);
    }

    public function frq_datatable($id, $type)
    {
        $frq = Package_FRQ::whereNull("deleted_at")->where("package_id", $id)->where("type", $type)->get();
        return DataTables::of($frq)
            ->editColumn('id', function ($frq) {
                return $frq->id;
            })
            ->editColumn('question', function ($frq) {
                return $frq->question;
            })
            ->editColumn('ans', function ($frq) {
                return substr($frq->ans, 0, 100) . '...';
            })


            ->editColumn('action', function ($frq) {
                $edittext = __('message.Edit');
                $deletetext = __('message.Delete');
                $delete = url('delete_frq', array('id' => $frq->id));
                return '<div class="adm-row-actions">'
                    .'<a onclick="edit_frq(' . $frq->id . ')" data-bs-toggle="modal" data-bs-target="#editfrq" class="adm-act adm-act--green"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>' . $edittext . '</a>'
                    .'<a onclick="delete_record(' . "'" . $delete . "'" . ')" class="adm-act adm-act--red"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>' . $deletetext . '</a>'
                    .'</div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function update_frq(Request $request)
    {
        if ($request->get("id") == 0) {
            $store = new Package_FRQ();
            $msg = __('message.FRQ Add Successfully');
        } else {
            $store = Package_FRQ::find($request->get("id"));
            $msg = __('message.FRQ Update Successfully');
        }
        $store->question = $request->get("question");
        $store->ans = $request->get("answer");
        $store->type = $request->get("type");
        $store->package_id = $request->get("package_id");
        $store->save();
        Session::flash('message', $msg);
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }

    public function show_delete_frq(Request $request, $id)
    {
        $store = Package_FRQ::find($id);
        if ($store) {
            $store->delete();
            // Session::flash('message',"FRQ Delete Successfully");
            Session::flash('message', __('message.FRQ Delete Successfully'));
            Session::flash('alert-class', 'alert-success');
            return redirect()->back();
        } else {
            // Session::flash('message',"FRQ Not Found");
            Session::flash('message', __('message.FRQ Not Found'));
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
    }

    public function show_getfrq($id)
    {
        $data = Package_FRQ::find($id);
        return json_encode($data);
    }

    public function show_profiles()
    {
        $branch = User::where('user_type', 2)->get();
        
        return view("admin.profile.default")->with("branch", $branch);
        
    }
    public function show_update_profile(Request $request)
    {
        if ($request->get("id") == 0) {
            $data = new Profiles();
            $msg = __('message.Profile Add Successfully');
        } else {
            $data = Profiles::find($request->get("id"));
            $msg = __('message.Profile Update Successfully');
        }
        
        $data->sample_type =implode(',',$request->get("sample_type"));
        $data->is_featured = $request->has('is_featured') ? 1 : 0;
        $data->sort_order = (int)$request->get("sort_order");
        $data->profile_name = $request->get("name");
        $data->tag = $request->get("tag");
        $data->no_of_parameter = implode(",", $request->get("no_of_parameter"));
        
        $data->report_time = $request->get("report_time");
        $data->sample_collection = $request->get("sample_collection");
        $data->sample_collection_fee = $request->get("sample_collection_fee");
        $data->fasting_time = $request->get("fasting_time");
        $data->fast_time = $request->get("fast_time");
        $data->test_recommended_for = implode(",", $request->get("test_recommended_for"));
        $data->test_recommended_for_age = $request->get("test_recommended_for_age");
        $data->short_desc = $request->get("short_desc");
        $data->description = $request->get("description");
        $data->category_id = implode(",", $request->get("category"));
        $data->mrp = $request->get("mrp");
        // $data->price = $request->get("price");
        if ($request->hasfile("lab_report")) {
            $old_report = $data->lab_report;
            $file = $request->file('lab_report');
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension() ?: 'png';
            $picture = rand() . time() . '.' . $extension;
            $destinationPath = Storage_path("app/public/sample_report");
            $request->file('lab_report')->move($destinationPath, $picture);
            $data->lab_report = $picture;
            if ($old_report != "") {
                $this->removeImage("sample_report" . "/" . $old_report);
            }

        }
        $data->save();
        $branchIds = $request->get("branch_id", []); // checkbox values
        // dd($branchIds);
        if (!is_array($branchIds)) {
            $branchIds = [$branchIds];
        }
    
        // Clear old branches
       
        ProfileBranch::where('profile_id', $data->id)->delete();
    
        $mrps = $request->get("branchmrp", []);
        $prices = $request->get("branchprice", []);
        
        foreach ($branchIds as $index=>$branchId) {
            ProfileBranch::create([
                'profile_id' => $data->id,
                'branch_id'  => $branchId,
                'price'        => $mrps[$branchId] ?? 0,
                'mrp'      => $prices[$branchId] ?? 0,
            ]);
        }
        Session::flash('message', $msg);
        Session::flash('alert-class', 'alert-success');
        return redirect()->route('profiles');
    }
    public function show_save_profile($id)
    {
        $sampleType = SampleType::get();
        $branch = User::where('user_type', 2)->get();
        $data = Profiles::with('branches')->find($id);
        if($data){
          $data->branch_id =   $data->branches->pluck('branch_id')->toArray();
        }
        
        $get_parameter = Parameter::whereNull("deleted_at")->get();
        $category = Subcategory::where("is_deleted", '0')->get();
        return view("admin.profile.save")->with('sampleType',$sampleType)->with("data", $data)
        ->with("get_parameter", $get_parameter)->with("id", $id)->with("category", $category)->with('branch', $branch);
    }
    public function profiledatatable()
    {
        $pro = Profiles::all();
        return DataTables::of($pro)
            ->editColumn('id', function ($pro) {
                return $pro->id;
            })
            ->editColumn('profile_name', function ($pro) {
                return $pro->profile_name;
            })
            ->editColumn('no_of_parameter', function ($pro) {
                $arr = explode(",", $pro->no_of_parameter);
                return count($arr);
            })

            ->editColumn('frq', function ($parameter) {
                return $parameter->id;
            })
            ->editColumn('lab_report', function ($parameter) {
                return $parameter->lab_report;
            })

            ->editColumn('action', function ($pro) {
                $edittext = __('message.Edit');
                $deletetext = __('message.Delete');
                $edit = url('save_profile', array('id' => $pro->id));
                $delete = url('delete_profile', array('id' => $pro->id));
                return '<div class="adm-row-actions">'
                    .'<a href="'.$edit.'" class="adm-act adm-act--green"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>'.$edittext.'</a>'
                    .'<a onclick="delete_record(' . "'" . $delete . "'" . ')" class="adm-act adm-act--red"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>'.$deletetext.'</a>'
                    .'</div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function show_get_test_ids($type)
    {
        $txt = "<option value=''>Select Test</option>";
        if ($type == 1) { // parameters 
            $data = Parameter::whereNull('deleted_at')->get();
            foreach ($data as $d) {
                $txt = $txt . '<option value="' . $d->id . '"  data-price="' .$d->mrp.'" data-mrp="' .$d->mrp.'">' . $d->name .' - '.$d->mrp  . ' Rs</option>';
            }
        } else { // profile
            $data = Profiles::all();
            foreach ($data as $d) {
                $mrp = 0;
                $arr = explode(",", $d->no_of_parameter);
                foreach ($arr as $l) {
                    $mrp += Parameter::find($l) ? Parameter::find($l)->mrp : 0;
                }
                // $d->mrp=$mrp;
                
                $txt = $txt . '<option value="' . $d->id . '" data-price="' .$mrp.'" data-mrp="' .$d->mrp.'">' . $d->profile_name .' - MRP:- '.$mrp . '- Final:- '.$d->mrp.'Rs</option>';
            }
        }
        return $txt;
    }
    public function show_popular_package()
    {
        return view("admin.popular.default");
    }
    public function show_save_popular_package($id)
    {
        $data = Popular_package::find($id);
        if ($data) {
            if ($data->type == '1') { // package
                $data->typedata = Package::whereNull('deleted_at')->get();
            } else if ($data->type == '2') { // parmeter
                $data->typedata = Parameter::whereNull('deleted_at')->get();
            } else { // profile
                $data->typedata = Profiles::whereNull('deleted_at')->get();
            }
            return view("admin.popular.save")->with("data", $data)->with("id", $id);
        }
        if ($id == 0) {
            return view("admin.popular.save")->with("data", $data)->with("id", $id);
        } else {
            // Session::flash('message',"Something Wrong");
            Session::flash('message', __('message.Something Wrong'));
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
    }
    public function show_searchpopulartype($id)
    {
        $txt = "";
        if ($id == '1') { // package
            $data = Package::whereNull('deleted_at')->get();
            foreach ($data as $d) {
                $txt = $txt . '<option value =' . $d->id . '>' . $d->name . '</option>';
            }
        } else if ($id == '2') { // parmeter
            $data = Parameter::whereNull('deleted_at')->get();
            foreach ($data as $d) {
                $txt = $txt . '<option value =' . $d->id . '>' . $d->name . '</option>';
            }
        } else { // profile
            $data = Profiles::whereNull('deleted_at')->get();
            foreach ($data as $d) {
                $txt = $txt . '<option value =' . $d->id . '>' . $d->profile_name . '</option>';
            }
        }
        return $txt;
    }
    public function show_popularPackageTable()
    {
        $pro = Popular_package::all();
        return DataTables::of($pro)
            ->editColumn('id', function ($pro) {
                return $pro->id;
            })
            ->editColumn('name', function ($pro) {
                return $pro->name;
            })
            ->editColumn('action', function ($pro) {
                $edittext = __('message.Edit');
                $deletetext = __('message.Delete');
                $edit = url('save_popular_package', array('id' => $pro->id));
                $delete = url('delete_profile', array('id' => $pro->id));

                return '<a  href="' . $edit . '" rel="tooltip"  class="btn btn-success" data-original-title="banner" style="margin-right: 10px;color: white !important;">' . $edittext . '</a><a onclick="delete_record(' . "'" . $delete . "'" . ')" rel="tooltip"  class="btn btn-danger" data-original-title="Remove" style="margin-right: 10px;color:white !important">' . $deletetext . '</a>';
            })
            ->make(true);
    }
    public function show_update_popular_package(Request $request)
    {
        if ($request->get("id") == 0) {
            $store = new Popular_package();
            $msg = __('message.Popular Package Add Successfully');
        } else {
            $store = Popular_package::find($request->get("id"));
            $msg = __('message.Popular Package Add Successfully');
        }
        $store->name = $request->get("name");
        $store->type = $request->get("type");
        $store->type_id = $request->get("type_id");
        $store->save();
        Session::flash('message', $msg);
        Session::flash('alert-class', 'alert-success');
        return redirect()->route('popular-package');
    }
}
