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
                return '<div class="adm-row-actions">'
                    .'<a href="'.$edit.'" class="adm-act adm-act--green"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>'.$edittext.'</a>'
                    .'<a onclick="delete_record(' . "'" . $delete. "'" . ')" class="adm-act adm-act--red"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>'.$deletetext.'</a>'
                    .'</div>';
            })
            ->rawColumns(['action'])
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
