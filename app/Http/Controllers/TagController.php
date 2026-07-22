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
                return '<div class="adm-row-actions">'
                    .'<a href="' . $edit . '" class="adm-act adm-act--green"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>' . $edittext . '</a>'
                    .'<a onclick="delete_record(' . "'" . $delete . "'" . ')" class="adm-act adm-act--red"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>' . $deletetext . '</a>'
                    .'</div>';
            })
            ->rawColumns(['action'])
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
        if ($data) {
            $data->delete();
            Session::flash('message',__('message.Tag Delete Successfully'));
            Session::flash('alert-class', 'alert-success');
        }
        return redirect()->route('admin-tag');
    }

    
}
