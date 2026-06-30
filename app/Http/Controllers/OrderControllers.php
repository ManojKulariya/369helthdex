<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use App\Models\Subcategory;
use DataTables;
use App\Models\Orders;
use App\Models\OrdersData;
use App\Models\UserAddress;
use App\Models\Setting;
use App\Models\Token;
use App\Models\PaymentGateway;
use App\Models\Report;
use App\Models\Homevisit;
use App\Models\Profiles;
use App\Models\Package;
use App\Models\Parameter;
use App\Models\TestDetails;
use App\Models\Coupon;
use App\Models\CartMember;
use App\Models\Payment;
use App\Models\FamilyMember;
use App\Models\Notification;
use Session;
use Auth;
use Hash;
use Mail;
use Illuminate\Support\Facades\Http;
use DB;
use App\Models\Discountid;
use App\Models\Discount;
use Carbon\Carbon;

class OrderControllers extends Controller
{
    public $currentDate;
    public function __construct()
    {
         $this->currentDate = Carbon::now();

    }
    public function show_order()
    {
        $labs = User::where('user_type',2)->get();
        return view("admin.orders.default")->with('labs',$labs);
    }
    public function show_report_view($id)
    {
        $data = Report::where('order_id', $id)->get();
        return view("manager.order.report")->with('reportdata', $data);

    }
    public function show_report_view_admin($id)
    {
        $data = Report::where('order_id', $id)->get();
        return view("admin.orders.report")->with('reportdata', $data);

    }
    public function sampleboy_check_out(Request $request)
    {
        $trashedItems = json_decode($request->trsh, true);
        $bookedItems = json_decode($request->book, true);
        $order_id = $request->order_id;
        $order_status = Orders::find($order_id);
        $ls1 = array();
        // Extract all 'id' values from $trashedItems
        if (isset($request->trsh) || $request->trsh != '') {
            if (count($trashedItems) != 0) {
                $idArray = array_column($trashedItems, 'id');
                $filteredOrdersData = OrdersData::where('order_id', $order_id)
                    ->whereNotIn('id', $idArray)
                    ->get();

                foreach ($filteredOrdersData as $g) {
                    $b = array();
                    if ($g->type == 1) {
                        $item_data = Package::find($g->item_id);
                        
                        $dis_pa = $this->get_discount($item_data->id,'Package',$item_data->mrp);
                    } else if ($g->type == 2) {
                        $item_data = Parameter::find($g->item_id);
                        $dis_pa = $this->get_discount($item_data->id,'Parameter',$item_data->mrp);
                    } else {
                        $item_data = Profiles::find($g->item_id);
                        $dis_pa = $this->get_discount($item_data->id,'Profiles',$item_data->mrp);
                        if ($item_data) {
                            $item_data->name = $item_data->profile_name;
                        }
                    }
                    $b['test_name'] = isset($item_data->name) ? $item_data->name : '';
                    $b['mrp'] = isset($item_data->mrp) ? $item_data->mrp : '';
                    if ($dis_pa['fixed'] > 0.00 ) {
                    $per = $dis_pa['per'];
                    $price = $item_data['mrp'] - $dis_pa['fixed'];
                    }else{
                     $price = $item_data['mrp'];
                    }
                    $b['price'] = $price;
                    $b['parameter'] = $g->parameter;
                    $b['type'] = $g->type;
                    $b['id'] = $g->id;
                    $b['type_id'] = $g->item_id;
                    $getfamilyinfo = FamilyMember::find($g->family_member_id);
                    $b['member_id'] = $g->family_member_id;
                    $b['member_name'] = isset($getfamilyinfo->name) ? $getfamilyinfo->name : "";
                    $b['relation'] = isset($getfamilyinfo->relation) ? $getfamilyinfo->relation : '';
                    $b['gender'] = isset($getfamilyinfo->gender) ? $getfamilyinfo->gender : '';
                    $b['age'] = isset($getfamilyinfo->age) ? $getfamilyinfo->age : '';

                    $ls1[] = $b;

                }

            }
            echo "1";
            echo "<pre>";
        print_r($ls1);dd();
        } else {
            $filteredOrdersData = OrdersData::where('order_id', $order_id)->get();

            foreach ($filteredOrdersData as $g) {
                $b = array();
                if ($g->type == 1) {
                    $item_data = Package::find($g->item_id);
                    $dis_pa = $this->get_discount($item_data->id,'Package',$item_data->mrp);
                } else if ($g->type == 2) {
                    $item_data = Parameter::find($g->item_id);
                    $dis_pa = $this->get_discount($item_data->id,'Parameter',$item_data->mrp);
                } else {
                    $item_data = Profiles::find($g->item_id);
                    $dis_pa = $this->get_discount($item_data->id,'Profiles',$item_data->mrp);
                    if ($item_data) {
                        $item_data->name = $item_data->profile_name;
                    }
                }
                $b['test_name'] = isset($item_data->name) ? $item_data->name : '';
                $b['mrp'] = isset($item_data->mrp) ? $item_data->mrp : '';
                if ($dis_pa['fixed'] > 0.00 ) {
                    $per = $dis_pa['per'];
                    $price = $item_data['mrp'] - $dis_pa['fixed'];
                    }else{
                     $price = $item_data['mrp'];
                    }
                // $b['price'] = $price;
                // $b['price'] = isset($item_data->price) ? $item_data->price : '';
                $b['price'] = $g->price;
                $b['parameter'] = $g->parameter;
                $b['type'] = $g->type;
                $b['id'] = $g->id;
                $b['type_id'] = $g->item_id;
                $getfamilyinfo = FamilyMember::find($g->family_member_id);
                $b['member_id'] = $g->family_member_id;
                $b['member_name'] = isset($getfamilyinfo->name) ? $getfamilyinfo->name : "";
                $b['relation'] = isset($getfamilyinfo->relation) ? $getfamilyinfo->relation : '';
                $b['gender'] = isset($getfamilyinfo->gender) ? $getfamilyinfo->gender : '';
                $b['age'] = isset($getfamilyinfo->age) ? $getfamilyinfo->age : '';

                $ls1[] = $b;

            }
        
        }
       
        if (isset($request->book) || $request->book != '') {
            if (count($bookedItems) != 0) {

                foreach ($bookedItems as $g) {
                    $b = array();
                    $item_id = $g['item_id'];
                    $type = $g['type'];
                    if ($type == 1) {
                        $item_data = Package::find($item_id);
                         $dis_pa = $this->get_discount($item_data->id,'Package',$item_data->mrp);
                    } else if ($type == 2) {
                        $item_data = Parameter::find($item_id);
                         $dis_pa = $this->get_discount($item_data->id,'Parameter',$item_data->mrp);
                    } else {
                        $item_data = Profiles::find($item_id);
                         $dis_pa = $this->get_discount($item_data->id,'Profiles',$item_data->mrp);
                        if ($item_data) {
                            $item_data->name = $item_data->profile_name;
                        }
                    }
                    $b['test_name'] = isset($item_data->name) ? $item_data->name : '';
                    $b['mrp'] = isset($item_data->mrp) ? $item_data->mrp : '';
                    if($dis_pa['fixed'] > 0.00 ) {
                    $per = $dis_pa['per'];
                    $price = $item_data['mrp'] - $dis_pa['fixed'];
                    }else{
                     $price = $item_data['mrp'];
                    }
                    $b['price'] = $price;
                    // $b['price'] = isset($item_data->price) ? $item_data->price : '';
                    $b['parameter'] = $g['parameter'];
                    $b['type'] = $type;
                    $b['id'] = $item_id;
                    $b['type_id'] = $item_id;
                    $getfamilyinfo = FamilyMember::find($g['familyMember']);
                    $b['member_id'] = $g['familyMember'];
                    $b['member_name'] = isset($getfamilyinfo->name) ? $getfamilyinfo->name : "";
                    $b['relation'] = isset($getfamilyinfo->relation) ? $getfamilyinfo->relation : '';
                    $b['gender'] = isset($getfamilyinfo->gender) ? $getfamilyinfo->gender : '';
                    $b['age'] = isset($getfamilyinfo->age) ? $getfamilyinfo->age : '';
                    $ls1[] = $b;

                }
            }
        }
        

        $Coupon = collect();
        foreach ($ls1 as $cp) {
            $Coupon = $Coupon->merge(
                Coupon::with(['test', 'package', 'parameter'])
                    ->where('type', $cp['type'])
                    ->where('product_ids', 'REGEXP', '[[:<:]]' . $cp['type_id'] . '[[:>:]]')
                    ->where('coupon_start_date', '<=', date('Y-m-d'))
                    ->where('coupon_end_date', '>=', date('Y-m-d'))
                    ->get()
            );
        }
        $Coupon = $Coupon->merge(
            Coupon::with(['test', 'package', 'parameter'])
                ->where('type', 4)
                ->where('coupon_start_date', '<=', date('Y-m-d'))
                ->where('coupon_end_date', '>=', date('Y-m-d'))
                ->get()
        );
        $setting = Setting::first();
        $getcurrency = explode("-", $setting->currency);

        return view("manager.order.checkout")->with('order_status', $order_status)->with("currency", $getcurrency[1])
            ->with("order_id", $order_id)->with("setting", $setting)->with('coupon', $Coupon)->with("cart", $ls1);

    }
    public function post_Book_order(Request $request)
    {
        $cart_data = json_decode($request->book_test);
        
        $user = Auth::user();

        if ($user->user_type == 2) {
            $member = $user->id;
        } else {
            $member = $user->sample_branch;
        }
        $subtotal = $request->get("subtotal");
        $final_total = $request->get("final_total");
        $store = Orders::find($request->order_id);
        #------------------coupon----------------
        $price = 0;
        $discount = 0;
        if (isset($request['coupon_id']) && $request['coupon_id'] !== '' && $request['coupon_id'] !== null) {
            $coupon_data = Coupon::where('coupon_code', $request['coupon_id'])->first();
           
            if ($coupon_data) {
                $today = date('l');
                $days = explode(',', $coupon_data->day);
                foreach ($days as $dy) {
                    if ($dy == $today) {

                        if ($coupon_data->type == 4) {
                            $price = $request->get("subtotal");
                            if ($coupon_data->coupon_type == 'percent') {
                                $discount = $price * ($coupon_data->coupon_value / 100);
                            } else {
                                $discount = $coupon_data->coupon_value;
                            }
                        }
                        if ($coupon_data->type == 1) {
                            $product_ids = explode(',', $coupon_data->product_ids);
                            foreach ($product_ids as $product_id) {
                                foreach ($cart_data as $g) {
                                    if ($product_id == $g->type_id) {
                                        $price = $g->price;
                                        if ($coupon_data->coupon_type == 'percent') {
                                            $discount_cp = $price * ($coupon_data->coupon_value / 100);
                                        } else {
                                            $discount_cp = $coupon_data->coupon_value;
                                        }
                                        $discount = $discount + $discount_cp;
                                    }
                                }

                            }

                        }
                        if ($coupon_data->type == 2) {
                            $product_ids = explode(',', $coupon_data->product_ids);
                            foreach ($product_ids as $product_id) {
                                foreach ($cart_data as $g) {
                                    if ($product_id == $g->type_id) {
                                        $price = $g->price;
                                        if ($coupon_data->coupon_type == 'percent') {
                                            $discount_cp = $price * ($coupon_data->coupon_value / 100);
                                        } else {
                                            $discount_cp = $coupon_data->coupon_value;
                                        }
                                        $discount = $discount + $discount_cp;
                                    }
                                }
                            }
                        }
                        if ($coupon_data->type == 3) {
                            $product_ids = explode(',', $coupon_data->product_ids);
                            foreach ($product_ids as $product_id) {
                                foreach ($cart_data as $g) {
                                    if ($product_id == $g->type_id) {
                                        $price = $g->price;
                                        if ($coupon_data->coupon_type == 'percent') {
                                            $discount_cp = $price * ($coupon_data->coupon_value / 100);
                                        } else {
                                            $discount_cp = $coupon_data->coupon_value;
                                        }
                                        $discount = $discount + $discount_cp;
                                    }
                                }
                            }
                        }
                    }
                }
                $store->coupon_id = $coupon_data->id;
                $store->coupon_discount = $discount;
                $final_total = $final_total - $discount;
            }

        }
        // #payment ---------------
        if($store->payment_method == "cod"){
          $sm_price =  $final_total;
        }else{
          $sm_price =  $final_total - $store->final_total ; 
        }
        Payment::where('order_id',$store->id)->delete();
       
        $payment = new Payment();
        $payment->lab_id  = $store->manager_id;
        $payment->sample_boy_id = $store->sample_collection_boy_id;
        $payment->order_id = $store->id;
        $payment->price = $sm_price;
        $payment->paymant_mode = 'cod';
        $payment->status = '1';
        $payment->save();
        OrdersData::where("order_id", $request->order_id)->delete();

        $store->subtotal = $subtotal;
        $store->final_total = $final_total;
        $store->tax = $request->tax;
        $store->save();
        $store1 = $cart_data;
        foreach ($store1 as $s) {
            if ($s->type == 1) {
                $item_data = Package::find($s->type_id);
                $dis_pa = $this->get_discount($item_data->id,'Package',$item_data->mrp);
            } else if ($s->type == 2) {
                $item_data = Parameter::find($s->type_id);
                $dis_pa = $this->get_discount($item_data->id,'Parameter',$item_data->mrp);
            } else {
                $item_data = Profiles::find($s->type_id);

                $item_data->name = $item_data->profile_name;
                $dis_pa = $this->get_discount($item_data->id,'Profiles',$item_data->mrp);

            }
            
            $data = new OrdersData();
            $data->order_id = $request->order_id;
            $data->member_id = $member;
            $data->family_member_id = $s->member_id;
            $data->item_id = $s->type_id;
            $data->type = $s->type;
            $data->item_name = $item_data->name;
            $data->parameter = $s->parameter;
            $data->mrp = $item_data->mrp;
            if($dis_pa['fixed'] > 0.00 ) {
            $per = $dis_pa['per'];
            $price = $item_data->mrp - $dis_pa['fixed'];
            }else{
            $price = $item_data->mrp;
            }
            $data->price = $price;
            // $data->price = $item_data->price;
            $data->save();

        }
        return response()->json(['success' => true]);

    }
    public function sample_boy_list(Request $request){
        $order_data = Orders::find($request->order_id);
        $sampleBoys = User::where('user_type',4)->where('sample_branch',$order_data->manager_id)->get();
        return response()->json([
        'sampleBoys' => $sampleBoys,
        ]);
    }
   
    public function show_OrdersTable()
    {
        $order = Orders::leftJoin('users as manager', 'orders.manager_id', '=', 'manager.id')  
               ->leftJoin('users as sample_boy', 'orders.sample_collection_boy_id', '=', 'sample_boy.id')  
               ->select(
                   'orders.*', 
                   'manager.name as manager_name', 
                   'sample_boy.name as sample_boy_name'
               )
               ->get();

        return  DataTables::of($order)
            ->editColumn('id', function ($order) {
                return $order->id;
            })
            ->editColumn('name', function ($order) {
                // Fetch order data and join with family_member table
                $orderdata = OrdersData::select(
                    'family_member.name as memberName', 'family_member.relation as relation'
                )
                ->where('order_id', $order->id)
                ->leftJoin('family_member', 'orders_data.family_member_id', '=', 'family_member.id')
                ->get();
                
                // Initialize an array to store formatted member details
                $memberDetails = [];
                foreach ($orderdata as $orderdatas) {
                    if ($orderdatas->memberName) {
                        // Format as "Name (relation)" if relation exists
                        $formatted = $orderdatas->memberName;
                        if ($orderdatas->relation) {
                            $formatted .= " ({$orderdatas->relation})";
                        }
                        $memberDetails[] = $formatted;
                    }
                }
            
                // Fetch the user name
                $userName = User::find($order->user_id) ? User::find($order->user_id)->name : 'No User';
            
                // Concatenate user name with member details
                return $userName . '<br>- - - - - - - - - - - - - - - -<br>'.(count($memberDetails) > 0 ? '<small>' . implode('<br> ', $memberDetails) : '</small>');
            })

             ->editColumn('item_name', function ($order) {
                 $orderdata = OrdersData::select('orders_data.item_name')
                ->where('order_id', $order->id)
                ->get();
                 $memberDetails = [];
                foreach ($orderdata as $orderdatas) {
                  
                        // Format as "Name (relation)" if relation exists
                        $formatted = $orderdatas->item_name;
                       
                        $memberDetails[] = $formatted;
                    
                }
                $item = implode(', ', $memberDetails);
                return  $item;
            })
            // ->editColumn('relation', function ($order) {
            //     return '--';
            // })
            ->editColumn('address', function ($order) {
                $data = UserAddress::find($order->sample_collection_address_id);
                return isset($data->address) ? $data->address : '';
            })
            ->editColumn('datetime', function ($order) {
                return $order->date . "<br> " . $order->time;
            })
            // ->editColumn('payment_method', function ($order) {
            //     return $order->payment_method;
            // })
            ->editColumn('paid_amount', function ($order) {
                return number_format($order->final_total, 2, '.', '').'<br>'.$order->payment_method.'<br><small>From:'. $order->from_device.'</small>';
            })
            // ->editColumn('from_device', function ($order) {
            //     return $order->from_device;
            // })
            ->editColumn('more', function ($order) {
                // return $order->id;
                return'<a href="javascript::void(0)" onclick="moreinfo('.$order->id.')" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#normalmodal">More</a>';
            })
            ->editColumn('print', function ($order) {
                return $order->id;
            })
            ->editColumn('status', function ($order) {
                if ($order->status == '1') {
                    // return "Pending";
                    return __('message.Pending');
                }
                if ($order->status == '2') {
                        $accepted_labal = __('message.Accepted');
                        if($order->sample_status == 5 && $order->visit_type == 0){
                            
                              return 'Order Cancel Visit by Sample Boy <br> Remark:-' . $order->remark . ' <br> '.$accepted_labal.'';
                        }
                        if($order->sample_status == 1 && $order->visit_type == 0){
                            
                              return 'Sample Assigned To:<br><u>'.$order->sample_boy_name.'</u>';
                        }
                       return $accepted_labal;
                    }
                if ($order->status == '3') {
                    // return "Rejected";
                    return __('message.Rejected');
                }
                if ($order->status == '4') {
                    // return "Refunded";
                    return __('message.Refunded');
                }
                if ($order->status == '5') {
                    // return "Sample collected";
                    return __('message.Sample collected');
                }
                if ($order->status == '6') {
                    // return "Preparing Report";
                    return __('message.Preparing Report');
                }
                if ($order->status == '8') {
                    // return "Complete";
                    return "Partial Report Send";

                }
                if ($order->status == '7') {
                    // return "Complete";
                    return __('message.Complete');

                }
            })
            ->editColumn('action', function ($order) {
                    $accept_labal = __('message.Accept');
                    $Reject_labal = __('message.Reject');
                    $sample_Collected_labal = __('message.Sample Collected');
                    $refund_labal = __('message.Refund');
                    $complete_labal = __('message.Complete');
                    $viewreport = url('report-view-admin', array('id' => $order->id));
                    $buttons ='';
                    if (Auth::user()->user_type == 2 || Auth::user()->user_type == 1) {
                        if ($order->status == '1') {
                            $accept = url('change_order_status_admin', array('id' => $order->id, 'status' => 2));
                            $reject = url('change_order_status_admin', array('id' => $order->id, 'status' => 3));

                            return '<span>'.$order->manager_name.'</span><br><a href="javascript:void(0)" onclick="assignLab(' . $order->id . ')" class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#lab_order">Change Lab</a><br>
                            <a   href="' . $accept . '" rel="tooltip"  class="btn btn-success mb-1" data-original-title="banner" style="margin-left: 1px;margin-right: 10px;color: white !important;">'. $accept_labal . '</a><br>
                            <a href="javascript::void(0)" onclick="rejectorder(' . $order->id . ')" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#reject_order">' . $Reject_labal . '</a>';

                        }

                        if ($order->status == '2') {
                            $collected = url('change_order_status_admin', ['id' => $order->id, 'status' => 5]);
                            $reject_sample = url('change_order_sample_status_admin', ['id' => $order->id, 'status' => 4]);
                            $Accept_sample = url('change_order_sample_status_admin', ['id' => $order->id, 'status' => 3]);
                            $Edit = url('change_order', ['id' => $order->id]);
                            $reject = url('change_order_status_admin', ['id' => $order->id, 'status' => 3]);
                           
                            if ($order->sample_status == 0 && $order->visit_type == 0) {
                                $buttons .= '<a href="javascript:void(0)" onclick="assignsampleboy(' . $order->id . ')" class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#Sample_order">Assign SampleBoy</a><br>';
                            
                                
                            }
                            if ($order->visit_type == 0) {
                                if ($order->sample_status == 3 && $order->visit_type == 0) {
                                    $buttons .= '<a href="' . $collected . '" rel="tooltip" class="btn btn-success" data-original-title="banner" style="margin-left: 10px;margin-right: 10px;color: white !important;">' . $sample_Collected_labal . '</a>';
                                }
                                if($order->sample_status == 5 && $order->visit_type == 0){
                                    $buttons .= '<a href="javascript:void(0)" onclick="assignsampleboy(' . $order->id . ')" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#Sample_order">ReAssign SampleBoy</a>&nbsp;';
                           
                                }
                            } else {
                                $buttons .= '<a href="' . $collected . '" rel="tooltip" class="btn btn-success" data-original-title="banner" style="margin-left: 10px;margin-right: 10px;color: white !important;">' . $sample_Collected_labal . '</a>';
                            }
                            $buttons .= '<a href="javascript:void(0)" onclick="rejectorder(' . $order->id . ')" class="btn btn-danger mb-2" data-bs-toggle="modal" data-bs-target="#reject_order">' . $Reject_labal . '</a><br>';
                            if ($order->sample_status == 2 && $order->visit_type == 0) {
                                $buttons .= '<a href="' . $Accept_sample . '" rel="tooltip" class="btn btn-success mb-2" data-original-title="banner" style="margin-left: 1px;margin-right: 10px;color: white !important;">Sample Accept</a><br>
                                <a href="' . $reject_sample . '" rel="tooltip" class="btn btn-danger" data-original-title="banner" style="margin-left: 1px;margin-right: 10px;color: white !important;">Sample Reject</a>';
                            }
                            return $buttons;
                        }

                        if ($order->status == '3') {
                            if ($order->payment_method != "cod") {
                                $refund = url('change_order_status', array('id' => $order->id, 'status' => 4));
                                return '<a  href="' . $refund . '" rel="tooltip"  class="btn btn-danger" data-original-title="banner" style="margin-right: 10px;color: white !important;">' . $refund_labal . '</a>';
                            }

                        }
                        if ($order->status == '4') { //refunded 
                        }
                        if ($order->status == '5' || $order->status == '8') { // collected
                        
                         if($order->status != '8'){
                                $reportsend = url('change_order_status', array('id' => $order->id, 'status' => 8));
                                $buttons.=' <a href="javascript:void(0)" onclick="Uploadreport(' . $order->id . ')" data-bs-toggle="modal" data-bs-target="#Report_order" class="btn btn-primary mb-1" > Upload Report</a><br>';
                                $buttons.=' <a href="' . $reportsend . '" rel="tooltip" class="btn btn-primary mb-1" > Partial Report Send</a><br>';
                            }
                            $buttons.=' <a href="javascript::void(0)" onclick="completeorder(' . $order->id . ')" class="btn btn-success mb-1" data-bs-toggle="modal" data-bs-target="#complete_order">' . $complete_labal . '</a><br>';
                           
                            $complete = url('change_order_status', array('id' => $order->id, 'status' => 7));
                            $reject = url('change_order_status', array('id' => $order->id, 'status' => 3));
                            $buttons.= '<a href="javascript::void(0)" onclick="rejectorder(' . $order->id . ')" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#reject_order">' . $Reject_labal . '</a>';
                        
                            return $buttons;
                        }
                        if ($order->status == '7' || $order->status == '6') { // collected
                            return 'Completed';
                        }
                    } 

                })
            ->make(true);
    }

    public function getorderdetails($id)
    {
        $data = Orders::with('useraddressdetails')->where("id", $id)->first();
        if ($data) {
            $data->orderdata = OrdersData::with("memberdetails")->where("order_id", $id)->get();
            $setting = Setting::find(1);
            $getcurrency = explode("-", $setting->currency);
            $userinfo = User::find($data->user_id);
            $data1 = array("data" => $data, "currency" => $getcurrency[1], "setting" => $setting, "userinfo" => $userinfo);
            return json_encode($data1);
        }
        return 0;
    }


    public function show_manager_order()
    {
        $user = User::whereNull('deleted_at')->where('sample_branch', Auth::user()->id)->where("user_type", '4')->get();
        return view("manager.order.default", compact('user'));
    }
    public function manager_home_visit()
    {
        $homevisits = Homevisit::with('citydata', 'lab')->where("lab_id", Auth::id())->paginate(15);

        foreach ($homevisits as $homevisit) {
            $latitude = $homevisit->lat;
            $longitude = $homevisit->lng;
            $apiKey = env('MAP_KEY');

            $response = Http::get("https://maps.googleapis.com/maps/api/geocode/json?latlng={$latitude},{$longitude}&key={$apiKey}");

            if ($response->ok()) {
                $data = $response->json();
                if ($data['status'] === 'OK' && isset($data['results'][0]['formatted_address'])) {
                    $address = $data['results'][0]['formatted_address'];
                    $homevisit->address = $address;
                }
            }
        }
        return view("manager.order.home_visit")->with('homevisits', $homevisits);
    }
    public function homevisits_status($id, $status)
    {
        $homevisit = Homevisit::find($id);
        $homevisit->status = $status;
        $homevisit->save();
        Session::flash('success', 'Status updated successfully.');
        return redirect()->back();
    }
    
    public function get_discount($test_id,$type,$mrp){
        $mrp = (float) $mrp;
        $fixed=0;
        $per=0;
        $dis = Discountid::join('discounts','discounts.id','discount_ids.dis_id')
                ->whereDate('discounts.start_date', '<=', $this->currentDate)
                ->whereDate('discounts.end_date', '>=', $this->currentDate)
                ->where('discount_ids.type',$type)->where("discount_ids.test_id", $test_id)->first();
        if($dis){
            if($dis->dis_type == 'per'){
                $per = (float) $dis->discount;
                $fixed = $mrp * ($per/100);
            }else{
                $fixed = (float) $dis->discount;
                $per =  ($mrp / $fixed) * 100 ;
            }
        }
        $dis_data=['per'=>$per,'fixed'=>$fixed];
        return $dis_data;
    }
    public function show_manager_OrdersTable_edit()
    {
        $user = Auth::user();

        if ($user->user_type == 2) {
            $branchId = $user->id;
        } else {
            $branchId = $user->sample_branch;
        }

        $data = [];
        $data_test = Profiles::where('branch_id', 'REGEXP', '[[:<:]]' . $branchId . '[[:>:]]')->whereNull('deleted_at')->get();

        foreach ($data_test as $row) {
            $dis_pa = $this->get_discount($row->id,'Profile',$row->mrp);
            if ($dis_pa['fixed'] > 0.00 ) {
            $per = $dis_pa['per'];
            $price = $row['mrp'] - $dis_pa['fixed'];
            }else{
             $price = $row['mrp'];
            }
            $b = [
                'id' => $row->id,
                'mrp' => $row->mrp,
                'price' => $price,
                'ty_id' => 3,
                'name' => $row->profile_name . ' - ' . $row->test_short_code,
            ];
            $arr = explode(",", $row->no_of_parameter);
            $b['no_of_parameter'] = count($arr);

            $ls = [];
            foreach ($arr as $a) {
                $parameter = Parameter::find($a);
                $ls[] = $parameter ? $parameter->name : '';
            }
            $b['parameter_data'] = implode(",", $ls);
            $b['type'] = 'Profiles';
            
            $data[] = $b;
        }

        $packages = Package::where('branch_id', 'REGEXP', '[[:<:]]' . $branchId . '[[:>:]]')->whereNull('deleted_at')->get();

        foreach ($packages as $p) {
            $find_pa = TestDetails::where("package_id", $p->id)->get();
            $parameter = 0;
            $dis_pa = $this->get_discount($p->id,'Package',$p->mrp);
            if ($dis_pa['fixed'] > 0.00 ) {
            $per = $dis_pa['per'];
            $price = $p['mrp'] - $dis_pa['fixed'];
            }else{
             $price = $p['mrp'];
            }

            $b = [
                'id' => $p->id,
                'mrp' => $p->mrp,
                'price' => $price,
                'name' => $p->name,
                'type' => 'Package',
                'ty_id' => 1,

            ];
            foreach ($find_pa as $d) {
                if ($d->type == 1) {
                    $ls[] = Parameter::find($d->type_id) ? Parameter::find($d->type_id)->name : '';
                    $parameter = $parameter + 1;
                }
                if ($d->type == 2) {
                    $a = Profiles::find($d->type_id);
                    //  $ls[] = Profiles::find($d->type_id) ? Profiles::find($d->type_id)->profile_name : '';
                    if ($a) {
                        $arr = explode(",", $a->no_of_parameter);
                        foreach ($arr as $l) {
                            $ls[] = Parameter::find($l) ? Parameter::find($l)->name : '';
                        }
                        $parameter = $parameter + count($arr);
                    }
                }
            }
            $b['no_of_parameter'] = $parameter;
            $b['paramater_data'] = implode("#", $ls);
            
            $data[] = $b;

        }
        $Parameter = Parameter::where('branch_id', 'REGEXP', '[[:<:]]' . $branchId . '[[:>:]]')->whereNull('deleted_at')->get();
        foreach ($Parameter as $row) {
            $dis_pa = $this->get_discount($row->id,'Parameter',$row->mrp);
            if ($dis_pa['fixed'] > 0.00 ) {
            $per = $dis_pa['per'];
            $price = $row['mrp'] - $dis_pa['fixed'];
            }else{
             $price = $row['mrp'];
            }
            $b = [
                'id' => $row->id,
                'mrp' => $row->mrp,
                'price' => $price,
                'name' => $row->name . ' - ' . $row->test_short_code,
            ];
            $b['no_of_parameter'] = 1;
            $b['parameter_data'] = "";
            $b['type'] = 'Parameter';
            $b['ty_id'] = 2;
            
            $data[] = $b;
        }

        return DataTables::of($data)
            ->editColumn('id', function ($data) {
                return $data['id'];
            })
            ->editColumn('name', function ($data) {
                return $data['name'];
            })
            ->editColumn('Type', function ($data) {
                return $data['type'];
            })
            ->editColumn('MRP', function ($data) {
                return $data['mrp'];
            })
            ->editColumn('Price', function ($data) {
                return $data['price'];
            })
            ->editColumn('Parameters', function ($data) {
                return $data['no_of_parameter'];
            })
            ->editColumn('action', function ($data) {
                return '<a href="#" onclick="togglebook(this, ' . $data['id'] . ',' . $data['ty_id'] . ',' . $data['no_of_parameter'] . ')" rel="tooltip" class="btn btn-success" data-original-title="banner">ADD TEST</a>';

            })
            ->make(true);

    }

    public function show_manager_OrdersTable()
    {
        if (Auth::user()->user_type == 2) {

            $order = DB::table('orders')
               ->leftJoin('users as sample_boy', 'orders.sample_collection_boy_id', '=', 'sample_boy.id')  
                ->select('orders.no_of_report','orders.remark','orders.sample_status', 'orders.visit_type', 'orders.id', 'orders.user_id', 'orders.sample_collection_address_id', 'orders.date', 'orders.time',
                    'orders.payment_method', 'orders.final_total', 'orders.status',
                   'sample_boy.name as sample_boy_name')
                ->where('orders.manager_id', '=', Auth::id())
                ->get();
            return DataTables::of($order)
                ->editColumn('id', function ($order) {
                    return $order->id;
                })
                ->editColumn('name', function ($order) {
                    return User::find($order->user_id) ? User::find($order->user_id)->name : '';
                })
                ->editColumn('address', function ($order) {
                    $data = UserAddress::find($order->sample_collection_address_id);
                    $useraddress = isset($data->address) ? $data->address : '';
                    return $useraddress;
                })
                ->editColumn('datetime', function ($order) {
                    return $order->date . " " . $order->time;
                })
                ->editColumn('payment_method', function ($order) {
                    return $order->payment_method;
                })
                ->editColumn('paid_amount', function ($order) {
                    return number_format($order->final_total, 2, '.', '');
                })
                ->editColumn('more', function ($order) {
                    return $order->id;
                })
                ->editColumn('print', function ($order) {
                    return $order->id;
                })
                ->editColumn('status', function ($order) {
                    if ($order->status == '1') {
                        return __('message.Pending');
                    }
                    if ($order->status == '2') {
                        $accepted_labal = __('message.Accepted');
                        if($order->sample_status == 5 && $order->visit_type == 0){
                            
                              return 'Order Cancel Visit by Sample Boy <br> Remark:-' . $order->remark . ' <br> '.$accepted_labal.'';
                        }
                        if($order->sample_status == 1 && $order->visit_type == 0){
                            
                              return 'Sample Assigned To:<br><u>'.$order->sample_boy_name.'</u>';
                        }
                       return $accepted_labal;
                    }
                    
                    if ($order->status == '3') {
                        return __('message.Rejected');
                    }
                    if ($order->status == '4') {
                        return __('message.Refunded');
                    }
                    if ($order->status == '5') {
                    // return "Sample collected";
                    return __('message.Sample collected');
                    }
                    if ($order->status == '6') {
                        // return "Preparing Report";
                        return __('message.Preparing Report');
                    }
                    if ($order->status == '7') {
                        return __('message.Complete');
                    }
                    if ($order->status == '8') {
                        // return "Complete";
                        return "Partial Report Send";
    
                    }
                })

                ->editColumn('action', function ($order) {
                    $accept_labal = __('message.Accept');
                    $Reject_labal = __('message.Reject');
                    $sample_Collected_labal = __('message.Sample Collected');
                    $refund_labal = __('message.Refund');
                    $complete_labal = __('message.Complete');
                    $viewreport = url('report-view', array('id' => $order->id));
                    $buttons = '';
                    if (Auth::user()->user_type == 2) {
                        if ($order->status == '1') {
                            $accept = url('change_order_status', array('id' => $order->id, 'status' => 2));
                            $reject = url('change_order_status', array('id' => $order->id, 'status' => 3));
                            return '<a href="' . $accept . '" rel="tooltip"  class="btn btn-success" data-original-title="banner" style="margin-left: 10px;margin-right: 10px;color: white !important;">' . $accept_labal . '</a>
                                    <a href="javascript::void(0)" onclick="rejectorder(' . $order->id . ')" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#reject_order">' . $Reject_labal . '</a>';

                        }

                        if ($order->status == '2') {
                            $collected = url('change_order_status', ['id' => $order->id, 'status' => 5]);
                            $reject_sample = url('change_order_sample_status', ['id' => $order->id, 'status' => 4]);
                            $Accept_sample = url('change_order_sample_status', ['id' => $order->id, 'status' => 3]);
                            $Edit = url('change_order', ['id' => $order->id]);
                            $reject = url('change_order_status', ['id' => $order->id, 'status' => 3]);
                           $buttons='';
                            if ($order->sample_status == 0 && $order->visit_type == 0) {
                                $buttons .= '<a href="javascript:void(0)" onclick="assignsampleboy(' . $order->id . ')" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#Sample_order">Assign SampleBoy</a>';
                            }
                            if ($order->visit_type == 0) {
                                if ($order->sample_status == 3 && $order->visit_type == 0) {
                                    $buttons .= '<a href="' . $collected . '" rel="tooltip" class="btn btn-success" data-original-title="banner" style="margin-left: 10px;margin-right: 10px;color: white !important;">' . $sample_Collected_labal . '</a>';
                                }
                                if($order->sample_status == 5 && $order->visit_type == 0){
                                    $buttons .= '<a href="javascript:void(0)" onclick="assignsampleboy(' . $order->id . ')" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#Sample_order">ReAssign SampleBoy</a>&nbsp;';
                           
                                }
                            } else {
                                $buttons .= '<a href="' . $collected . '" rel="tooltip" class="btn btn-success" data-original-title="banner" style="margin-left: 10px;margin-right: 10px;color: white !important;">' . $sample_Collected_labal . '</a>';
                            }
                            $buttons .= '<a href="javascript:void(0)" onclick="rejectorder(' . $order->id . ')" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#reject_order">' . $Reject_labal . '</a>';
                            if ($order->sample_status == 2 && $order->visit_type == 0) {
                                $buttons .= '<a href="' . $Accept_sample . '" rel="tooltip" class="btn btn-success" data-original-title="banner" style="margin-left: 10px;margin-right: 10px;color: white !important;">Sample Accept</a>
                                <a href="' . $reject_sample . '" rel="tooltip" class="btn btn-danger" data-original-title="banner" style="margin-left: 10px;margin-right: 10px;color: white !important;">Sample Reject</a>';
                            }
                            return $buttons;
                        }

                        if ($order->status == '3') {
                            if ($order->payment_method != "cod") {
                                $refund = url('change_order_status', array('id' => $order->id, 'status' => 4));
                                return '<a  href="' . $refund . '" rel="tooltip"  class="btn btn-danger" data-original-title="banner" style="margin-right: 10px;color: white !important;">' . $refund_labal . '</a>';
                            }

                        }
                        if ($order->status == '4') { //refunded 
                             
                        }
                        if ($order->status == '5' || $order->status == '8') { // collected
                           
                            $complete = url('change_order_status', array('id' => $order->id, 'status' => 7));
                            $reject = url('change_order_status', array('id' => $order->id, 'status' => 3));
                            if($order->status != '8'){
                                $reportsend = url('change_order_status', array('id' => $order->id, 'status' => 8));
                                $buttons.=' <a href="' . $reportsend . '" rel="tooltip" class="btn btn-primary mb-1" > Partial Report Send</a><br>';
                            }
                            $buttons.=' <a href="javascript::void(0)" onclick="completeorder(' . $order->id . ')" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#complete_order">' . $complete_labal . '</a>&nbsp;';
                            
                            $buttons.= '<a href="javascript::void(0)" onclick="rejectorder(' . $order->id . ')" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#reject_order">' . $Reject_labal . '</a>';
                            return $buttons;
                            
                        }
                        if ($order->status == '7' || $order->status == '6') { // collected
                            return 'Completed';
                           }
                    } else {
                        if ($order->status == '1') {
                            $accept = url('change_order_status', array('id' => $order->id, 'status' => 2));
                            $reject = url('change_order_status', array('id' => $order->id, 'status' => 3));

                            return '<a   href="' . $accept . '" rel="tooltip"  class="btn btn-success" data-original-title="banner" style="margin-left: 10px;margin-right: 10px;color: white !important;">' . $accept_labal . '</a><a href="javascript::void(0)" onclick="rejectorder(' . $order->id . ')" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#reject_order">' . $Reject_labal . '</a>';
                        }
                        if ($order->status == '2') {
                            $samplecollected = url('change_order_sample_status', ['id' => $order->id, 'status' => 2]);
                            $sample_order_Collected_labal = "Sample collected";
                            $Edit = url('change_order', ['id' => $order->id]);
                            $reject = url('change_order_status', ['id' => $order->id, 'status' => 3]);
                            $buttons = '<a href="' . $Edit . '" rel="tooltip" class="btn btn-success" data-original-title="banner" style="margin-left: 10px;margin-right: 10px;color: white !important;">Edit Order</a>';

                            if ($order->sample_status != '2') {
                                $buttons .= '<a href="' . $samplecollected . '" rel="tooltip" class="btn btn-success" data-original-title="banner" style="margin-left: 10px;margin-right: 10px;color: white !important;">' . $sample_order_Collected_labal . '</a>';
                            }
                            return $buttons;
                        }

                    }

                })
                ->make(true);
        } else {
            $order = DB::table('orders')
                ->select('orders.visit_type', 'orders.sample_status', 'orders.id', 'orders.user_id', 'orders.sample_collection_address_id', 'orders.date', 'orders.time',
                    'orders.payment_method', 'orders.final_total', 'orders.status')
                ->where('orders.sample_collection_boy_id', '=', Auth::id())
                ->whereNotIn('orders.status', ['1', '3', '4', '5', '7'])
                ->where('orders.sample_status', '!=', 2)
                ->get();
            return DataTables::of($order)
                ->editColumn('id', function ($order) {
                    return $order->id;
                })
                ->editColumn('name', function ($order) {
                    return User::find($order->user_id) ? User::find($order->user_id)->name : '';
                })
                ->editColumn('address', function ($order) {
                    $data = UserAddress::find($order->sample_collection_address_id);
                    $useraddress = isset($data->address) ? $data->address : '';
                    return $useraddress;
                })
                ->editColumn('datetime', function ($order) {
                    return $order->date . " " . $order->time;
                })
                ->editColumn('payment_method', function ($order) {
                    return $order->payment_method;
                })
                ->editColumn('paid_amount', function ($order) {
                    return number_format($order->final_total, 2, '.', '');
                })
                ->editColumn('more', function ($order) {
                    return $order->id;
                })
                ->editColumn('print', function ($order) {
                    return $order->id;
                })
                ->editColumn('status', function ($order) {
                    if ($order->status == '1') {
                        return __('message.Pending');
                    }
                    if ($order->status == '2') {
                        return __('message.Accepted');
                    }
                    if ($order->status == '3') {
                        return __('message.Rejected');
                    }
                    if ($order->status == '4') {
                        return __('message.Refunded');
                    }
                    if ($order->status == '5') {
                        return __('message.Preparing Report');
                    }
                    if ($order->status == '7') {
                        return __('message.Complete');
                    }
                })

                ->editColumn('action', function ($order) {
                    $accept_labal = __('message.Accept');
                    $Reject_labal = __('message.Reject');
                    $sample_Collected_labal = __('message.Sample Collected');
                    $refund_labal = __('message.Refund');
                    $complete_labal = __('message.Complete');
                    $viewreport = url('report-view', array('id' => $order->id));
                    if (Auth::user()->user_type == 2) {
                        if ($order->status == '1') {
                            $accept = url('change_order_status', array('id' => $order->id, 'status' => 2));
                            $reject = url('change_order_status', array('id' => $order->id, 'status' => 3));

                            return ' <a   href="' . $accept . '" rel="tooltip"  class="btn btn-success" data-original-title="banner" style="margin-left: 10px;margin-right: 10px;color: white !important;">' . $accept_labal . '</a><a href="javascript::void(0)" onclick="rejectorder(' . $order->id . ')" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#reject_order">' . $Reject_labal . '</a>';
                            }

                        if ($order->status == '2') {
                            $collected = url('change_order_status', ['id' => $order->id, 'status' => 5]);
                            $reject_sample = url('change_order_sample_status', ['id' => $order->id, 'status' => 4]);
                            $Accept_sample = url('change_order_sample_status', ['id' => $order->id, 'status' => 3]);
                            $Edit = url('change_order', ['id' => $order->id]);
                            $reject = url('change_order_status', ['id' => $order->id, 'status' => 3]);
                            if ($order->sample_status == 0 && $order->visit_type == 0) {
                                $buttons .= '<a href="javascript:void(0)" onclick="assignsampleboy(' . $order->id . ')" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#Sample_order">Assign SampleBoy</a>';
                            }
                            if ($order->visit_type == 0) {
                                if ($order->sample_status == 3 && $order->visit_type == 0) {
                                    $buttons .= '<a href="' . $collected . '" rel="tooltip" class="btn btn-success" data-original-title="banner" style="margin-left: 10px;margin-right: 10px;color: white !important;">' . $sample_Collected_labal . '</a>';
                                }
                            } else {
                                $buttons .= '<a href="' . $collected . '" rel="tooltip" class="btn btn-success" data-original-title="banner" style="margin-left: 10px;margin-right: 10px;color: white !important;">' . $sample_Collected_labal . '</a>';
                            }
                            $buttons .= '<a href="javascript:void(0)" onclick="rejectorder(' . $order->id . ')" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#reject_order">' . $Reject_labal . '</a>';

                            if ($order->sample_status == 2 && $order->visit_type == 0) {
                                $buttons .= '<a href="' . $Accept_sample . '" rel="tooltip" class="btn btn-success" data-original-title="banner" style="margin-left: 10px;margin-right: 10px;color: white !important;">Sample Accept</a>
                                <a href="' . $reject_sample . '" rel="tooltip" class="btn btn-danger" data-original-title="banner" style="margin-left: 10px;margin-right: 10px;color: white !important;">Sample Reject</a>';
                            }
                            return $buttons;
                        }

                        if ($order->status == '3') {
                            if ($order->payment_method != "cod") {
                                $refund = url('change_order_status', array('id' => $order->id, 'status' => 4));
                                return '<a  href="' . $refund . '" rel="tooltip"  class="btn btn-danger" data-original-title="banner" style="margin-right: 10px;color: white !important;">' . $refund_labal . '</a>';
                            }

                        }
                        if ($order->status == '4') { //refunded 
                            return;
                        }
                        if ($order->status == '5') { // collected
                            $complete = url('change_order_status', array('id' => $order->id, 'status' => 7));
                            $reject = url('change_order_status', array('id' => $order->id, 'status' => 3));
                            return '<a href="javascript::void(0)" onclick="completeorder(' . $order->id . ')" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#complete_order">' . $complete_labal . '</a>
                            <a href="javascript::void(0)" onclick="rejectorder(' . $order->id . ')" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#reject_order">' . $Reject_labal . '</a>';
                                }
                        if ($order->status == '7' || $order->status == '6') { // collected
                           return;
                        }
                    } else {
                        if ($order->status == '1') {
                            $accept = url('change_order_status', array('id' => $order->id, 'status' => 2));
                            $reject = url('change_order_status', array('id' => $order->id, 'status' => 3));
                            return '<a   href="' . $accept . '" rel="tooltip"  class="btn btn-success" data-original-title="banner" style="margin-left: 10px;margin-right: 10px;color: white !important;">' . $accept_labal . '</a><a href="javascript::void(0)" onclick="rejectorder(' . $order->id . ')" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#reject_order">' . $Reject_labal . '</a>';
                        }

                        if ($order->status == '2') {
                            $samplecollected = url('change_order_sample_status', ['id' => $order->id, 'status' => 2]);
                            $sample_order_Collected_labal = "Sample collected";
                            $Edit = url('change_order', ['id' => $order->id]);
                            $reject = url('change_order_status', ['id' => $order->id, 'status' => 3]);
                            $buttons = '<a href="' . $Edit . '" rel="tooltip" class="btn btn-success" data-original-title="banner" style="margin-left: 10px;margin-right: 10px;color: white !important;">Edit Order</a>';

                            if ($order->sample_status != '2') {
                                $buttons .= '<a href="' . $samplecollected . '" rel="tooltip" class="btn btn-success" data-original-title="banner" style="margin-left: 10px;margin-right: 10px;color: white !important;">' . $sample_order_Collected_labal . '</a>';
                            }
                            return $buttons;
                        }

                    }

                })
                ->make(true);
        }


    }

    public function TodayManagerOrdersTable()
    {
        $date1 = date("Y-m-d", strtotime($this->getsitedate()));

        if (Auth::user()->user_type == 2) {

            $order = DB::table('orders')
                ->select('orders.no_of_report','orders.remark','orders.sample_status', 'orders.visit_type', 'orders.id', 'orders.user_id', 'orders.sample_collection_address_id', 'orders.date', 'orders.time',
                    'orders.payment_method', 'orders.final_total', 'orders.status')
                ->where("orders.date", $date1)
                ->where('orders.manager_id', '=', Auth::id())
                ->get();
            return DataTables::of($order)
                ->editColumn('id', function ($order) {
                    return $order->id;
                })
                ->editColumn('name', function ($order) {
                    return User::find($order->user_id) ? User::find($order->user_id)->name : '';
                })
                ->editColumn('address', function ($order) {
                    $data = UserAddress::find($order->sample_collection_address_id);
                    $useraddress = isset($data->address) ? $data->address : '';
                    return $useraddress;
                })
                ->editColumn('datetime', function ($order) {
                    return $order->date . " " . $order->time;
                })
                ->editColumn('payment_method', function ($order) {
                    return $order->payment_method;
                })
                ->editColumn('paid_amount', function ($order) {
                    return number_format($order->final_total, 2, '.', '');
                })
                ->editColumn('more', function ($order) {
                    return $order->id;
                })
                ->editColumn('print', function ($order) {
                    return $order->id;
                })
                ->editColumn('status', function ($order) {
                    if ($order->status == '1') {
                        // return "Pending";
                        return __('message.Pending');
                    }
                    if ($order->status == '2') {
                        $accepted_labal = __('message.Accepted');
                        if($order->sample_status == 5 && $order->visit_type == 0){
                            
                              return 'Order Cancel Visit by Sample Boy <br> Remark:-' . $order->remark . ' <br> '.$accepted_labal.'';
                        }
                       return $accepted_labal;
                    }
                    
                    if ($order->status == '3') {
                        // return "Rejected";
                        return __('message.Rejected');
                    }
                    if ($order->status == '4') {
                        // return "Refunded";
                        return __('message.Refunded');
                    }
                    if ($order->status == '5') {
                        // return "Preparing Report";
                        return __('message.Preparing Report');
                    }
                    if ($order->status == '7') {
                        // return "Complete";
                        return __('message.Complete');
                    }
                })

                ->editColumn('action', function ($order) {
                    $accept_labal = __('message.Accept');
                    $Reject_labal = __('message.Reject');
                    $sample_Collected_labal = __('message.Sample Collected');
                    $refund_labal = __('message.Refund');
                    $complete_labal = __('message.Complete');
                    $viewreport = url('report-view', array('id' => $order->id));
                    $buttons = '';
                    if (Auth::user()->user_type == 2) {
                        if ($order->status == '1') {
                            $accept = url('change_order_status', array('id' => $order->id, 'status' => 2));
                            $reject = url('change_order_status', array('id' => $order->id, 'status' => 3));
                            return '<a href="' . $accept . '" rel="tooltip"  class="btn btn-success" data-original-title="banner" style="margin-left: 10px;margin-right: 10px;color: white !important;">' . $accept_labal . '</a>
                                    <a href="javascript::void(0)" onclick="rejectorder(' . $order->id . ')" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#reject_order">' . $Reject_labal . '</a>';

                        }

                        if ($order->status == '2') {
                            $collected = url('change_order_status', ['id' => $order->id, 'status' => 5]);
                            $reject_sample = url('change_order_sample_status', ['id' => $order->id, 'status' => 4]);
                            $Accept_sample = url('change_order_sample_status', ['id' => $order->id, 'status' => 3]);
                            $Edit = url('change_order', ['id' => $order->id]);
                            $reject = url('change_order_status', ['id' => $order->id, 'status' => 3]);
                           $buttons='';
                            if ($order->sample_status == 0 && $order->visit_type == 0) {
                                $buttons .= '<a href="javascript:void(0)" onclick="assignsampleboy(' . $order->id . ')" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#Sample_order">Assign SampleBoy</a>';
                            }
                            if ($order->visit_type == 0) {
                                if ($order->sample_status == 3 && $order->visit_type == 0) {
                                    $buttons .= '<a href="' . $collected . '" rel="tooltip" class="btn btn-success" data-original-title="banner" style="margin-left: 10px;margin-right: 10px;color: white !important;">' . $sample_Collected_labal . '</a>';
                                }
                                if($order->sample_status == 5 && $order->visit_type == 0){
                                    $buttons .= '<a href="javascript:void(0)" onclick="assignsampleboy(' . $order->id . ')" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#Sample_order">ReAssign SampleBoy</a>&nbsp;';
                           
                                }
                            } else {
                                $buttons .= '<a href="' . $collected . '" rel="tooltip" class="btn btn-success" data-original-title="banner" style="margin-left: 10px;margin-right: 10px;color: white !important;">' . $sample_Collected_labal . '</a>';
                            }
                            $buttons .= '<a href="javascript:void(0)" onclick="rejectorder(' . $order->id . ')" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#reject_order">' . $Reject_labal . '</a>';
                            if ($order->sample_status == 2 && $order->visit_type == 0) {
                                $buttons .= '<a href="' . $Accept_sample . '" rel="tooltip" class="btn btn-success" data-original-title="banner" style="margin-left: 10px;margin-right: 10px;color: white !important;">Sample Accept</a>
                                <a href="' . $reject_sample . '" rel="tooltip" class="btn btn-danger" data-original-title="banner" style="margin-left: 10px;margin-right: 10px;color: white !important;">Sample Reject</a>';
                            }
                            return $buttons;
                        }

                        if ($order->status == '3') {
                            if ($order->payment_method != "cod") {
                                $refund = url('change_order_status', array('id' => $order->id, 'status' => 4));
                                return '<a  href="' . $refund . '" rel="tooltip"  class="btn btn-danger" data-original-title="banner" style="margin-right: 10px;color: white !important;">' . $refund_labal . '</a>';
                            }

                        }
                        if ($order->status == '4') { //refunded 
                             
                        }
                        if ($order->status == '5') { // collected
                           
                            $complete = url('change_order_status', array('id' => $order->id, 'status' => 7));
                            $reject = url('change_order_status', array('id' => $order->id, 'status' => 3));
                             //------------ Get report data----------
                            $reportcount = Report::where('order_id',$order->id)->count();
                            // ------------------------------------
                            if($order->no_of_report != null){
                                if($order->no_of_report <= $reportcount){
                                    $buttons.=' <a href="javascript::void(0)" onclick="completeorder(' . $order->id . ')" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#complete_order">' . $complete_labal . '</a>&nbsp;';
                            
                                }    
                            }
                            $buttons.= '<a href="javascript::void(0)" onclick="rejectorder(' . $order->id . ')" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#reject_order">' . $Reject_labal . '</a>';
                            return $buttons;
                            
                        }
                        if ($order->status == '7' || $order->status == '6') { // collected
                            return 'Completed';
                        }
                    } else {
                        if ($order->status == '1') {
                            $accept = url('change_order_status', array('id' => $order->id, 'status' => 2));
                            $reject = url('change_order_status', array('id' => $order->id, 'status' => 3));

                            return '<a   href="' . $accept . '" rel="tooltip"  class="btn btn-success" data-original-title="banner" style="margin-left: 10px;margin-right: 10px;color: white !important;">' . $accept_labal . '</a><a href="javascript::void(0)" onclick="rejectorder(' . $order->id . ')" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#reject_order">' . $Reject_labal . '</a>';
                        }

                        if ($order->status == '2') {
                            $samplecollected = url('change_order_sample_status', ['id' => $order->id, 'status' => 2]);
                            $sample_order_Collected_labal = "Sample collected";
                            $Edit = url('change_order', ['id' => $order->id]);
                            $reject = url('change_order_status', ['id' => $order->id, 'status' => 3]);
                            $buttons = '<a href="' . $Edit . '" rel="tooltip" class="btn btn-success" data-original-title="banner" style="margin-left: 10px;margin-right: 10px;color: white !important;">Edit Order</a>';

                            if ($order->sample_status != '2') {
                                
                                $buttons .= '<a href="' . $samplecollected . '" rel="tooltip" class="btn btn-success" data-original-title="banner" style="margin-left: 10px;margin-right: 10px;color: white !important;">' . $sample_order_Collected_labal . '</a>';
                            }
                            return $buttons;
                        }

                    }

                })
                ->make(true);
        } else {
            $order = DB::table('orders')
                ->select('orders.visit_type', 'orders.sample_status', 'orders.id', 'orders.user_id', 'orders.sample_collection_address_id', 'orders.date', 'orders.time',
                    'orders.payment_method', 'orders.final_total', 'orders.status')
                ->where('orders.sample_collection_boy_id', '=', Auth::id())
                ->whereNotIn('orders.status', ['1', '3', '4', '5', '7'])
                ->where("orders.date", $date1)
                ->where('orders.sample_status', '!=', 2)
                ->get();
            return DataTables::of($order)
                ->editColumn('id', function ($order) {
                    return $order->id;
                })
                ->editColumn('name', function ($order) {
                    return User::find($order->user_id) ? User::find($order->user_id)->name : '';
                })
                ->editColumn('address', function ($order) {
                    $data = UserAddress::find($order->sample_collection_address_id);
                    $useraddress = isset($data->address) ? $data->address : '';
                    return $useraddress;
                })
                ->editColumn('datetime', function ($order) {
                    return $order->date . " " . $order->time;
                })
                ->editColumn('payment_method', function ($order) {
                    return $order->payment_method;
                })
                ->editColumn('paid_amount', function ($order) {
                    return number_format($order->final_total, 2, '.', '');
                })
                ->editColumn('more', function ($order) {
                    return $order->id;
                })
                ->editColumn('print', function ($order) {
                    return $order->id;
                })
                ->editColumn('status', function ($order) {
                    if ($order->status == '1') {
                        // return "Pending";
                        return __('message.Pending');
                    }
                    if ($order->status == '2') {
                        // return "Accepted";
                        return __('message.Accepted');
                    }
                    if ($order->status == '3') {
                        // return "Rejected";
                        return __('message.Rejected');
                    }
                    if ($order->status == '4') {
                        // return "Refunded";
                        return __('message.Refunded');
                    }
                    if ($order->status == '5') {
                        // return "Preparing Report";
                        return __('message.Preparing Report');
                    }
                    if ($order->status == '7') {
                        // return "Complete";
                        return __('message.Complete');
                    }
                })

                ->editColumn('action', function ($order) {
                    $accept_labal = __('message.Accept');
                    $Reject_labal = __('message.Reject');
                    $sample_Collected_labal = __('message.Sample Collected');
                    $refund_labal = __('message.Refund');
                    $complete_labal = __('message.Complete');
                    $viewreport = url('report-view', array('id' => $order->id));
                    if (Auth::user()->user_type == 2) {
                        if ($order->status == '1') {
                            $accept = url('change_order_status', array('id' => $order->id, 'status' => 2));
                            $reject = url('change_order_status', array('id' => $order->id, 'status' => 3));

                            return '<a   href="' . $accept . '" rel="tooltip"  class="btn btn-success" data-original-title="banner" style="margin-left: 10px;margin-right: 10px;color: white !important;">' . $accept_labal . '</a><a href="javascript::void(0)" onclick="rejectorder(' . $order->id . ')" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#reject_order">' . $Reject_labal . '</a>';

                        }

                        if ($order->status == '2') {
                            $collected = url('change_order_status', ['id' => $order->id, 'status' => 5]);
                            $reject_sample = url('change_order_sample_status', ['id' => $order->id, 'status' => 4]);
                            $Accept_sample = url('change_order_sample_status', ['id' => $order->id, 'status' => 3]);
                            $Edit = url('change_order', ['id' => $order->id]);
                            $reject = url('change_order_status', ['id' => $order->id, 'status' => 3]);
                            
                            if ($order->sample_status == 0 && $order->visit_type == 0) {
                                $buttons .= '<a href="javascript:void(0)" onclick="assignsampleboy(' . $order->id . ')" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#Sample_order">Assign SampleBoy</a>';
                            }
                            if ($order->visit_type == 0) {
                                if ($order->sample_status == 3 && $order->visit_type == 0) {
                                    $buttons .= '<a href="' . $collected . '" rel="tooltip" class="btn btn-success" data-original-title="banner" style="margin-left: 10px;margin-right: 10px;color: white !important;">' . $sample_Collected_labal . '</a>';
                                }
                            } else {
                                $buttons .= '<a href="' . $collected . '" rel="tooltip" class="btn btn-success" data-original-title="banner" style="margin-left: 10px;margin-right: 10px;color: white !important;">' . $sample_Collected_labal . '</a>';
                            }

                            $buttons .= '<a href="javascript:void(0)" onclick="rejectorder(' . $order->id . ')" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#reject_order">' . $Reject_labal . '</a>';
                            if ($order->sample_status == 2 && $order->visit_type == 0) {
                                $buttons .= '<a href="' . $Accept_sample . '" rel="tooltip" class="btn btn-success" data-original-title="banner" style="margin-left: 10px;margin-right: 10px;color: white !important;">Sample Accept</a>
                                <a href="' . $reject_sample . '" rel="tooltip" class="btn btn-danger" data-original-title="banner" style="margin-left: 10px;margin-right: 10px;color: white !important;">Sample Reject</a>';
                            }
                            return $buttons;
                        }

                        if ($order->status == '3') {
                            if ($order->payment_method != "cod") {
                                $refund = url('change_order_status', array('id' => $order->id, 'status' => 4));
                                return '<a  href="' . $refund . '" rel="tooltip"  class="btn btn-danger" data-original-title="banner" style="margin-right: 10px;color: white !important;">' . $refund_labal . '</a>';
                            }

                        }
                        if ($order->status == '4') { //refunded 
                            return;
                        }
                        if ($order->status == '5') { // collected
                            $complete = url('change_order_status', array('id' => $order->id, 'status' => 7));
                            $reject = url('change_order_status', array('id' => $order->id, 'status' => 3));
                            return '<a href="javascript::void(0)" onclick="completeorder(' . $order->id . ')" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#complete_order">' . $complete_labal . '</a>
                            <a href="javascript::void(0)" onclick="rejectorder(' . $order->id . ')" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#reject_order">' . $Reject_labal . '</a>';
                        }
                        if ($order->status == '7' || $order->status == '6') { // collected
    
                            return 'Completed';
                        }
                    } else {
                        if ($order->status == '1') {
                            $accept = url('change_order_status', array('id' => $order->id, 'status' => 2));
                            $reject = url('change_order_status', array('id' => $order->id, 'status' => 3));
                            return '<a   href="' . $accept . '" rel="tooltip"  class="btn btn-success" data-original-title="banner" style="margin-left: 10px;margin-right: 10px;color: white !important;">' . $accept_labal . '</a>
                            <a href="javascript::void(0)" onclick="rejectorder(' . $order->id . ')" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#reject_order">' . $Reject_labal . '</a>';
                        }

                        if ($order->status == '2') {
                            $samplecollected = url('change_order_sample_status', ['id' => $order->id, 'status' => 2]);
                            $sample_order_Collected_labal = "Sample collected";
                            $Edit = url('change_order', ['id' => $order->id]);
                            $reject = url('change_order_status', ['id' => $order->id, 'status' => 3]);
                            $buttons = '<a href="' . $Edit . '" rel="tooltip" class="btn btn-success" data-original-title="banner" style="margin-left: 10px;margin-right: 10px;color: white !important;">Edit Order</a>';
                            if ($order->sample_status != '2') {
                                
                                $buttons .= '<a href="' . $samplecollected . '" rel="tooltip" class="btn btn-success" data-original-title="banner" style="margin-left: 10px;margin-right: 10px;color: white !important;">' . $sample_order_Collected_labal . '</a>';
                            }
                            return $buttons;
                        }
                    }
                })
                ->make(true);
        }


    }
    public function show_update_user_family(Request $request)
    {
        $store = new FamilyMember();
        $msg = __('message.Member Add Successfully');
        $store->name = $request->get("name");
        $store->mobile_no = $request->get("phone");
        $store->age = $request->get("age");
        $store->email = $request->get("email");
        $store->dob = $request->get("dob");
        $store->relation = $request->get("relation");
        $store->gender = $request->get("gender");
        $store->user_id = $request->get("user_id");
        $store->save();
        Session::flash('message', $msg);
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();

    }
    public function update_user_address_ajax(Request $request){
        if ($request->get("id") != "") {
            $store = UserAddress::find($request->get("id"));
            $msg = __('message.User Address Update Successfully');
        } else {
            $store = new UserAddress();
            $msg = __('message.User Address Add Successfully');
        }
        $store->user_id = Auth::id();
        $store->name = $request->get("name");
        $store->house_no = $request->get("house_no");
        $store->landmark = $request->get("landmark");
        $store->apartment = $request->get("apartment");
        $store->pincode = $request->get("pincode");
        $store->city = $request->get("city");
        $store->state = $request->get("state");
        if ($request->get("is_default") == "" || $request->get("is_default") == null) {
            $store->is_default = 0;
        } else {
            $store->is_default = $request->get("is_default");
        }

        $store->address = $request->get("address");
        $store->lat = $request->get("lat");
        $store->long = $request->get("long");
        $store->save();
        if($store){
            return response()->json([
        'success' => true,
        'address' => [
                'id' => $store->id,
                'name' => $store->name,
                'house_no' => $store->house_no,
                'address' => $store->address,
                'city' => $store->city,
                'state' => $store->state,
                'pincode' => $store->pincode,
            ],
            'message' => $msg
        ]);
        }else{
           return response()->json([
        'success' => false,
        'message' => 'somthing went wrong']);
        }
    }
    public function show_update_user_family_ajax(Request $request)
    {
        $store = new FamilyMember();
        $msg = __('message.Member Add Successfully');
        $store->name = $request->get("name");
        $store->mobile_no = $request->get("phone");
        $store->age = $request->get("age");
        $store->email = $request->get("email");
        $store->dob = $request->get("dob");
        $store->relation = $request->get("relation");
        $store->gender = $request->get("gender");
        $store->user_id = Auth::user()->id;
        $store->save();
        if($store){
            return response()->json([
        'success' => true,
        'member' => [
            'id' => $store->id,
            'name' => $store->name,
            'relation' => $store->relation,
            'gender' => $store->gender,
            'age' => $store->age
            ],
            'message' => $msg
        ]);
        }else{
           return response()->json([
        'success' => false,
        'message' => 'somthing went wrong']);
        }
        

    }


    public function show_change_order($id, Request $request)
    {
        $order = Orders::find($id);
        $faimly = FamilyMember::where('user_id', $order->user_id)->get();
        $data = $this->getordercontent($id);

        return view("manager.order.edit")->with('data', $data)->with('user_id', $order->user_id)->with('order_id', $id)->with('faimly', $faimly);
    }
    public function change_order_sample_status($id, $status, Request $request)
    {
        $data = Orders::find($id);
        $setting = Setting::find(1);
        $data->sample_status = $status;
        $data->save();
        $userdata = User::find($data->user_id);
        $to = $userdata->phone;
        $getorderdatat = OrdersData::where('order_id',$data->id)->first();
        $test = 'Test';
        if($getorderdatat){
        $test = $getorderdatat->item_name;
        }
        $msg = "";
        $notificationmsg = "";
        if ($status == '2') {
            $msg = __('message.The sample has been collected successfully');
        }
        if ($status == '3') {
            $data->status = 5;
            $data->collected_datetime = $this->getsitedate();
            $data->save();
            //------------ SMS data----
                $templateName='Sample_Accepted';
                $datatm=[
                'test'=>$test,'name'=>$userdata->name,
                ];
                $this->sendSms($to ,$datatm, $templateName);
            // ------------------------
            $msg = "Order Sample has been Accepted";
            $notificationmsg = "Your Collected Sample for order $data->id has been Accepted.";
            $notification = new Notification();
            $notification->user_id = $data->sample_collection_boy_id;
            $notification->message = $notificationmsg;
            $notification->order_id = $data->id;
            $notification->app = "Sample_boy";
            $notification->save();

            if ($data) {
                $android = $this->send_notification_order_android($setting->sample_android_server_key, $data->sample_collection_boy_id, $notificationmsg, $data->id);
                $ios = $this->send_notification_order_ios($setting->sample_ios_server_key, $data->sample_collection_boy_id, $notificationmsg, $data->id);
            }
        }
        if ($status == '4') {
            $msg = "Order Sample has been Rejected";
            //------------ SMS data----
                $templateName='Sample_Rejected';
                
                $datatm=[
                'test'=>$test,'name'=>$userdata->name,
                ];
                $this->sendSms($to ,$datatm, $templateName);
            // ------------------------
            $notificationmsg = "Your Collected Sample for order $data->id has been Rejected!";
            $notification = new Notification();
            $notification->user_id = $data->sample_collection_boy_id;
            $notification->message = $notificationmsg;
            $notification->order_id = $data->id;
            $notification->app = "Sample_boy";
            $notification->save();
            if ($data) {
                $android = $this->send_notification_order_android($setting->sample_android_server_key, $data->sample_collection_boy_id, $notificationmsg, $data->id);
                $ios = $this->send_notification_order_ios($setting->sample_ios_server_key, $data->sample_collection_boy_id, $notificationmsg, $data->id);
            }
        }
        Session::flash('message', $msg);
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }
    public function show_change_order_status($id, $status, Request $request)
    {
        $data = Orders::find($id);
        $userdata = User::find($data->user_id);
        $to = $userdata->phone;
        $getorderdatat = OrdersData::where('order_id',$data->id)->first();
        $test = 'Test';
        if($getorderdatat){
        $test = $getorderdatat->item_name;
        }
        $setting = Setting::find(1);
        $msg = "";
        if ($status == '8') {
            $msg = "partial report send";
            $data->status = $status;
            $data->save();

        }
        if ($status == '2') {
            $msg = __('message.Order Has Been Accepted');
            $data->status = $status;
            $data->accept_datetime = $this->getsitedate();
            $data->save();
            
            if ($data) {
                //------------ SMS data----
                    $templateName='Test_Booking_Confirmation';
                    $datatm=[
                    'orderId'=>$data->id,'name'=>$userdata->name,'test'=>$test,
                    
                    ];
                    $this->sendSms($to ,$datatm, $templateName);
                // ------------------------
                $android = $this->send_notification_order_android($setting->android_server_key, $data->user_id, $msg, $data->id);
                $ios = $this->send_notification_order_ios($setting->ios_server_key, $data->user_id, $msg, $data->id);
            }

        }
        if ($status == '3') {
            $msg = __('message.Order Has Been Rejected');
            $data->status = $status;
            $data->reject_description = $request->get("reject_description");
            $data->reject_datetime = $this->getsitedate();
            $data->save();
            if ($data) {
                $android = $this->send_notification_order_android($setting->android_server_key, $data->user_id, $msg, $data->id);
                $ios = $this->send_notification_order_ios($setting->ios_server_key, $data->user_id, $msg, $data->id);
            }
        }
        if ($status == '4') {
            $msg = __('message.Order Has Been Refunded');
            $result = $this->refunded_order_amount($data->payment_method, $data->token, $data->final_total);
            if ($result == 1) {
                $data->status = $status;
                $data->refund_datetime = $this->getsitedate();
                $data->save();
                if ($data) {
                    $android = $this->send_notification_order_android($setting->android_server_key, $data->user_id, $msg, $data->id);
                    $ios = $this->send_notification_order_ios($setting->ios_server_key, $data->user_id, $msg, $data->id);
                }
            } else {
                Session::flash('message', __('message.Something Getting Worng'));
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            }

        }
        if ($status == '5') {
            $msg = __('message.The sample has been collected successfully');
            $data->status = $status;
            $data->collected_datetime = $this->getsitedate();
            $data->save();
            if ($data) {
                $android = $this->send_notification_order_android($setting->android_server_key, $data->user_id, $msg, $data->id);
                $ios = $this->send_notification_order_ios($setting->ios_server_key, $data->user_id, $msg, $data->id);
            }
        }
        if ($status == '7') {
            if ($files = $request->file('report')) {
                $file = $request->file('report');
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension() ?: 'png';
                $picture = str_random(10) . time() . '.' . $extension;
                $destinationPath = Storage_path("app/public/report");
                $request->file('report')->move($destinationPath, $picture);
                $report = $picture;
            } else {
                $report = "";
            }
            $msg = __('message.Order Is Complete');
            $data->status = $status;
            $data->complete_datetime = $this->getsitedate();
            $data->report = $report;
            $data->save();
            // dd('this');
            //------------ SMS data----
                $templateName='Report_Download';
                // Dear {name}, your test report for {test} is ready. Download it now from App. Regards! Reliable Diagnostics.
                $datatm=[
                'name'=>$userdata->name,'test'=>$test,
                ];
                $this->sendSms($to ,$datatm, $templateName);
            // ------------------------
            if ($data) {
                $android = $this->send_notification_order_android($setting->android_server_key, $data->user_id, $msg, $data->id);
                $ios = $this->send_notification_order_ios($setting->ios_server_key, $data->user_id, $msg, $data->id);
            }
        }
        $data1 = array();
        $data1['email'] = User::find($data->user_id) ? User::find($data->user_id)->email : '';
        $data1['msg'] = $msg;
        $data1['order_id'] = $id;
        $data1['customer_name'] = User::find($data->user_id) ? User::find($data->user_id)->name : '';
        try {
            $result = Mail::send('email.order_status', ['user' => $data1], function ($message) use ($data1) {
                $message->to($data1['email'], $data1['customer_name'])->subject(__('message.site_name'));
            });
        } catch (\Exception $e) {
        }
        Session::flash('message', $msg);
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }

    public function send_notification_order_android($key, $user_id, $msg, $id)
    {
        $getuser = Token::where("type", 1)->where('user_id', $user_id)->get();
        if (count($getuser) != 0) {
            $reg_id = array();
            foreach ($getuser as $gt) {
                $reg_id[] = $gt->token;
            }
            $registrationIds = $reg_id;
            $message = array(
                'message' => $msg,
                'key' => 'Booking',
                'title' => 'Booking Successfull',
                'order_id' => $id
            );

            $fields = array(
                'registration_ids' => $registrationIds,
                'data' => $message
            );

            $url = 'https://fcm.googleapis.com/fcm/send';
            $headers = array(
                'Authorization: key=' . $key, // . $api_key,
                'Content-Type: application/json'
            );

            $json = json_encode($fields);
            try {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                $result = curl_exec($ch);

                if ($result === FALSE) {
                    die('Curl failed: ' . curl_error($ch));
                }
                curl_close($ch);
                $response = json_decode($result, true);

            } catch (\Exception $e) {
                return 0;
            }

            if (isset($response) && $response['success'] > 0) {
                return 1;
            } else {
                return 0;
            }
        }
        return 0;
    }

    public function send_notification_order_ios($key, $user_id, $msg, $id)
    {
        $getuser = Token::where("type", 2)->where('user_id', $user_id)->get();
        if (count($getuser) != 0) {
            $reg_id = array();
            foreach ($getuser as $gt) {
                $reg_id[] = $gt->token;
            }
            $registrationIds = $reg_id;
            $message = array(
                'message' => $msg,
                'key' => 'Booking',
                'title' => 'Booking Successfull',
                'order_id' => $id
            );
            $fields = array(
                'registration_ids' => $registrationIds,
                'data' => $message
            );

            $url = 'https://fcm.googleapis.com/fcm/send';
            $headers = array(
                'Authorization: key=' . $key, // . $api_key,
                'Content-Type: application/json'
            );
            $json = json_encode($fields);
            try {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                $result = curl_exec($ch);

                if ($result === FALSE) {
                    die('Curl failed: ' . curl_error($ch));
                }
                curl_close($ch);
                $response = json_decode($result, true);
            } catch (\Exception $e) {
                return 0;
            }

            if (isset($response) && $response['success'] > 0) {
                return 1;
            } else {
                return 0;
            }
        }
        return 0;
    }
    public function show_report_order_lab(Request $request)
    {
        $setting = Setting::first();
        $data = Orders::find($request->get("id"));
        $data->manager_id = $request->get("lab_id");
        $data->save();
        $userdata = User::find($data->user_id);
       
        $userdataboy = User::find($request->get("lab_id"));
        $to = $userdataboy->phone;
        $msg = "You have a new order. Order ID $data->id";
        if ($data) {
            //------------ SMS data----
                        
            $getorderdatat = OrdersData::where('order_id',$data->id)->first();
                $test = 'Test';
            if($getorderdatat){
                $test = $getorderdatat->item_name;
            }
                $templateName='Order_Received';
                // New order received. Order ID: {orderId}, Test: {test}, Customer: {name}. Please check the portal for further details. Reliable Diagnostics
                $datatm=[
                'orderId'=>$data->id,'name'=>$userdata->name,'test'=>$test,
                ];
            
                $this->sendSms($to ,$datatm, $templateName);
            // ------------------------
                    
       }

        $msg = 'Assigned To Lab successfully.';
        $data1 = array();

        Session::flash('message', $msg);
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }
    public function show_report_order_sample(Request $request)
    {
        $setting = Setting::first();
        $data = Orders::find($request->get("id"));
        $data->sample_collection_boy_id = $request->get("sm_boy_id");
        $data->sample_status = 1;
        $data->save();
        $userdata = User::find($data->user_id);
        $to = $userdata->phone;
        $userdataboy = User::find($request->get("sm_boy_id"));
        $msg = "You have a new order. Order ID $data->id";
        if ($data) {
            //------------ SMS data----
                $templateName='Sample_Boy_Assigned';
                $datatm=[
                'orderId'=>$data->id,'name'=>$userdata->name,'phone'=>$userdataboy->phone,'boy'=>$userdataboy->name,'time'=> $data->date.' '.$data->time
                ];
                $this->sendSms($to ,$datatm, $templateName);
                //  --------------- For Boy--------------
                $templateName='Order_Assigned';
                $address = UserAddress::withTrashed()->find($data->sample_collection_address_id);

                $add = '';
                if($address){
                    $add = substr($address->apartment, 0, 15);
                }
                
                $datatm=[
                'orderId'=>$data->id,'name'=>$userdata->name,'address'=>$add
                ];
                $to_boy = $userdataboy->phone;
                $this->sendSms($to_boy ,$datatm, $templateName);
                
                    
            // ------------------------
            $notification = new Notification();
            $notification->user_id = $request->get("sm_boy_id");
            $notification->message = $msg;
            $notification->order_id = $data->id;
            $notification->app = "Sample_boy";
            $notification->save();
            $android = $this->send_notification_order_android($setting->sample_android_server_key, $request->get("sm_boy_id"), $msg, $data->id);
            $ios = $this->send_notification_order_ios($setting->sample_ios_server_key, $request->get("sm_boy_id"), $msg, $data->id);
        }

        $msg = 'SampleBoy assigned successfully.';
        $data1 = array();

        Session::flash('message', $msg);
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }
    public function show_reschedule_order_sample(Request $request)
    {

        $setting = Setting::first();
        $data = Orders::find($request->get("id"));
        $data->date = $request->date;
        $data->time = $request->time;
        $data->remark = $request->remark;
        $data->save();
        $msg = 'Order Rescheduled.';
        if ($data) {
            $notification = new Notification();
            $notification->user_id = $request->get("sm_boy_id");
            $notification->message = $msg;
            $notification->order_id = $data->id;
            $notification->app = "Sample_boy";
            $notification->save();
            $android = $this->send_notification_order_android($setting->sample_android_server_key, $data->user_id, $msg, $data->id);
            $ios = $this->send_notification_order_ios($setting->sample_ios_server_key, $data->user_id, $msg, $data->id);
        }
        Session::flash('message', $msg);
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }
    public function get_report_details(Request $request){
        $order_data = Orders::find($request->order_id);
        $Report = Report::where('order_id',$request->order_id)->get();
        return response()->json([
        'no_of_report'=>$order_data->no_of_report,
        'Report' => $Report,
        ]);
    }
    public function save_report(Request $request)
    {
        // Save the report logic
        // For example:
        if($request->get('report_id') == 'undefined'){
            $report = new Report();
        }else{
            $report = Report::find($request->get('report_id'));
        }
        
        $report->order_id = $request->get('order_id');
        $report->report_name = $request->get('report_name');
        $report->test_reg_id = $request->get('test_reg_id');
        $report->save();
    
        return response()->json(['success' => true, 'message' => 'Report saved successfully!..','report_id'=>$report->id]);
    }

    public function show_report_order(Request $request)
    {
        $data = Orders::find($request->get("id"));
        $data->no_of_report=$request->get("no_of_report");
        $data->save();
        $Report = Report::where('order_id',$data->id)->get();
       
        return response()->json([
        'orderid'=> $request->get("id"),
        'no_of_report'=>$data->no_of_report,
        'Report' => $Report,
        ]);
        
    }
    public function show_complete_order(Request $request)
    {
        $data = Orders::find($request->get("id"));
        if ($files = $request->file('report')) {
            $file = $request->file('report');
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension() ?: 'png';
            $picture = rand() . time() . '.' . $extension;
            $destinationPath = Storage_path("app/public/report");
            $request->file('report')->move($destinationPath, $picture);
            $report = $picture;
        } else {
            $report = "";
        }
        $msg = __('message.Order Is Complete');
        $data->status = '7';
        $data->complete_datetime = $this->getsitedate();
        $data->report = $report;
        $data->save();
        $userdata = User::find($data->user_id);
        $to = $userdata->phone;
        $getorderdatat = OrdersData::where('order_id',$data->id)->first();
        $test = 'Test';
        if($getorderdatat){
        $test = $getorderdatat->item_name;
        }
        //------------ SMS data----
                $templateName='Report_Download';
                // Dear {name}, your test report for {test} is ready. Download it now from App. Regards! Reliable Diagnostics.
                $datatm=[
                'name'=>$userdata->name,'test'=>$test,
                ];
                $this->sendSms($to ,$datatm, $templateName);
            // ------------------------
        $data1 = array();
        $data1['email'] = User::find($data->user_id) ? User::find($data->user_id)->email : '';
        $data1['msg'] = $msg;
        $data1['order_id'] = $request->get("id");
        $data1['customer_name'] = User::find($data->user_id) ? User::find($data->user_id)->name : '';
        $data1['report'] = $report;
        try {
            $result = Mail::send('email.order_status', ['user' => $data1], function ($message) use ($data1) {
                $message->to($data1['email'], $data1['customer_name'])->subject(__('message.site_name'));
                $message->attach(Storage_path("app/public/report") . '/' . $data1['report']);
            });
        } catch (\Exception $e) {
        }
        Session::flash('message', $msg);
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }
    public function refunded_order_amount($method, $token, $amount)
    {
        $getallkeys = PaymentGateway::all();
        $ls = array();
        foreach ($getallkeys as $g) {
            $ls[$g->payment_gateway_name . "_" . $g->key_name] = $g->meta_value;
        }
        if ($method == "braintree") {
            $gateway = new \Braintree\Gateway([
                'environment' => $ls['Braintree_environment'],
                'merchantId' => $ls['Braintree_merchantId'],
                'publicKey' => $ls['Braintree_publicKey'],
                'privateKey' => $ls['Braintree_privateKey']
            ]);
            $result = $gateway->transaction()->refund($token);
            if ($result->success == true) {
                return 1;
            } else {
                return 0;
            }
        } else if ($method == "stripe") {
            \Stripe\Stripe::setApiKey($ls['Stripe_secert_key']);
            $refund = \Stripe\Refund::create([
                'charge' => $token,
                'amount' => (int) ($amount * 100),  // For 10 $
            ]);
            echo "<pre>";
            print_r($refund);
            exit;

        } else {
            return 1;
        }
    }

}
