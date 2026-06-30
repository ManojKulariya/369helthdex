<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use App\Models\Subcategory;
use DataTables;
use Session;
use Auth;
use Hash;

class SubcategoryController extends Controller
{
    public function show_subcategory(){
        return view("admin.Subcategory.default");
    }
    public function show_savesubcategory($id){
        $data = Subcategory::find($id);
        $category = Category::all();
        return view("admin.Subcategory.savesubcategory")->with("id",$id)->with("data",$data)->with("category",$category);
    }
    public function show_update_subcategory(Request $request){
        // dd($request->all());
        if($request->get("id")==0){
            $store = new Subcategory();    
            $rel_img = "";  
            $msg = __('message.Category Add Successfully');
        }else{
            $store=Subcategory::find($request->get("id"));
            $msg = __('message.Category Update Successfully');
            if($store->image!=""&&$request->get("basic_img")!=""){
                $this->removeImage('Subcategory/' . $store->image);
            }
        }       
        $store->name = $request->get("name");
      //  $store->category_id = $request->get("category");
        $store->short_desc = $request->get("short_desc");
        $store->description = $request->get("description");
        if($request->file("upload_image")){
            if($request->get("basic_img")!=""){
                $store->image = $this->fileuploadFileImage($request, 'Subcategory', 'upload_image');
            }else{
                $store->image = $this->fileuploadFileImage($request, 'Subcategory', 'upload_image');
            }
        }
        $store->save();
        Session::flash('message',$msg); 
        Session::flash('alert-class', 'alert-success');
        return redirect()->route('admin-subcategory');
    }
    public function subcategorydatatable(){
         $subcategory =Subcategory::orderBy('id','DESC')->get();
         return DataTables::of($subcategory)
            ->editColumn('id', function ($subcategory) {
                return $subcategory->id;
            })
            ->editColumn('sub_name', function ($subcategory) {
                return $subcategory->name;
            })
           
            ->editColumn('sub_image', function ($subcategory) {
                return url("storage/app/public/Subcategory")."/".$subcategory->image;
            })      
            ->editColumn('action', function ($subcategory) {
                $edittext =__('message.Edit');
                $deletetext = __('message.Delete');
                $edit = url('savesubcategory',array('id'=>$subcategory->id));
                $delete = url('deletesubcategory',array('id'=>$subcategory->id));
                return '<a  href="'.$edit.'" rel="tooltip"  class="btn btn-primary" data-original-title="banner" style="margin-right: 10px;color: white !important;">'.$edittext.'</a><a onclick="delete_record(' . "'" . $delete. "'" . ')" rel="tooltip"  class="btn btn-danger" data-original-title="Remove" style="margin-right: 10px;color:white !important">'.$deletetext.'</a>';              
            })           
            ->make(true);
    }
    public function deletesubcategory($id){        
        $data = Subcategory::find($id); 
        $data->delete();       
        Session::flash('message',__('message.Category Delete Successfully')); 
        Session::flash('alert-class', 'alert-success');
        return redirect()->route('admin-subcategory');
    }
}
