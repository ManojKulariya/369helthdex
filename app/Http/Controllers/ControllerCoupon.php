<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use App\Models\Coupon;
use App\Models\Package;
use App\Models\Profiles;
use App\Models\Parameter;
use DataTables;
use Session;
use Auth;
use Hash;
use App\Models\Complaint;
use App\Models\Application;
use App\Models\Callback;

class ControllerCoupon extends Controller
{
    public function complaints()
    {
        return view("admin.coupon.feedback");
    }
    public function callback()
    {
        return view("admin.coupon.index");
    }
    public function application()
    {
        return view("admin.coupon.application");
    }
    public function application_datatable()
    {
        $data = Application::with('job')->where('is_submited', 1)->get();

        return DataTables::of($data)
            ->editColumn('id', function ($data) {
                return $data->id;
            })
            ->editColumn('Vacancies', function ($data) {
                // job (Vacancie) is SoftDeletes-enabled; a soft-deleted vacancy
                // resolves this relation to null and previously crashed the
                // whole table with "Attempt to read property on null".
                return $data->job ? $data->job->title : '—';
            })
            ->editColumn('name', function ($data) {
                return $data->name;
            })
            ->editColumn('dob', function ($data) {
                return $data->dob;
            })
            ->editColumn('number', function ($data) {
                return $data->number;
            })

            ->editColumn('adhar_no', function ($data) {
                return $data->adhar_no;
            })
            ->editColumn('current_ctc', function ($data) {
                return $data->current_ctc;
            })
            ->editColumn('expected_ctc', function ($data) {
                return $data->expected_ctc;
            })
            ->editColumn('address', function ($data) {
                return $data->address;
            })
            ->editColumn('resume', function ($data) {
                $documentPath = storage_path("app/public/resumes/{$data->resume}");
                if (file_exists($documentPath)) {
                    $url = url("storage/app/public/resumes/{$data->resume}");
                    return '<a href="' . $url . '" target="_blank" class="adm-cat-eye" title="View resume"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/></svg></a>';
                } else {
                    return 'File not found';
                }
            })
            // Without this, yajra/laravel-datatables HTML-escapes every column
            // by default, so the resume link/icon above was rendering as
            // literal "&lt;a href=..." text instead of a clickable element.
            ->rawColumns(['resume'])
            ->make(true);
    }

    public function complaintsdatatable()
    {
        $data = Complaint::orderBy('status', 'asc')->get();
        return DataTables::of($data)
            ->editColumn('id', function ($data) {
                return $data->id;
            })
            ->editColumn('name', function ($data) {
                return $data->name;
            })
            ->editColumn('email', function ($data) {
                return $data->email;
            })
            ->editColumn('number', function ($data) {
                return $data->number;
            })

            ->editColumn('message', function ($data) {
                return $data->message;
            })
            ->make(true);
    }

    public function calbackdatatable()
    {
        $data = Callback::get();
        return DataTables::of($data)
            ->editColumn('id', function ($data) {
                return $data->id;
            })
            ->editColumn('name', function ($data) {
                return $data->name;
            })
            ->editColumn('number', function ($data) {
                return $data->number;
            })

            ->editColumn('message', function ($data) {
                return $data->message;
            })
            ->make(true);
    }
    public function show_coupon()
    {
        $coupons = Coupon::orderBy('id', 'desc')->get();
        $data['coupons'] = $coupons;
        return view("admin.coupon.default")->with("data", $data);
    }
    public function show_savecoupon($id)
    {
        $data = Coupon::find($id);
        $packages = Package::all();
        $test = Profiles::all();
        $Parameter = Parameter::all();
        return view("admin.coupon.savecoupon")->with("id", $id)->with("data", $data)->with("packages", $packages)->with('test', $test)->with('parameter', $Parameter);
    }
    public function coupondatatable()
    {
        $data = Coupon::orderBy('id', 'desc')->get();
        return DataTables::of($data)
            ->editColumn('id', function ($data) {
                return $data->id;
            })
            ->editColumn('coupon_code', function ($data) {
                return '<b>'.$data->coupon_code.'</b><br> Available For:- '.$data->available_for;
            })
            ->editColumn('name', function ($data) {
                if ($data->type == '1') {
                    $model = Package::class; $label = 'Package'; $col = 'name';
                } elseif ($data->type == '2') {
                    $model = Parameter::class; $label = 'Parameter'; $col = 'name';
                } elseif ($data->type == '3') {
                    $model = Profiles::class; $label = 'Test'; $col = 'profile_name';
                } else {
                    return 'ALL';
                }
                $ids = array_filter(explode(',', (string) $data->product_ids));
                if (count($ids) == 0) {
                    return '—';
                }
                if (count($ids) == 1) {
                    $item = $model::find($ids[0]);
                    return $item ? $item->{$col} : '—';
                }
                return count($ids) . ' ' . $label . 's';
            })
            ->editColumn('value', function ($data) {
                if ($data->coupon_type == 'fixed') {
                    $val = "Rs." . $data->coupon_value;
                } else {
                    $val = $data->coupon_value . "%";
                }

                return $val;
            })
            ->editColumn('start_date', function ($data) {
                return $data->coupon_start_date;
            })
            ->editColumn('end_date', function ($data) {
                return $data->coupon_end_date;
            })
            ->editColumn('action', function ($data) {
                $edittext = __('message.Edit');
                $deletetext = __('message.Delete');
                $edit = url('savecoupon', array('id' => $data->id));
                $delete = route('delete-coupon', array('id' => $data->id));
                return '<div class="adm-row-actions">'
                    .'<a href="' . $edit . '" class="adm-act adm-act--green"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>' . $edittext . '</a>'
                    .'<a onclick="delete_record(' . "'" . $delete . "'" . ')" class="adm-act adm-act--red"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>' . $deletetext . '</a>'
                    .'</div>';
            })
            ->rawColumns(['coupon_code', 'action'])
            ->make(true);
    }
    public function show_update_coupon(Request $request)
    {
        $input = $request->all();
        if ($request->get("id") == 0) {
            $store = new coupon();
            $rel_img = "";
            $msg = 'message.Coupon Add Successfully';
        } else {
            $store = Coupon::find($request->get("id"));
            $msg = 'Coupon Update Successfully';
        }
        $store->available_for = $input['available_for'];
        $store->type = $input['type'];
        $store->coupon_code = $input['coupon_code'];
        $store->coupon_type = $input['coupon_type'];
        $store->coupon_value = $input['coupon_value'];
        $store->coupon_start_date = $input['coupon_start_date'];
        $store->coupon_end_date = $input['coupon_end_date'];
        if ($input['type'] == 1) {
            $store->product_ids = implode(",", $request->get("select_package"));
        } elseif ($input['type'] == 2) {
            $store->product_ids = implode(",", $request->get("select_pera"));
        } elseif ($input['type'] == 3) {
            $store->product_ids = implode(",", $request->get("select_test"));
        } else {
            $store->product_ids = null;
        }
        $store->day = implode(",", $request->get("day"));
        $store->save();
        Session::flash('message', $msg);
        Session::flash('alert-class', 'alert-success');
        return redirect()->route('admin-coupon');
    }
    public function deletecoupon($id)
    {
        $data = Coupon::find($id);
        if ($data) {
            $data->delete();
            Session::flash('message', 'Coupon Delete Successfully');
            Session::flash('alert-class', 'alert-success');
        }
        return redirect()->route('admin-coupon');
    }
}
