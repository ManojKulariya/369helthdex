<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Session;
use App\Models\City;

class CityController extends Controller
{
    public function show_city(){
        return view("admin.City.default");
    }
    public function citydatatable(){
        $city =City::where("is_deleted",'0')->get();
         return DataTables::of($city)
            ->editColumn('id', function ($city) {
                return $city->id;
            })
            ->editColumn('city_name', function ($city) {
                return $city->name;
            })  
            ->editColumn('city', function ($city) {
                return $city->city;
            }) 
            ->editColumn('default', function ($city) {
                return $city->default;
            }) 
            ->editColumn('action', function ($city) {
                $edittext =__('message.Edit');
                $deletetext = __('message.Delete');
                $edit = url('savecity',array('id'=>$city->id));
                $delete = url('deletecity',array('id'=>$city->id));
                return '<div class="adm-row-actions">'
                    .'<a href="'.$edit.'" class="adm-act adm-act--green"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>'.$edittext.'</a>'
                    .'<a onclick="delete_record(' . "'" . $delete. "'" . ')" class="adm-act adm-act--red"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>'.$deletetext.'</a>'
                    .'</div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function save_city($id){
        $data = City::find($id);
        return view("admin.City.savecity")->with("id",$id)->with("data",$data);
    }

    public function post_city(Request $request){
        //dd($request->all());
        if($request->get("id")==0){
            $store = new City();
            $msg = "Location Add Successfully";

        }else{
            $store = City::find($request->get("id"));
            // $msg = "City Update Successfully";
            $msg = "Location Update Successfully";
        }
        $store->name = $request->get("name");
        $store->city = $request->get("city");
        $store->default = $request->get("default");
        $store->lat = $request->get("lat");
        $store->lng = $request->get("lng");
        $store->save();
        Session::flash('message',$msg); 
        Session::flash('alert-class', 'alert-success');
        return redirect()->route('admin-city');
    }

    public function delete_city($id){
        $data = City::find($id);
       if($data){
            $data->is_deleted = '1';
            $data->delete();
        }        
        // Session::flash('message',"City Delete Successfully"); 
        Session::flash('message',__('message.City Delete Successfully'));
        Session::flash('alert-class', 'alert-success');
        return redirect()->route('admin-city');
    }
}
