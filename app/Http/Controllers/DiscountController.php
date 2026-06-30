<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Session;
use App\Models\City;
use App\Models\Package;
use App\Models\Profiles;
use App\Models\Parameter;
use App\Models\Discount;
use App\Models\Discountid;

class DiscountController extends Controller
{
    public function show_discount(){
        return view("admin.discount.default");
    }
    public function discountdatatable(){
        $discount =Discount::get();
         return DataTables::of($discount)
            ->editColumn('id', function ($discount) {
                return $discount->id;
            })
            ->editColumn('city_name', function ($discount) {
                return $discount->dis_name;
            })  
            ->editColumn('dis_type', function ($discount) {
                return $discount->dis_type;
            }) 
            ->editColumn('discount', function ($discount) {
                return $discount->discount;
            }) 
            ->editColumn('type_id', function ($discount) {
                return $discount->type_id;
            }) 
            ->editColumn('date_range', function ($discount) {
                $dateRange = $discount->start_date . ' to ' . $discount->end_date;
                return $dateRange;
            }) 
            ->editColumn('action', function ($discount) { 
                $edittext =__('message.Edit');
                $deletetext = __('message.Delete');  
                $edit = url('savediscount',array('id'=>$discount->id));
                $delete = url('deletediscount',array('id'=>$discount->id));
                           
                return '<a  href="'.$edit.'" rel="tooltip"  class="btn btn-success" data-original-title="banner" style="margin-right: 10px;color: white !important;">'.$edittext.'</a><a onclick="delete_record(' . "'" . $delete. "'" . ')" rel="tooltip"  class="btn btn-danger" data-original-title="Remove" style="margin-right: 10px;color:white !important">'.$deletetext.'</a>';              
            })           
            ->make(true);
    }

    public function save_discount($id){
        $data = Discount::find($id);
        $packages = Package::all();
        $test = Profiles::all();
        $Parameter = Parameter::all();
        $ids = Discountid::where('dis_id',$id)->pluck('test_id')->toArray();
        // dd($ids);
        return view("admin.discount.save")->with("id",$id)->with("data",$data)->with("packages", $packages)->with('test', $test)
        ->with('parameter', $Parameter)->with('ids', $ids);
    }

    public function post_discount(Request $request){
        // dd($request->all());
        if($request->get("id")==0){
            $store = new Discount();
            $msg = "Discount Add Successfully";
        }else{
            $store = Discount::find($request->get("id"));
            $msg = "Discount Update Successfully";
        }
        $dateRange = $request->input('date_range');
        [$startDate, $endDate] = explode(' to ', $dateRange);
        $store->dis_name = $request->get("dis_name");
        $store->dis_type = $request->get("dis_type");
        $store->discount = $request->get("discount");
        $store->type_id = $request->get("type_id");
        $store->start_date = $startDate;
        $store->end_date = $endDate;
        $store->save();
        Discountid::where('dis_id',$store->id)->delete();
        if($request->get("type_id") == 'Package'){
            
             $select_ids =$request->get("select_package");
             
        }elseif($request->get("type_id") == 'Parameter'){
            
             $select_ids =$request->get("select_pera");
             
        }else{
             $select_ids =$request->get("select_test");
        }
       
        foreach($select_ids as $select_id){
            $storeids = new Discountid();
            $storeids->dis_id = $store->id;
            $storeids->type =  $store->type_id;
            $storeids->test_id = $select_id;
            $storeids->save();
        }
        Session::flash('message',$msg); 
        Session::flash('alert-class', 'alert-success');
        return redirect()->route('admin-discount');
    }

    public function delete_discount($id){
        $data = Discount::find($id);
        if($data){
            $data->delete();
            Discountid::where('dis_id',$id)->delete();
        }   
        
       
        // Session::flash('message',"City Delete Successfully"); 
        Session::flash('message','Discount Delete Successfully');
        Session::flash('alert-class', 'alert-success');
        return redirect()->route('admin-discount');
    }
}
