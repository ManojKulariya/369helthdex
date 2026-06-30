<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use App\Models\Offer;
use App\Models\Vacancie;
use DataTables;
use Session;
use Auth;
use App\Models\Package;
use App\Models\Profiles;
use App\Models\Parameter;
use Hash;
use Storage;

class CategoryController extends Controller
{
     public function show_saveoffer($id){
        $data = Offer::find($id);
        $packages = Package::all();
        $test = Profiles::all();
        $Parameter = Parameter::all();
        $ids = Offer::where('id',$id)->pluck('type_id')->toArray();
        return view("admin.offer.savecategory")->with("id",$id)->with("data",$data)->with("packages", $packages)->with('test', $test)
        ->with('parameter', $Parameter)->with('ids',$ids);
    }
    public function show_category(){
        return view("admin.Category.default");
    }
    public function show_offer(){
        
        return view("admin.offer.default");
    }
    public function show_vacancies(){
        
        return view("admin.jobs.default");
    }
    public function offerdatatable(){
             $category = Offer::orderBy('id','DESC')->get();
             return DataTables::of($category)
                ->editColumn('id', function ($category) {
                    return $category->id;
                })
                ->editColumn('cat_name', function ($category) {
                    return $category->name;
                })
                ->editColumn('cat_image', function ($category) {
                    return url("storage/app/public/category")."/".$category->image;
                }) 
                ->editColumn('type', function ($category) {
                    return $category->type;
                })
                ->editColumn('type_id', function ($category) {
                    if($category->type == 'Package'){
            
                          $item_data = Package::find($category->type_id);
                         
                    }elseif($category->type == 'Parameter'){
                        
                         $item_data = Parameter::find($category->type_id);
                         
                    }else{
                         $item_data = Profiles::find($category->type_id);
                         if($item_data){
                                    $item_data->name = $item_data->profile_name;
                                }
                    }
                    $testname = isset($item_data->name)?$item_data->name:'';
                    return $testname;
                })
                ->editColumn('action', function ($category) {
                    $edittext =__('message.Edit');
                    $deletetext = __('message.Delete');
                    $edit = url('savecategory',array('id'=>$category->id));
                    $delete = url('deleteoffer',array('id'=>$category->id));
                    return '<a onclick="delete_record(' . "'" . $delete. "'" . ')" rel="tooltip"  class="btn btn-danger" data-original-title="Remove" style="margin-right: 10px;color:white !important">'.$deletetext.'</a>';              
                })           
                ->make(true);
        }
      public function jobdatatable(){
             $category = Vacancie::get();
             return DataTables::of($category)
                ->editColumn('id', function ($category) {
                    return $category->id;
                })
                ->editColumn('title', function ($category) {
                    return $category->title;
                })
                ->editColumn('openings', function ($category) {
                    return $category->openings;
                })
                ->editColumn('locations', function ($category) {
                    return $category->locations;
                })
                ->editColumn('experince', function ($category) {
                    return $category->experince;
                })
                ->editColumn('salary', function ($category) {
                    return $category->salary;
                })
                ->editColumn('department', function ($category) {
                    return $category->department;
                })
                ->editColumn('designations', function ($category) {
                    return $category->designations;
                })
                ->editColumn('status', function ($category) {
                    if($category->status== 1){
                        $txt = "Active";
                        
                    }else{
                        $txt = "Inactive";
                        
                    }
                    return $txt;              
              
                })
                ->editColumn('action', function ($category) {
                    $edittext =__('message.Edit');
                    $deletetext = __('message.Delete');
                    $edit = url('savevacancies',array('id'=>$category->id));
                    $delete = url('deletejob',array('id'=>$category->id));
                    return '<a  href="'.$edit.'" rel="tooltip"  class="btn btn-primary" data-original-title="banner" style="margin-right: 10px;color: white !important;">'.$edittext.'</a><a onclick="delete_record(' . "'" . $delete. "'" . ')" rel="tooltip"  class="btn btn-danger" data-original-title="Remove" style="margin-right: 10px;color:white !important">'.$deletetext.'</a>';              
                })           
                ->make(true);
        }
  
    public function categorydatatable(){
         $category =Category::orderBy('id','DESC')->get();
         return DataTables::of($category)
            ->editColumn('id', function ($category) {
                return $category->id;
            })
            ->editColumn('cat_name', function ($category) {
                return $category->name;
            })
            ->editColumn('cat_image', function ($category) {
                return url("storage/app/public/category")."/".$category->image;
            })      
            ->editColumn('action', function ($category) {
                $edittext =__('message.Edit');
                $deletetext = __('message.Delete');
                $edit = url('savecategory',array('id'=>$category->id));
                $delete = url('deletecategory',array('id'=>$category->id));
                return '<a  href="'.$edit.'" rel="tooltip"  class="btn btn-primary" data-original-title="banner" style="margin-right: 10px;color: white !important;">'.$edittext.'</a><a onclick="delete_record(' . "'" . $delete. "'" . ')" rel="tooltip"  class="btn btn-danger" data-original-title="Remove" style="margin-right: 10px;color:white !important">'.$deletetext.'</a>';              
            })           
            ->make(true);
    }
    public function show_savecategory($id){
        $data = Category::find($id);
        return view("admin.Category.savecategory")->with("id",$id)->with("data",$data);
    }
    public function savevacancies($id){
        $data = Vacancie::find($id);
        return view("admin.jobs.savecategory")->with("id",$id)->with("data",$data);
    }
    public function show_update_category(Request $request){
        if($request->get("id")==0){
            $store = new Category();    
            $rel_img = "";  
            $msg = __('message.Category Add Successfully');
        }else{
            $store=Category::find($request->get("id"));
            $msg = __('message.Category Update Successfully');
            if($store->image!=""&&$request->get("basic_img")!=""){
                $this->removeImage('category/' . $store->image);
            }
        }       
        $store->name = $request->get("name");
        if($request->file("upload_image")){
            if($request->get("basic_img")!=""){
                $store->image = $this->fileuploadFileImage($request, 'category', 'upload_image');
            }else{
                $store->image = $this->fileuploadFileImage($request, 'category', 'upload_image');
            }
        }
        $store->save();
        Session::flash('message',$msg); 
        Session::flash('alert-class', 'alert-success');
        return redirect()->route('admin-category');
    }
    public function show_update_offer(Request $request){
        if($request->get("id")==0){
            $store = new Offer();    
            $rel_img = "";  
            $msg = 'Offer Add Successfully';
        }else{
            $store=Offer::find($request->get("id"));
            $msg = 'Offer Update Successfully';
            if($store->image!=""&&$request->get("basic_img")!=""){
                $this->removeImage('category/' . $store->image);
            }
        }       
        $store->name = $request->get("name");
        if($request->get("type_id") == 'Package'){
            
             $select_ids =$request->get("select_package");
             
        }elseif($request->get("type_id") == 'Parameter'){
            
             $select_ids =$request->get("select_pera");
             
        }else{
             $select_ids =$request->get("select_test");
        }
        $store->type =  $request->get("type_id");
        $store->type_id = $select_ids;
        $uploadFolderName = 'category';
        if($request->file("upload_image")){
            if($request->get("basic_img")!=""){
               
                $image = $request->file('upload_image');
                $fileName = time().rand() . '.' . $image->getClientOriginalExtension();
            
                // Save the image without resizing or compression
                Storage::disk('local')->putFileAs('/public/'.$uploadFolderName, $image, $fileName, 'public');
            
                 $store->image =  $fileName;
            }else{
                $image = $request->file('upload_image');
                    $fileName = time().rand() . '.' . $image->getClientOriginalExtension();
                
                    // Save the image without resizing or compression
                    Storage::disk('local')->putFileAs('/public/'.$uploadFolderName, $image, $fileName, 'public');
                
                     $store->image =  $fileName;
            }
        }
        $store->save();
        Session::flash('message',$msg); 
        Session::flash('alert-class', 'alert-success');
        return redirect()->route('admin-offer');
    }
    public function show_update_job(Request $request){
        if($request->get("id")==0){
            $store = new Vacancie();    
            $rel_img = "";  
            $msg = 'Vacancie Add Successfully';
        }else{
            $store=Vacancie::find($request->get("id"));
            $msg = 'Vacancie Update Successfully';
            
        }       
        $store->title = $request->get("title");
        $store->openings = $request->get("openings");
        $store->locations = $request->get("locations");
        $store->description = $request->get("description");
        $store->experince = $request->get("experince");
        $store->qualification = $request->get("qualification");
        $store->salary = $request->get("salary");
        $store->skills = $request->get("skills");
        $store->department = $request->get("department");
        $store->designations = $request->get("designations");
        $store->status = $request->get("status");
       
        
        $store->save();
        Session::flash('message',$msg); 
        Session::flash('alert-class', 'alert-success');
        return redirect()->route('vacancies');
    }
    public function deletecategory($id){        
        $data = Category::find($id); 
        $data->delete();       
        Session::flash('message',__('message.Category Delete Successfully')); 
        Session::flash('alert-class', 'alert-success');
        return redirect()->route('admin-category');
    }
    public function deleteoffer($id){        
        $data = Offer::find($id); 
        $data->delete();       
        Session::flash('message',' Delete Successfully'); 
        Session::flash('alert-class', 'alert-success');
        return redirect()->route('admin-offer');
    }
    public function deletejob($id){        
        $data = Vacancie::find($id); 
        $data->delete();       
        Session::flash('message',' Delete Successfully'); 
        Session::flash('alert-class', 'alert-success');
        return redirect()->route('vacancies');
    }
}
