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
                           
                return '<a  href="'.$edit.'" rel="tooltip"  class="btn btn-success" data-original-title="banner" style="margin-right: 10px;color: white !important;">'.$edittext.'</a><a onclick="delete_record(' . "'" . $delete. "'" . ')" rel="tooltip"  class="btn btn-danger" data-original-title="Remove" style="margin-right: 10px;color:white !important">'.$deletetext.'</a>';              
            })           
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
