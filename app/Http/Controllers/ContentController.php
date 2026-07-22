<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\Models\Content;
use DataTables;
use Session;
use Auth;
use Hash;

class ContentController extends Controller
{
    public function show_content(){
        return view("admin.content.default");
    }
    
    public function contentdatatable(){
         $content =Content::orderBy('id','DESC')->get();
         // dd($content);
         return DataTables::of($content)
            ->editColumn('id', function ($content) {
                return $content->id;
            })
            
            ->editColumn('page_name', function ($content) {
                return $content->page_name;
            })
            
            ->editColumn('content_name', function ($content) {
                return $content->name;
            })
           
            ->editColumn('content_image', function ($content) {
                return url("storage/app/public/Content")."/".$content->image;
            })  
            
            ->editColumn('action', function ($content) {
                $edittext =__('message.Edit');
                $deletetext = __('message.Delete');
                $edit = url('savecontent',array('id'=>$content->id));
                $delete = url('deletecontent',array('id'=>$content->id));
                return '<div class="adm-row-actions">'
                    .'<a href="' . $edit . '" class="adm-act adm-act--green"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>' . $edittext . '</a>'
                    .'<a onclick="delete_record(' . "'" . $delete . "'" . ')" class="adm-act adm-act--red"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>' . $deletetext . '</a>'
                    .'</div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    
    public function show_savecontent($id){
        $data = Content::find($id);
        
        return view("admin.content.savecontent")->with("id",$id)->with("data",$data);
    }
    public function show_update_savecontent(Request $request){
        // dd($request->all());
        
        if($request->get("id")==0){
            $store = new Content();    
            $rel_img = "";  
            $msg = __('message.Content Add Successfully');
        }else{
            $store=Content::find($request->get("id"));
            $msg = __('message.Content Update Successfully');
            if($store->image!=""&&$request->get("basic_img")!=""){
                $this->removeImage('Content/' . $store->image);
            }
        } 
        $store->page_name = $request->get("page_name");
        $store->name = $request->get("name");
        $store->slug = Str::slug($request->get("name"));
         
        $store->short_desc = $request->get("short_desc");
        $store->description = $request->get("description");
        if($request->file("upload_image")){
            if($request->get("basic_img")!=""){
                $store->image = $this->fileuploadFileImage($request, 'Content', 'upload_image');
            }else{
                $store->image = $this->fileuploadFileImage($request, 'Content', 'upload_image');
            }
        }
        $store->save();
        Session::flash('message',$msg); 
        Session::flash('alert-class', 'alert-success');
        return redirect()->route('admin-content');
    }
    
    public function deletecontent($id){
        $data = Content::find($id);
        if ($data) {
            $data->delete();
            Session::flash('message',__('message.Content Delete Successfully'));
            Session::flash('alert-class', 'alert-success');
        }
        return redirect()->route('admin-content');
    }
}
