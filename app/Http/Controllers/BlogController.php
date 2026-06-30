<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Share;
use App\Models\Like;
use App\Models\Comment;
use DataTables;
use Session;
use Auth;
use Hash;
use App\Models\Tag;

class BlogController extends Controller
{
    public function show_blog(){
        
        return view("admin.blog.default");
    }
    public function toggleLike($postId)
    {
        $like = Like::where('blog_id', $postId)
            ->where('user_id', auth()->id())
            ->first();
    
        if ($like) {
            $like->delete();
        } else {
            Like::create([
                'blog_id' => $postId,
                'user_id' => auth()->id(),
            ]);
        }
    
        return response()->json([
            'likes_count' => Blog::find($postId)->likes()->count()
        ]);
    }
    public function storecomment(Request $request, $postId)
    {
        $request->validate([
            'comment' => 'required|string'
        ]);
    
        $comment = Comment::create([
            'blog_id' => $postId,
            'user_id' => auth()->id(),
            'comment' => $request->comment,
        ]);
    
        return back()->with('success', 'Comment added!');
    }
    public function storeShare($postId, $platform)
    {
            Share::create([
            'user_id' => auth()->id() ?? null, // nullable for guest
            'blog_id' => $postId,
            'platform' => $platform,
        ]);
    
        return response()->json(['success' => true]);
    }


    
    public function blogdatatable(){
        
        $blog =Blog::orderBy('id','DESC')->get();
        
        // dd($blog);
         return DataTables::of($blog)
            ->editColumn('id', function ($blog) {
                return $blog->id;
            })
            ->editColumn('blog_name', function ($blog) {
                return $blog->name;
            })
           
            ->editColumn('blog_image', function ($blog) {
                return url("storage/app/public/Blog")."/".$blog->image;
            })      
            ->editColumn('action', function ($blog) {
                $edittext =__('message.Edit');
                $deletetext = __('message.Delete');
                $edit = url('saveblog',array('id'=>$blog->id));
                $delete = url('deleteblog',array('id'=>$blog->id));
                return '<a  href="'.$edit.'" rel="tooltip"  class="btn btn-primary" data-original-title="banner" style="margin-right: 10px;color: white !important;">'.$edittext.'</a><a onclick="delete_record(' . "'" . $delete. "'" . ')" rel="tooltip"  class="btn btn-danger" data-original-title="Remove" style="margin-right: 10px;color:white !important">'.$deletetext.'</a>';              
            })           
            ->make(true);
    }
    
    public function show_saveblog($id){
        $data = Blog::find($id);
        
        $tag =  Tag::all();
        return view("admin.blog.saveblog")->with("id",$id)->with("data",$data)->with("tag",$tag);
    }
    public function show_update_saveblog(Request $request){
        // dd($request->all());
        if($request->get("id")==0){
            $store = new Blog();    
            $rel_img = "";  
            $msg = __('message.Blog Add Successfully');
        }else{
            $store=Blog::find($request->get("id"));
            $msg = __('message.Blog Update Successfully');
            if($store->image!=""&&$request->get("basic_img")!=""){
                $this->removeImage('Blog/' . $store->image);
            }
        }       
        $selectedTags = $request->get('tag'); // This will be an array of tag IDs

        // Example: Save as comma-separated string (not ideal, but simple)
        $tags = implode(',', $selectedTags);
        $store->tag = $tags;
        
        $store->name = $request->get("name");
        $store->slug = Str::slug($request->get("name"));
         
        $store->short_desc = $request->get("short_desc");
        $store->description = $request->get("description");
        if($request->file("upload_image")){
            if($request->get("basic_img")!=""){
                $store->image = $this->fileuploadFileImageblod($request, 'Blog', 'upload_image');
            }else{
                $store->image = $this->fileuploadFileImageblod($request, 'Blog', 'upload_image');
            }
        }
        $store->save();
        Session::flash('message',$msg); 
        Session::flash('alert-class', 'alert-success');
        return redirect()->route('admin-blog');
    }
    
    public function deleteblog($id){        
        $data = Blog::find($id); 
        $data->delete();       
        Session::flash('message',__('message.Blog Delete Successfully')); 
        Session::flash('alert-class', 'alert-success');
        return redirect()->route('admin-blog');
    }
}
