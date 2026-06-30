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
use App\Models\Transport;
use App\Models\Profiles;
use App\Models\Package;
use App\Models\Parameter;
use App\Models\TestDetails;
use App\Models\Coupon;
use App\Models\CartMember;
use App\Models\FamilyMember;
use App\Models\Notification;
use Session;
use Auth;
use Hash;
use Mail;
use Illuminate\Support\Facades\Http;
use DB;

class ParcelControllers extends Controller
{
    public function show_upcomming_order()
    {
        return view("transport.orders.default");
    }
        public function show_upcomming_order_rec()
    {
        return view("receiver.orders.default");
    }
        public function show_order_rec()
    {
        return view("receiver.orders.defaultall");
    }
    public function show_order()
    {
        return view("transport.orders.defaultall");
    }
    public function show_Orders_upcommingTable()
    {
        $order = Transport::where('status', 0)
            ->where('date', '>=', now()->toDateString()) // Only get records with a date greater than or equal to today
            ->orderBy('date')
            ->orderBy('time')
            ->get();
        return DataTables::of($order)
            ->editColumn('id', function ($order) {
                return $order->id;
            })
            ->editColumn('from', function ($order) {
                return User::find($order->send_by_lab) ? User::find($order->send_by_lab)->name : '';
            })
            ->editColumn('to', function ($order) {
                return User::find($order->lab_id) ? User::find($order->lab_id)->name : '';
            })

            ->editColumn('date', function ($order) {
                return $order->date;
            })
            ->editColumn('time', function ($order) {
                return $order->time;
            })
            ->editColumn('qty', function ($order) {
                return $order->qty;
            })
            ->editColumn('more', function ($order) {
                return $order->id;
            })
            ->editColumn('courier_type', function ($order) {
                return $order->courier_type;
            })
            ->editColumn('status', function ($order) {
                if ($order->status == '0') {

                    return "Transit ";
                }
                if ($order->status == '1') {
                    return "Received at Point";
                }
                if ($order->status == '2') {
                    return "Received at Lab";
                }

            })
            ->make(true);
    }

    public function show_OrdersTable()
    {
        $order = Transport::all();
        return DataTables::of($order)
            ->editColumn('id', function ($order) {
                return $order->id;
            })
            ->editColumn('from', function ($order) {
                return User::find($order->send_by_lab) ? User::find($order->send_by_lab)->name : '';
            })
            ->editColumn('to', function ($order) {
                return User::find($order->lab_id) ? User::find($order->lab_id)->name : '';
            })

            ->editColumn('date', function ($order) {
                return $order->date;
            })
            ->editColumn('time', function ($order) {
                return $order->time;
            })
            ->editColumn('qty', function ($order) {
                return $order->qty;
            })
            ->editColumn('more', function ($order) {
                return $order->id;
            })
            ->editColumn('courier_type', function ($order) {
                return $order->courier_type;
            })
            ->editColumn('status', function ($order) {
                if ($order->status == '0') {
                    return "Transit ";
                }
                if ($order->status == '1') {
                    return "Received at Point";
                }
                if ($order->status == '2') {
                    return "Received at Lab";
                }
            })
            ->make(true);
    }
      public function show_Orders_upcommingTable_rec()
    {
        $order = Transport::where('status', 0)
            ->where('date', '>=', now()->toDateString()) // Only get records with a date greater than or equal to today
            ->orderBy('date')
            ->orderBy('time')
            ->get();
        return DataTables::of($order)
            ->editColumn('id', function ($order) {
                return $order->id;
            })
            ->editColumn('from', function ($order) {
                return User::find($order->send_by_lab) ? User::find($order->send_by_lab)->name : '';
            })
            ->editColumn('to', function ($order) {
                return User::find($order->lab_id) ? User::find($order->lab_id)->name : '';
            })

            ->editColumn('date', function ($order) {
                return $order->date;
            })
            ->editColumn('time', function ($order) {
                return $order->time;
            })
            ->editColumn('qty', function ($order) {
                return $order->qty;
            })
            ->editColumn('more', function ($order) {
                return $order->id;
            })
            ->editColumn('courier_type', function ($order) {
                return $order->courier_type;
            })
            ->editColumn('status', function ($order) {
                if ($order->status == '0') {

                    return "Transit ";
                }
                if ($order->status == '1') {
                    return "Received at Point";
                }
                if ($order->status == '2') {
                    return "Received at Lab";
                }

            })
            ->make(true);
    }
     public function show_OrdersTable_rec()
    {
        $order = Transport::all();
        return DataTables::of($order)
            ->editColumn('id', function ($order) {
                return $order->id;
            })
            ->editColumn('from', function ($order) {
                return User::find($order->send_by_lab) ? User::find($order->send_by_lab)->name : '';
            })
            ->editColumn('to', function ($order) {
                return User::find($order->lab_id) ? User::find($order->lab_id)->name : '';
            })

            ->editColumn('date', function ($order) {
                return $order->date;
            })
            ->editColumn('time', function ($order) {
                return $order->time;
            })
            ->editColumn('qty', function ($order) {
                return $order->qty;
            })
            ->editColumn('more', function ($order) {
                return $order->id;
            })
            ->editColumn('courier_type', function ($order) {
                return $order->courier_type;
            })
            ->editColumn('status', function ($order) {
                if ($order->status == '0') {
                    return "Transit ";
                }
                if ($order->status == '1') {
                    return "Received at Point";
                }
                if ($order->status == '2') {
                    return "Received at Lab";
                }
            })
            ->make(true);
    }

    public function getorderdetails($id)
    {
        $data = Transport::find($id);
        if ($data) {
            return json_encode($data);
        }
        return 0;
    }
        public function getorderdetails_rec($id)
    {
        $data = Transport::find($id);
        if ($data) {
            return json_encode($data);
        }
        return 0;
    }
}
