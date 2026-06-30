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
use App\Models\SampleType;
use App\Models\Parameter;
use Hash;
use Storage;

class SampleController extends Controller
{

    public function show_sample(){
        return view("admin.SampleType.default");
    }
   
    public function categorydatatable(){
         $category =SampleType::orderBy('id','DESC')->get();
         return DataTables::of($category)
            ->editColumn('id', function ($category) {
                return $category->id;
            })
            ->editColumn('sample_name', function ($category) {
                return $category->sample_name;
            })
                 
            ->editColumn('action', function ($category) {
                $edittext =__('message.Edit');
                $deletetext = __('message.Delete');
                $edit = url('savesample',array('id'=>$category->id));
                $delete = url('deletesample',array('id'=>$category->id));
                return '<a  href="'.$edit.'" rel="tooltip"  class="btn btn-primary" data-original-title="banner" style="margin-right: 10px;color: white !important;">'.$edittext.'</a><a onclick="delete_record(' . "'" . $delete. "'" . ')" rel="tooltip"  class="btn btn-danger" data-original-title="Remove" style="margin-right: 10px;color:white !important">'.$deletetext.'</a>';              
            })           
            ->make(true);
    }
    public function show_savesample($id){
        $data = SampleType::find($id);
        return view("admin.SampleType.savecategory")->with("id",$id)->with("data",$data);
    }
   
    public function update_sample(Request $request){
        if($request->get("id")==0){
            $store = new SampleType();    
            $rel_img = "";  
            $msg = "Sample Add Successfully";
        }else{
            $store=SampleType::find($request->get("id"));
            $msg = "Sample Update Successfully";
        }       
        $store->sample_name = $request->get("sample_name");
        $store->save();
        Session::flash('message',$msg); 
        Session::flash('alert-class', 'alert-success');
        return redirect()->route('show-sample');
    }
    public function deletecategory($id){        
        $data = SampleType::find($id); 
        $data->delete();       
        Session::flash('message','Sample Delete Successfully'); 
        Session::flash('alert-class', 'alert-success');
        return redirect()->route('show-sample');
    }
    
}
