<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Tag;
use DataTables;
use Session;
use Auth;
use Hash;

class TagController extends Controller
{
    public function show_tag(){
        
        return view("admin.tag.default");
    }
    
    public function tagdatatable(){
        
        $tag =Tag::orderBy('id','DESC')->get();
        //dd($tag);
         return DataTables::of($tag)
            ->editColumn('id', function ($tag) {
                return $tag->id;
            })
            ->editColumn('tag_name', function ($tag) {
                return $tag->name;
            })
           ->editColumn('action', function ($tag) {
                $edittext =__('message.Edit');
                $deletetext = __('message.Delete');
                $edit = url('savetag',array('id'=>$tag->id));
                $delete = url('deletetag',array('id'=>$tag->id));
                return '<a  href="'.$edit.'" rel="tooltip"  class="btn btn-primary" data-original-title="banner" style="margin-right: 10px;color: white !important;">'.$edittext.'</a><a onclick="delete_record(' . "'" . $delete. "'" . ')" rel="tooltip"  class="btn btn-danger" data-original-title="Remove" style="margin-right: 10px;color:white !important">'.$deletetext.'</a>';              
            })           
            ->make(true);
    }
    
    public function show_savetag($id){
        $data = Tag::find($id);
        return view("admin.tag.savetag")->with("id",$id)->with("data",$data);
    }
    public function show_update_savetag(Request $request){
        // dd($request->all());
        if($request->get("id")==0){
            $store = new Tag();    
            $rel_img = "";  
            $msg = __('message.Tag Add Successfully');
        }else{
            $store=Tag::find($request->get("id"));
            $msg = __('message.Tag Update Successfully');
            
        }       
        $store->name = $request->get("name");
        $store->slug = Str::slug($request->get("name"));
       
        
        $store->save();
        Session::flash('message',$msg); 
        Session::flash('alert-class', 'alert-success');
        return redirect()->route('admin-tag');
    }
    
    public function deletetag($id){        
        $data = Tag::find($id); 
        $data->delete();       
        Session::flash('message',__('message.Tag Delete Successfully')); 
        Session::flash('alert-class', 'alert-success');
        return redirect()->route('admin-tag');
    }

    
}
