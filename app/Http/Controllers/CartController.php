<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use DataTables;
use Session;
use App\Models\Setting;
use App\Models\CartMember;
use App\Models\FamilyMember;
use App\Models\TestDetails;
use Hash;
use Cart;
use Auth;
use App\Models\Package;
use App\Models\OrdersData;

use App\Models\Profiles;
use App\Models\Parameter;
class CartController extends Controller
{
    
    public function show_addcart(Request $request){        
        $options = array("mrp"=>$request->get("mrp"),"parameter"=>$request->get("parameter"),"item_id"=>$request->get("id"));
        Cart::add(rand().time(),$request->get("name"),$request->get("price"),1,$options);
        $cartCollection = Cart::getContent();
        return $cartCollection->count();
   }
   public function getcart_id_ajax(Request $request){
        $cart = CartMember::where('family_member_id',$request->member_id)->where('type_id',$request->book_type_id)->pluck('id');
        return $cart;
    }
    public function add_cart_member_ajax(Request $request){
   // dd($request->all());
    $list = $request->get("member");
    if($list == ""){
        return;
    }else{
            $data = new CartMember();
            $data->user_id = Auth::id();
            $data->family_member_id = $list;
            $data->type_id = $request->get("type_id");
            $data->type = $request->get("type");
            $data->parameter = $request->get("parameter");
            $data->save();
        
    }
        $defaultcityID = $this->getdefaultcityid(session()->get('cityName'));
        $totalcart = CartMember::where("user_id",Auth::id())->where("family_member_id",$list)->get();   
        $ls1 = array();
         foreach([$data] as $g){
                        $arr = array();
                        $getfamilyinfo = FamilyMember::find($g->family_member_id);
                        $arr['member_id'] = $g->family_member_id;
                        $arr['member_name'] = $getfamilyinfo->name;
                        $arr['relation'] = $getfamilyinfo->relation;
                        $arr['gender'] = $getfamilyinfo->gender;
                        $arr['age'] = $getfamilyinfo->age;
                        $arr['testdata']    = []; // always init
                        $getcartinfo = CartMember::where("user_id",Auth::id())->where("family_member_id",$g->family_member_id)->get();
                        foreach($getcartinfo as $g){
                          
                            $b = array();
                            if($g->type==1){
                                $item_data = Package::join('package_branch', 'packages.id', '=', 'package_branch.package_id')
                                                    ->whereIn('package_branch.branch_id', [$defaultcityID])->whereNull('packages.deleted_at')
                                                    ->select('packages.*','package_branch.mrp','package_branch.price')->find($g->type_id);
                                if($item_data){
                                    $find_pa = TestDetails::where("package_id", $item_data->id)->get();
                                    foreach ($find_pa as $d) {
                                    
                                        if ($d->type == 2) {
                                            $a = Profiles::find($d->type_id);
                                            if ($a) {
                                                $alr = explode(",", $a->no_of_parameter);
                                               
                                            }
                                        }
                                    }
                                    $dis_pa = $this->get_discount($item_data->id,'Package',$item_data->mrp);
                                }
                                
                            }else if($g->type==2){
                                $item_data = Parameter::join('parameter_branch', 'parameters.id', '=', 'parameter_branch.parameter_id')
                                ->whereIn('parameter_branch.branch_id', [$defaultcityID])
                                ->whereNull('parameters.deleted_at')
                                ->select('parameters.*','parameter_branch.mrp','parameter_branch.price')->find($g->type_id);
                               
                                if($item_data){
                                         $dis_pa = $this->get_discount($item_data->id,'Parameter',$item_data->mrp);
                                }
                           
                            }else{
                                $item_data = Profiles::join('profile_branch', 'profiles.id', '=', 'profile_branch.profile_id')
                                ->select('profiles.*','profile_branch.mrp','profile_branch.price')
                                ->whereIn('profile_branch.branch_id', [$defaultcityID])->find($g->type_id);
                                
                                if($item_data){
                                    $dis_pa = $this->get_discount($item_data->id,'Profiles',$item_data->mrp);
                                     $al = explode(",", $item_data->no_of_parameter);
                                   
                                   
                                    $item_data->name = $item_data->profile_name;
                                }
                            }
                            if($item_data){
                                $b['test_name'] = isset($item_data->name)?$item_data->name:'';
                                $b['mrp']= $item_data->mrp;
                                $b['price']= $item_data->price;
                                $b['parameter']=$g->parameter;
                                $b['type']=$g->type;
                                $b['discount'] = $dis_pa;
                                $b['id']=$g->id;
                                $b['type_id']=$g->type_id;
                                $arr['testdata'][]=$b;
                            }
                        }
                        // $ls1[] = $arr;
                        if (count($arr['testdata']) > 0) {
                            $ls1[] = $arr;
                         }
                    }
                
        $txt = 0;
        $total = $this->getcartsubtotal();
        $txt_charges =0;
        $main_total = $total+$txt_charges;
        
        $data1 = array("subtotal"=>number_format($total,2,'.',''),"txt"=>number_format($txt_charges,2,'.',''),
        "main_total"=>number_format($main_total,2,'.',''),"total_member_cart"=>count($totalcart),'data'=>$ls1);
        return $data1;
    // return response()->json(['success' => true, 'data'=>$data,'msg' => 'Added successfuly!']);
    
   }
   public function add_cart_member(Request $request){
   // dd($request->all());
    $list = $request->get("member");
    
    if(empty($list)){
        Session::flash('message',"Select Any Member.."); 
        Session::flash('alert-class', 'alert-danger');
        return redirect()->back();
    }else{
        foreach($list as $l){
            $data = new CartMember();
            $data->user_id = Auth::id();
            $data->family_member_id = $l;
            $data->type_id = $request->get("type_id");
            $data->type = $request->get("type");
            $data->parameter = $request->get("parameter");
            $data->save();
        } 
        Session::flash('message',"Test Book Successfully"); 
        Session::flash('alert-class', 'alert-success');
        return redirect('checkout');
    }
    
   }

   public function show_deletecart(Request $request){
        $setting = Setting::find(1);
        $data = CartMember::where("id",$request->get("id"))->first();
        $totalcart = count(CartMember::where("user_id",Auth::id())->where("family_member_id",$data->member_id)->get());        
        $txt = 0;
        $total = $this->getcartsubtotal();
        $txt_charges = ($total*$setting->txt_charge)/100;
        $main_total = $total+$txt_charges;
        $data1 = array("subtotal"=>number_format($total,2,'.',''),"txt"=>number_format($txt_charges,2,'.',''),"main_total"=>number_format($main_total,2,'.',''),"total_member_cart"=>$totalcart);
        return $data1;
   }

 public function deletemembercart(Request $request){
        $setting = Setting::find(1);
        $data = CartMember::where("id",$request->get("id"))->first();
        $member_id = $data->family_member_id;
        $data->delete();
        $totalcart = count(CartMember::where("user_id",Auth::id())->where("family_member_id",$member_id)->get());        
        $txt = 0;
        $total = $this->getcartsubtotal();
        $txt_charges = ($total*$setting->txt_charge)/100;
        $main_total = $total;
        $data1 = array("subtotal"=>number_format($total,2,'.',''),"txt"=>number_format($txt_charges,2,'.',''),
        "main_total"=>number_format($main_total,2,'.',''),"total_member_cart"=>$totalcart);
        return $data1;
   }

   public function addcustomizepackage(Request $request){
    $cartCollection = Cart::getContent();
     $ls = array();
     foreach ($cartCollection as $k) {
         $ls[] = array(
                'id' => $k['id'], // inique row ID
                'name' => $k['name'],
                'price' => $k['price'],
                'quantity' => 1,
                'attributes' => $k['attributes']
            );
     }
     Cart::session($request->get("id"))->add($ls);
     $store = new CartMember();
     $store->user_id = Auth::id();
     $store->family_member_id = $request->get("id");
     $store->save();    
     $setting = Setting::find(1);
     $getcurrency = explode("-",$setting->currency);
     $currency = $getcurrency[1];
     $getfamilymember = FamilyMember::find($request->get("id"));
     $txt = '<div class="col-xl-12 col-lg-12 col-md-12 doctors-block" id="cart_member_'.$request->get("id").'"><div class="team-block-three"><div class="inner-box"><div class="lower-content"><ul class="name-box clearfix"><li class="name"> <h3><a href="#">'.$getfamilymember->name.' | '.$getfamilymember->relation.'</a></h3></li></ul><span class="designation">'.$getfamilymember->gender.', '.$getfamilymember->age.' years</span>';
                $cartmem = Cart::session($request->get("id"))->getContent();
                foreach($cartmem as $item){
                    $discount = 100 * ($item['attributes']['mrp'] - $item['price']) / $item['attributes']['mrp'];
                    $txt = $txt.'<div class="row" id="member_'.$request->get("id").'_'.$item['id'].'" style="border-top: 1px solid #453f85;"><div class="col-md-9"><p>'.$item['name'].'</p><span>Parameters Included : '.$item['attributes']['parameter'].'</span><p><span style="text-decoration: line-through;    color: red;">'.$currency.$item['attributes']['mrp'].'</span> '.$currency.$item['price'].'</p></div><div class="col-md-3" ><p style="margin-top: 8px;margin-bottom: 19px;"><span style="background: green;color: white;    padding: 2px;">'.round($discount).'%</span></p><p><span></span></p> <input type="hidden" id="member_item_id_'.$request->get("id").'" value="'.$item['id'].'"><span><a href="javascript:void(0)" onclick="removememberitemoncart('.$request->get("id").')"><i class="fa fa-trash"></i></a></span></div></div>';
                }
        $txt = $txt.'</div></div></div></div>';
        $total = 0;
        $store = CartMember::where("user_id",Auth::id())->get();
        if(count($store)>0){
            foreach($store as $s){
                $total = $total+Cart::session($s->family_member_id)->getTotal();  
            }    
        }
        
        $txt_charges = ($total*$setting->txt_charge)/100;
        $main_total = $total+$txt_charges;
        $data = array("content"=>$txt,"subtotal"=>number_format($total,2,'.',''),"txt"=>number_format($txt_charges,2,'.',''),"main_total"=>number_format($main_total,2,'.',''));  
        return $data;
   }



   public function removecustomizepackage(Request $request){
        $data = Cart::session($request->get("id"))->getContent();
        foreach($data as $d){
            Cart::session($request->get("id"))->remove($d['id']);
        }    
        CartMember::where("user_id",Auth::id())->where("family_member_id",$request->get("id"))->delete();
        $total = 0;
        $store = CartMember::where("user_id",Auth::id())->get();
        if(count($store)>0){
            foreach($store as $s){
                $total = $total+Cart::session($s->family_member_id)->getTotal();  
            }    
        }
        $setting = Setting::find(1);
        $txt_charges = ($total*$setting->txt_charge)/100;
        $main_total = $total+$txt_charges;
        $data = array("content"=>"","subtotal"=>number_format($total,2,'.',''),"txt"=>number_format($txt_charges,2,'.',''),"main_total"=>number_format($main_total,2,'.',''));  
        return $data;
   }

   public function viewcartdata(){
      Cart::clear();
      $cartCollection = Cart::getContent();
      $data = Cart::session(1)->getContent();

      echo "<pre>";
      print_r($cartCollection);
      print_r($data);
      exit;
   }
}
