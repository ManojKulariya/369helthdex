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
                // Previously always returned a URL even with no file (image
                // empty), producing a broken <img> pointing at the bare
                // "Subcategory/" directory instead of rendering nothing.
                return $subcategory->image ? url("storage/app/public/Subcategory")."/".$subcategory->image : null;
            })
            ->editColumn('action', function ($subcategory) {
                $edittext =__('message.Edit');
                $deletetext = __('message.Delete');
                $edit = url('savesubcategory',array('id'=>$subcategory->id));
                $delete = url('deletesubcategory',array('id'=>$subcategory->id));
                return '<div class="adm-row-actions">'
                    .'<a href="'.$edit.'" class="adm-act adm-act--green"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>'.$edittext.'</a>'
                    .'<a onclick="delete_record(' . "'" . $delete. "'" . ')" class="adm-act adm-act--red"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>'.$deletetext.'</a>'
                    .'</div>';
            })
            ->rawColumns(['action'])
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
