<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\City;
use App\Models\Category;
use App\Models\Complaint;
use App\Models\Subcategory;
use App\Models\Package;
use App\Models\Parameter;
use App\Models\Package_FRQ;
use App\Models\TestDetails;
use App\Models\Popular_package;
use Illuminate\Support\Facades\Log;
use App\Models\Profiles;
use App\Models\FamilyMember;
use App\Models\CartMember;
use App\Models\UserAddress;
use App\Models\Setting;
use App\Models\PaymentGateway;
use App\Models\Orders;
use App\Models\OrdersData;
use App\Models\Contactus;
use App\Models\News;
use App\Models\Token;
use App\Models\Review;
use App\Models\Offer;
use App\Models\Coupon;
use App\Models\Blog;
use App\Models\Content;
use App\Models\Tag;
use App\Models\Application;
use App\Models\Vacancie;
use App\Models\Timeslote;
use App\Models\Report;
use App\Models\Feedback;
use App\Models\Resetpassword;
use App\Models\Homevisit;
use Session;
use Auth;
use Cart;
use DB;
use Mail;
use App\Models\Callback;
use App\Models\Userprescription;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Cache;
use App\Models\Discount;
use App\Models\Discountid;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Carbon\Carbon; // Make sure to import Carbon if not already imported
use Razorpay\Api\Api;
use App\Events\TestOrderReceived;
use App\Models\Wallet;


class FrontController extends Controller
{
    use \App\Http\Controllers\Concerns\CalculatesDrivingDistances;

    public $currentDate;
    public function __construct()
    {
         $this->currentDate = Carbon::now();

    }
    public function test_sms(){
        
        
       
            $path = public_path('file/List.xlsx'); // Path to your Excel file
        
            // Load the spreadsheet
            $spreadsheet = IOFactory::load($path);
        
            $sheet = $spreadsheet->getSheet(0);
            $sheetpkg = $spreadsheet->getSheet(1);
        
            // Convert to array
            $rows = $sheet->toArray();
            $rowspkg = $sheetpkg->toArray();
            // Optional: get headers (if you have column names in the first row)
            $headers = array_shift($rows);
            $headers = array_shift($rowspkg);
        
            // Initialize arrays
            $mainData = [];
            $diffData = [];
            $pkgs = [];
        
            // Loop through all rows
            foreach ($rows as $row) {
                // Get 2nd column value (index 1 since array starts at 0)
                $secondCol = isset($row[1]) ? $row[1] : null;
        
                if ($secondCol == 1) {
                    $mainData[] = $row;
                } else {
                    $diffData[] =$row;
                }
            }
            // Loop through all rows
            foreach ($rowspkg as $row) {
                
                $pkgs[] = $row;
              
            }
            
        $parameters =  $mainData;
        $tests = $diffData;
        // dd($pkgs);
        $sampleMap = DB::table('sample_types')->pluck('id', 'sample_name')->toArray();
        $subcategory = DB::table('subcategory')->pluck('id', 'name')->toArray();

        
        DB::table('parameters')->truncate();
        foreach($parameters as $test){
           
            
            $name = $test[0] ;
            if($name != ''){
            if(isset($test[6]) && $test[6] !== ''){
                $price = $test[6];
            }
            // Generate slug
            $slug = Str::slug($name);
            $originalSlug = $slug;
            $count = 1;
    
            // Ensure uniqueness
            while (Parameter::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }
            $Parameterdata = new Parameter();
            $Parameterdata->name = $name;
            $Parameterdata->slug = $slug;
            $Parameterdata->test_short_code = $test[2];
            $Parameterdata->short_desc = Str::limit($test[4] ?? '', 30);
            $Parameterdata->description = $test[4];
              $sampleName = trim($test[3] ?? '');
            $Parameterdata->sample_type = $sampleMap[$sampleName] ?? null;
              $subcategoryname = trim($test[8] ?? '');
            $Parameterdata->category_id = $subcategory[$subcategoryname] ?? null;
            $Parameterdata->report_time = $test[7];
            $Parameterdata->mrp = $price;
            $Parameterdata->price = $price;
            $Parameterdata->save();
            }
        } 
       
        DB::table('profiles')->truncate();
        foreach($tests as $test){
             if($test[6] !== ''){
              $price = $test[6];  
            }
            $paramString = $test[2] ?? ''; // original string from Excel

            // 1. Normalize line breaks to commas
            $paramString = str_replace(["\r\n", "\n", "\r"], ',', $paramString);
            
            // 2. Replace multiple spaces with a single space
            $paramString = preg_replace('/\s+/', ' ', $paramString);
            
            // 3. Split by comma
            $paramNames = array_filter(array_map('trim', explode(',', $paramString)));

            $paramIds = [];
            foreach ($paramNames as $paramName) {
                $paramName = trim($paramName);
                if ($paramName == '') continue;
        
                // Find parameter ID by name
                $param = Parameter::where('name', $paramName)->first();
                if ($param) {
                    $paramIds[] = $param->id;
                }
            }
            $name = $test[0] ;
            if($name != ''){
            
            // Generate slug
            $slug = Str::slug($name);
            $originalSlug = $slug;
            $count = 1;
    
            // Ensure uniqueness
            while (Profiles::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }
            $Parameterdata = new Profiles();
            $Parameterdata->profile_name = $name;
            $Parameterdata->slug = $slug;
             $Parameterdata->no_of_parameter = implode(',', $paramIds);;
            $Parameterdata->test_short_code = $name;
            $Parameterdata->no_of_test = $test[1];
            $Parameterdata->test_recommended_for = 'Male,Female';
            $Parameterdata->test_recommended_for_age = 'All';
            $Parameterdata->short_desc = Str::limit($test[4] ?? '', 30);
            $Parameterdata->description = $test[4];
              $sampleName = trim($test[3] ?? '');
            $Parameterdata->sample_type = $sampleMap[$sampleName] ?? null;
              $subcategoryname = trim($test[8] ?? '');
            $Parameterdata->category_id = $subcategory[$subcategoryname] ?? null;
            $Parameterdata->report_time = $test[7];
            $Parameterdata->mrp = $price;
            $Parameterdata->price = $price;
            $Parameterdata->save();
            }
        } 
        
        DB::table('packages')->truncate();
        DB::table('test_details')->truncate();
        foreach($pkgs as $test){
            
            $name = $test[0] ;
            if($name != ''){
            
            // Generate slug
            $slug = Str::slug($name);
            $originalSlug = $slug;
            $count = 1;
    
            // Ensure uniqueness
            while (Package::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }
            $Parameterdata = new Package();
            $Parameterdata->name  = $name;
            $Parameterdata->slug = $slug;
            $Parameterdata->test_short_code = $name;
            $Parameterdata->paramter_included = $test[3];
            $Parameterdata->test_recommended_for = 'Male,Female';
            $Parameterdata->test_recommended_for_age = 'All';
            $Parameterdata->short_desc = Str::limit($test[4] ?? '', 30);
            $Parameterdata->description = $test[4];
               $sampleName = trim($test[2] ?? '');
            $Parameterdata->sample_type = $sampleMap[$sampleName] ?? null;
               $subcategoryname = trim($test[0] ?? '');
            $Parameterdata->category_id = $subcategory[$subcategoryname] ?? 38;
            $Parameterdata->report_time = $test[8];
            $Parameterdata->mrp = $test[7];
            $Parameterdata->price = $test[6];
            $Parameterdata->save();
                if($Parameterdata->id ){
                    
                    // Process paramter_included
                    $paramString = $test[1] ?? '';
            
                    // Normalize line breaks & spaces
                    $paramString = str_replace(["\r\n", "\n", "\r"], ',', $paramString);
                    $paramString = preg_replace('/\s+/', ' ', $paramString);
            
                    // Split names
                    $names = array_filter(array_map('trim', explode(',', $paramString)));
            
                    foreach ($names as $paramName) {
                        if ($paramName == '') continue;
            
                        // Check Parameter table (type = 1)
                        $param = Parameter::where('name', $paramName)->first();
                        if ($param) {
                            $type = 1;
                            $typeId = $param->id;
                        } else {
                            // Check Profile table (type = 2)
                            $profile = Profiles::where('profile_name', $paramName)->first();
                            if ($profile) {
                                $type = 2;
                                $typeId = $profile->id;
                            } else {
                                // Not found, skip
                                continue;
                            }
                        }
            
                        // Insert into test_details
                        $testDetail = new TestDetails();
                        $testDetail->package_id = $Parameterdata->id;
                        $testDetail->type = $type;        // 1 = Parameter, 2 = Profile
                        $testDetail->type_id = $typeId;   // corresponding ID
                        $testDetail->save();
                    }
                }
            }
        } 
       
        
        $branchIds = User::where('user_type',2)->whereNull('deleted_at')->pluck('id');
      
        DB::table('parameter_branch')->truncate();
        DB::table('profile_branch')->truncate();
        DB::table('package_branch')->truncate();
        $Parameter = Parameter::get();
         
        foreach($Parameter as $row){
            
              foreach ($branchIds as $branchId) {
               
                    DB::table('parameter_branch')->insert([
                        'parameter_id' => $row->id,
                        'branch_id'    => $branchId,
                        'price'=> round($row->mrp * 1.15, 2),
                        'mrp'=> $row->price,
                        'created_at'   => now(),
                        'updated_at'   => now(),
                    ]);
                
            }
        }
        $Profile = Profiles::get();
        foreach($Profile as $row){
            
              foreach ($branchIds as $branchId) {
               
                 DB::table('profile_branch')->insert([
                    'profile_id' => $row->id,
                    'branch_id'  => trim($branchId),
                    'mrp'=> $row->mrp,
                    'price'=> round($row->mrp * 1.15, 2),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
            }
        }
        $Package = Package::get();
        foreach($Package as $row){
         
            
              foreach ($branchIds as $branchId) {
               
                DB::table('package_branch')->insert([
                    'package_id' => $row->id,
                    'branch_id'  => trim($branchId),
                    'mrp'=> $row->mrp,
                    'price'=> $row->price,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
            }
        }
        dd('dn prices');
        
    }
     public function certification()
    {
        $setting = Setting::find(1);
        $title = "Certification";
        return view("front.certification")->with('title', $title)->with("setting", $setting);
    }
    public function submit_application(Request $request)
    {
        // Handle file upload and save data
        $file = $request->file('resume');
        $fileName = uniqid() . '_' . $file->getClientOriginalName(); // Generate a unique filename
        $folderName = storage_path("app/public/resumes/");
        $file->move($folderName, $fileName);

        // Save data in the model
        $model = Application::find($request->input('id'));
        $model->name = $request->input('name');
        $model->dob = $request->input('dob');
        $model->adhar_no = $request->input('adhar_no');
        $model->number = $request->input('number');
        $model->current_ctc = $request->input('current_ctc');
        $model->expected_ctc = $request->input('expected_ctc');
        $model->address = $request->input('address');
        $model->resume = $fileName;
        $model->is_submitted = 1; // Fixed typo: is_submited to is_submitted
        $model->save();

        return redirect()->route('home');

    }
    public function get_aj_pera(Request $request)
    {
        $inputLatitude = $request->session()->get('latitude');
        $inputLongitude = $request->session()->get('longitude');
        if ($inputLatitude == '') {
            $inputLatitude = 26.9124;
            $inputLongitude = 75.7873;
        }

        $city = City::with('users')->whereBetween('lat', [$inputLatitude - 0.1, $inputLatitude + 0.1])
            ->whereBetween('lng', [$inputLongitude - 0.1, $inputLongitude + 0.1])
            ->get();
        $usersIds = $city->pluck('users.*.id')->flatten();
        #-----------------pearametr------------------------------
        $pera = array();
        $uniquepera = collect();

        foreach ($usersIds as $branchId) {
            // $data = Parameter::where('branch_id', 'REGEXP', '[[:<:]]' . $branchId . '[[:>:]]')->whereNull('deleted_at')->get();
            $data = Parameter::join('parameter_branch', 'parameters.id', '=', 'parameter_branch.parameter_id')
            ->where('parameter_branch.branch_id', $branchId)
            ->whereNull('parameters.deleted_at')
            ->select('parameters.*')
            ->get();


            foreach ($data as $package) {
                $dis_pa = $this->get_discount($package->id,'Parameter',$package->mrp);
                $package->discount = $dis_pa;
                $uniquepera->add($package);
            }
        }

        $pera = $uniquepera->unique('id');

        if (count($pera) == 0) {
            $inputLatitude = 26.9124;
            $inputLongitude = 75.7873;
            $city = City::with('users')->whereBetween('lat', [$inputLatitude - 0.1, $inputLatitude + 0.1])
                ->whereBetween('lng', [$inputLongitude - 0.1, $inputLongitude + 0.1])
                ->get();
            $usersIds = $city->pluck('users.*.id')->flatten();

            $uniquepera = collect();

            foreach ($usersIds as $branchId) {
                $data = Parameter::where('branch_id', 'REGEXP', '[[:<:]]' . $branchId . '[[:>:]]')->whereNull('deleted_at')->get();

                foreach ($data as $package) {
                    
                    $dis_pa = $this->get_discount($package->id,'Parameter',$package->mrp);
                    $package->discount = $dis_pa;
                    
                    $uniquepera->add($package);
                }
            }

            $pera = $uniquepera->unique('id');


        }

        return response()->json($pera);
    }
    public function getcenter(Request $request)
    {
        $inputLatitude = $request->session()->get('userlatitude');
        $inputLongitude = $request->session()->get('userlongitude');
        if ($inputLatitude == '') {
            $inputLatitude = 26.9124;
            $inputLongitude = 75.7873;
        }

        $data = User::with('location')
            ->join('city as user_city', 'users.city', '=', 'user_city.id')
            ->select('users.*', 'user_city.lat', 'user_city.lng',
                DB::raw("(6371 * acos(cos(radians($inputLatitude)) * cos(radians(user_city.lat)) * cos(radians(user_city.lng) - radians($inputLongitude)) + 
            sin(radians($inputLatitude)) * sin(radians(user_city.lat)))) AS distance"))
            ->where('users.user_type', 2)
            ->orderBy('distance')
            ->paginate(10);

        return response()->json($data);
    }
    public function getjob(Request $request)
    {

        $data = Vacancie::where('status', 1)->orderBy('id', 'desc')
            ->paginate(10);
        return response()->json($data);
    }
    public function applyjob(Request $request)
    {

        $setting = Setting::first();
        $data = Vacancie::find($request->id);
        return view("front.jobdetails")->with("setting", $setting)->with('data', $data);

    }
    public function promotion_discount(Request $request)
    {

        $setting = Setting::first();

        $offer = Offer::get();
        $cp = Coupon::with(['test', 'package', 'parameter'])->where('coupon_start_date', '<=', date('Y-m-d'))
            ->where('coupon_end_date', '>=', date('Y-m-d'))
            ->get();


        return view("front.promotion_discount")->with("setting", $setting)->with('offer', $offer)->with('cp', $cp);
    }
    public function nearest_center(Request $request)
    {

        $setting = Setting::first();

        $inputLatitude = $request->session()->get('latitude');
        $inputLongitude = $request->session()->get('longitude');
        if ($inputLatitude == '') {
            $inputLatitude = 26.9124;
            $inputLongitude = 75.7873;
        }

        $data = User::with('location')
            ->join('city', 'users.city', '=', 'city.id')
            ->select('users.*', 'city.lat', 'city.lng', DB::raw("(6371 * acos(cos(radians($inputLatitude)) * cos(radians(city.lat)) * cos(radians(city.lng) - radians($inputLongitude)) + sin(radians($inputLatitude)) * sin(radians(city.lat)))) AS distance"))
            ->where('users.user_type', 2)
            ->orderBy('distance')
            ->paginate(10);

        return view("front.center")->with("setting", $setting)->with('data', $data);
    }
    public function career(Request $request)
    {

        $setting = Setting::first();
        $data = Vacancie::where('status', 1)->orderBy('id', 'desc')
            ->paginate(10);


        return view("front.career")->with("setting", $setting)->with('data', $data);
    }
    public function show_report_view($id)
    {
        $data = Report::where('order_id', $id)->get();
        return view("front.report")->with('reportdata', $data);

    }
    public function save_callback(Request $request)
    {

        $data = new Callback();

        $data->name = $request->name;
        $data->number = $request->number;
        $data->message = $request->message;
        $data->save();
        Session::flash('messagecall', 'Request send successfully.');
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }
    public function save_prescription(Request $request)
    {

        $data = new Userprescription();
        if ($request->file("prescription")) {

            $file = $request->file('prescription');
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension() ?: 'png';
            $folderName = Storage_path("app/public/profile/");
            $picture = rand() . time() . '.' . $extension;
            $request->file('prescription')->move($folderName, $picture);

            $data->prescription = $picture;
        }

        //    $data->user_id = Auth::id();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->gender = $request->gender;
        $data->d_o_b = $request->d_o_b;
        $data->number = $request->number;
        $data->is_agree = $request->is_agree;
        $data->location_id = $request->location_id;
        $data->save();

        Session::flash('message', 'Prescription Save successfully.');
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }
    public function save_feedback(Request $request)
    {
         if ($request->captcha_input !== session('captcha')) {

                return back()->with('message', 'Invalid CAPTCHA!')->with('alert-class', 'alert-danger')->withInput();
            }
        $data = new Complaint();

        $data->name = $request->name;
        $data->email = $request->email;
        $data->number = $request->number;
        $data->message = $request->message;
        $data->save();

        Session::flash('message', 'Feedback/Complaints Send successfully.');
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }

    public function save_home(Request $request)
    {

        $data = new Homevisit();
        $data->user_id = Auth::id();
        $data->user_name = $request->get("user_name");
        $data->user_number = $request->get("user_number");
        $data->user_email = $request->get("user_email");
        $data->city_id = $request->get("city");
        $data->lat = $request->get("lat");
        $data->lng = $request->get("long");
        $data->state = $request->get("state");
        $data->pincode = $request->get("pincode");
        $data->lab_id = $request->get("lab_id");
        $data->save();

        Session::flash('message', 'request send successfully.');
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }
    public function get_map_url_ex(Request $request)
    {

        $city = City::where('default', 'Yes')->with('users')->get();

        $data_url_profile = [];

        foreach ($city as $row) {

            $slug_city = $row->slug;

            $data_url_profile[] = route('lifestyle-disorder', ['city' => $slug_city]);

            $data_url_profile[] = route('popular-blood-tests', ['city' => $slug_city]);

            $data_url_profile[] = route('popular-packages', ['city' => $slug_city]);

            $data = Profiles::whereNull('deleted_at')->get();
            foreach ($data as $row) {
                $url = route('profile', ['city' => $slug_city, 'id' => $row->slug]);

                $data_url_profile[] = $url;
            }


            $packageUrls = Package::whereNull('deleted_at')->get();
            foreach ($packageUrls as $row) {
                $url = route('package', ['city' => $slug_city, 'id' => $row->slug]);

                $data_url_profile[] = $url;
            }


            $categorydata = Subcategory::where('is_deleted', '0')->get();


            foreach ($categorydata as $row) {
                $package_list = Package::whereRaw("FIND_IN_SET(?, category_id) > 0", [$row->id])->whereNull('deleted_at')->count();
                $profile_list = Profiles::whereRaw("FIND_IN_SET(?, category_id) > 0", [$row->id])->whereNull('deleted_at')->count();
                $parameter_list = Parameter::whereRaw("FIND_IN_SET(?, category_id) > 0", [$row->id])->whereNull('deleted_at')->count();

                if ($package_list != 0 && $profile_list != 0 && $parameter_list != 0) {
                    $data_url_profile[] = route('lifestyledisorder', ['city' => $slug_city, 'slug' => $row->slug]);
                }
            }
        }
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getActiveSheet()->setTitle('URLs');

        // Add data to the worksheet
        foreach ($data_url_profile as $rowIndex => $row) {
            $columnIndex = 1; // Define the column index (e.g., 1 for the first column)
            $cell = $spreadsheet->getActiveSheet()->getCellByColumnAndRow($columnIndex, $rowIndex + 1); // Adjust row index to start from 1
            $cell->setValue($row);
        }


        // Create a writer instance for Excel file
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        // Generate a temporary file path
        $filePath = storage_path('app/public/temporary.xlsx');

        // Save the Excel file to the temporary path
        $writer->save($filePath);

        // Define the headers for the response
        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="Url.xlsx"',
        ];

        // Return the Excel file as a response
        return response()->file($filePath, $headers);

    }
    public function get_map_url_ex1(Request $request)
    {
        $cityName = session()->get('cityName');
        if ($cityName == '') {
            $cityName = 'Jamnagar';
        }
        $city = City::with('users')->get();

        $data_url_profile = array();
        $data_url_pkg = array();
        $data_url_desorder = array();

        //return $city;
        foreach ($city as $row) {

            $slug_city = $row->slug;
            foreach ($row->users as $user) {
                $test = array();

                $data = Profiles::where('branch_id', 'REGEXP', '[[:<:]]' . $user->id . '[[:>:]]')->whereNull('deleted_at')->get();

                foreach ($data as $package) {
                    $url = route('profile', ['city' => $slug_city, 'id' => $package->slug]);

                    $data_url_profile[] = $url;
                }
            }
            // foreach($row->users as $user){
            //     $test = array();
            //     $data_popular = Package::where('branch_id', 'REGEXP', '[[:<:]]' . $user->id . '[[:>:]]')->whereNull('deleted_at')->get();
            //     foreach ($data_popular as $package) {
            //         $test['url'] = route('package', ['city'=>$slug_city,'id' => $package->slug]);
            //         $test['data'] = $package->name;
            //         $data_url_pkg[]=$test;
            //     }
            // }


        }
        return $data_url_profile;
        $collection = new Collection($data_url_profile);
        // Define the Excel file's headers
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="data.xlsx"',
        ];
        $callback = function () use ($collection) {
            $handle = fopen('php://output', 'w');

            // Add headers
            fputcsv($handle, ['URL']);

            // Add data rows
            foreach ($collection as $row) {
                fputcsv($handle, $row);
            }

            fclose($handle);
        };

        // Return the Excel file as a response
        return response()->stream($callback, 200, $headers);

    }
    public function get_map_url(Request $request)
    {
        $cityName = session()->get('cityName');
        if ($cityName == '') {
            $cityName = 'Jamnagar';
        }
        $city = City::where('slug', $cityName)->with('users')->get();

        $data_url_profile = array();
        $data_url_pkg = array();
        $data_url_desorder = array();

        foreach ($city as $row) {

            $slug_city = $row->slug;
            $city = $row->city;
        }
        $defaultcityID = $this->getdefaultcityid(session()->get('cityName'));
        $data = Profiles::join('profile_branch', 'profiles.id', '=', 'profile_branch.profile_id')
                        ->select('profiles.*')->where('is_featured',1)
                        ->whereIn('profile_branch.branch_id', [$defaultcityID])
                        ->whereNull('deleted_at')->get();
        foreach ($data as $package) {
            $test = array();
            $test['url'] = route('profile', ['city' => $slug_city, 'id' => $package->slug]);
            $test['data'] = $package->profile_name;
            $data_url_profile[] = $test;
        }


        $data_popular = Package::join('package_branch', 'packages.id', '=', 'package_branch.package_id')
                       ->whereIn('package_branch.branch_id', [$defaultcityID])
                       ->select('packages.*')
                       ->whereNull('deleted_at')->get();
        foreach ($data_popular as $package) {
            $test = array();
            $test['url'] = route('package', ['city' => $slug_city, 'id' => $package->slug]);
            $test['data'] = $package->name;
            $data_url_pkg[] = $test;
        }


        $categorydata = Subcategory::where('is_deleted', '0')->get();
        foreach ($categorydata as $row) {
            $test = array();
            $package_list = Package::whereRaw("FIND_IN_SET(?, category_id) > 0", [$row->id])->whereNull('deleted_at')->count();
            $profile_list = Profiles::whereRaw("FIND_IN_SET(?, category_id) > 0", [$row->id])->whereNull('deleted_at')->count();
            $parameter_list = Parameter::whereRaw("FIND_IN_SET(?, category_id) > 0", [$row->id])->whereNull('deleted_at')->count();

            if ($package_list != 0 and $profile_list != 0 and $parameter_list != 0) {
                $test['url'] = route('lifestyle-disorder', ['city' => $slug_city]);
                $test['data'] = $row->name;
                $data_url_desorder[] = $test;
            }

        }
        $data_url_city = array();
        $cityData = City::where('default', 'Yes')->with('users')->get();

        foreach ($cityData as $row) {
            $test_city = array();
            $test_city['url'] = route('popular-blood-tests', ['city' => $row->slug]);
            $test_city['data'] = $row->city;
            $data_url_city[] = $test_city;
        }
        $response['profile_test'] = $data_url_profile;

        $response['package_test'] = $data_url_pkg;

        $response['package_disorder'] = $data_url_desorder;
        $response['city_test'] = $data_url_city;

        return response()->json($response);
    }
    public function updateLocationcity(Request $request)
    {

        // Retrieve latitude and longitude from the request
        $cityId = $request->input('id');

        if ($cityId != "undefined") {

            $city = City::find($cityId);

            // Also seed the user coordinates with the chosen city's centre so lab
            // distances have a sane basis when browser geolocation is denied.
            // When geolocation is granted, the layout script overwrites these
            // with the precise position on the next page load.
            session([
                'cityName' => $city->slug,
                'loctionID' => $cityId,
                'latitude' => $city->lat,
                'longitude' => $city->lng,
                'userlatitude' => (float) $city->lat,
                'userlongitude' => (float) $city->lng,
            ]);
        }

        // Return a response if necessary
        return response()->json(['message' => 'Location updated and stored in session']);
    }
    public function getloc($ip)
    {
        
        $loc = [
                'latitude'=>'',
                'longitude'=>''
            ] ;
        try{
        $url = "http://ip-api.com/json/{$ip}";
        $ch = curl_init();
        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Set timeout to avoid hanging requests
    
        // Execute cURL request
        $response = curl_exec($ch);

        // On cURL failure return the empty coordinates array — callers
        // array-access the result, so never return a Response object here.
        if (curl_errno($ch)) {
            curl_close($ch);
            return $loc;
        }

        // Close cURL session
        curl_close($ch);

        // Decode JSON response
        $location = json_decode($response, true);

        if (is_array($location) && isset($location['status']) && $location['status'] === 'success') {
            $latitude = $location['lat'];
            $longitude = $location['lon'];
            
            $loc = [
                'latitude'=>$latitude,
                'longitude'=>$longitude
            ] ;
            
        }
        } catch (\Exception $e) {
            }
        return $loc;
        
    
    }
    public function updateLocation($ip)
    {

        if (session()->has('cityName')  ) {
            return response()->json(['message' => 'Location updated and stored in session']);

        }
        $res = $this->getloc($ip);
        // Only trust the IP lookup when it returned real coordinates. Casting an
        // empty string to float yields 0.0 (a point in the Gulf of Guinea), which
        // used to poison the session and produce ~8,000 km lab distances.
        if (!is_array($res)
            || !isset($res['latitude'], $res['longitude'])
            || !is_numeric($res['latitude']) || !is_numeric($res['longitude'])
            || (float) $res['latitude'] == 0.0 || (float) $res['longitude'] == 0.0) {
            return response()->json(['message' => 'Location unavailable'], 200);
        }
        $latitude = (float) $res['latitude'];
        $longitude = (float) $res['longitude'];
        $city = City::whereBetween('lat', [$latitude - 0.1, $latitude + 0.1])
            ->whereBetween('lng', [$longitude - 0.1, $longitude + 0.1])
            ->where('status', 1)
            ->first();
        if ($city) {
            $cityId = $city->id;
            $cityName = $city->slug;
            session(['cityName' => $cityName, 'loctionID' => $cityId]);
        }
        session(['latitude' => $latitude, 'longitude' => $longitude, 'userlatitude' => $latitude, 'userlongitude' => $longitude]);
        return response()->json(['message' => 'Location updated and stored in session']);
    }

    /**
     * Stores the browser's geolocation (sent by the layout script as
     * /update-location?latitude=..&longitude=..) so lab distances use the
     * visitor's real position. Serves the existing "update-location" route,
     * which previously pointed at updateLocation($ip) and always failed
     * because the route supplies no $ip argument.
     */
    public function updateBrowserLocation(Request $request)
    {
        $latitude = $request->query('latitude');
        $longitude = $request->query('longitude');

        if (!is_numeric($latitude) || !is_numeric($longitude)) {
            return response()->json(['message' => 'Invalid latitude or longitude provided'], 400);
        }

        $latitude = (float) $latitude;
        $longitude = (float) $longitude;

        if (($latitude == 0.0 && $longitude == 0.0)
            || $latitude < -90 || $latitude > 90
            || $longitude < -180 || $longitude > 180) {
            return response()->json(['message' => 'Invalid latitude or longitude provided'], 400);
        }

        // Keep any city the visitor already picked; only auto-detect when unset.
        if (!session()->has('cityName')) {
            $city = City::whereBetween('lat', [$latitude - 0.1, $latitude + 0.1])
                ->whereBetween('lng', [$longitude - 0.1, $longitude + 0.1])
                ->where('status', 1)
                ->first();
            if ($city) {
                session(['cityName' => $city->slug, 'loctionID' => $city->id]);
            }
        }

        session(['latitude' => $latitude, 'longitude' => $longitude, 'userlatitude' => $latitude, 'userlongitude' => $longitude]);
        return response()->json(['message' => 'Location updated and stored in session']);
    }
    public function get_discount($test_id,$type,$mrp){
        $mrp = (float) $mrp;
        $fixed=0;
        $per=0;
        // dd($mrp);
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
        public function deleteAccount()
    {
        return view('themes.original.deleteAccountGuide');
    }
    public function show_home(Request $request)
    {
        $this->updateLocation($request->ip());
        $inputLatitude = $request->session()->get('latitude');
        $inputLongitude = $request->session()->get('longitude');
        // is_numeric guards against null/'' and legacy sessions poisoned with 0.0
        // (PHP 8: 0 == '' is false, so the old check let 0.0 through).
        if (!is_numeric($inputLatitude) || !is_numeric($inputLongitude)
            || (float) $inputLatitude == 0.0 || (float) $inputLongitude == 0.0) {
            $inputLatitude = 26.9124;
            $inputLongitude = 75.7873;
        }
        $inputLatitude = (float) $inputLatitude;
        $inputLongitude = (float) $inputLongitude;
        #------------------- lab ----------------------------
        $inputLatitudeuser = $request->session()->get('userlatitude');
        $inputLongitudeuser = $request->session()->get('userlongitude');
        if (!is_numeric($inputLatitudeuser) || !is_numeric($inputLongitudeuser)
            || (float) $inputLatitudeuser == 0.0 || (float) $inputLongitudeuser == 0.0) {
            // Fall back to the selected city's coordinates, then to the default city.
            $inputLatitudeuser = $inputLatitude;
            $inputLongitudeuser = $inputLongitude;
        }
        $inputLatitudeuser = (float) $inputLatitudeuser;
        $inputLongitudeuser = (float) $inputLongitudeuser;


        $defaultcityID = $this->getdefaultcityid(session()->get('cityName'));
        // Spherical law of cosines on Earth radius 6371 km; the LEAST/GREATEST
        // clamp keeps acos() in its domain when rounding pushes the argument
        // past ±1 (user standing exactly at the lab's coordinates). This value
        // is the straight-line fallback; real road distances are applied below.
        $lab = User::with('location')
            ->join('city as user_city', 'users.city', '=', 'user_city.id')
            ->select('users.*', 'user_city.lat', 'user_city.lng', DB::raw("(6371 * acos(LEAST(1.0, GREATEST(-1.0, cos(radians($inputLatitudeuser)) * cos(radians(user_city.lat)) * cos(radians(user_city.lng) - radians($inputLongitudeuser)) + sin(radians($inputLatitudeuser)) * sin(radians(user_city.lat)))))) AS distance"))
            ->where('users.user_type', 2)
            ->orderBy('distance')
            ->get();

        // Replace the straight-line values with Google Distance Matrix road
        // distances (matches the "Get Directions" figure). Falls back to the
        // straight-line value per lab whenever the API/key is unavailable.
        $lab = $this->apply_driving_distances($lab, $inputLatitudeuser, $inputLongitudeuser);
        $lab = $lab->sortBy('distance')->values();

        #------------------- end lab ----------------------------
        #-------------------test-------------------------------
      

        $test = array();
        
         $branchId = $defaultcityID;

        // check karo data hai ya nahi
        $branchExists = DB::table('profile_branch')
            ->where('branch_id', $branchId)
            ->exists();
        
        if (!$branchExists) {
            $branchId = DB::table('profile_branch')->value('branch_id'); // fallback
        }
        
        $uniquePackages = Profiles::query()
            ->join('profile_branch as pb', 'pb.profile_id', '=', 'profiles.id')
            ->where('pb.branch_id', $branchId)
            ->whereNull('profiles.deleted_at')
            ->select('profiles.*','pb.mrp','pb.price')
            ->distinct()
            ->take(6)
            ->get();

            $ls = array();
            if ($uniquePackages) {

                foreach ($uniquePackages as $row) {
                    $mrp = 0;
                    $dis_pa = $this->get_discount($row->id,'Profiles',$row->mrp);
                    $row->discount = $dis_pa;
                    $arr = explode(",", $row->no_of_parameter);
                    $row->no_of_parameter = count($arr);
                    foreach ($arr as $a) {
                        $ls[] = Parameter::find($a) ? Parameter::find($a)->name : '';
                        $mrp += Parameter::find($a) ? Parameter::find($a)->mrp : 0;
                    }
                    $row->paramater_data = implode(",", $ls);
            
                    $ls = [];
                }
                $test = $uniquePackages;
            }
        
        #-------------------end test -----------------------------
        $offer = Offer::get();
        $category = array();
        $categorydata = Subcategory::where('is_deleted', '0')->get();

        foreach ($categorydata as $row) {

            $package_list = Package::whereRaw("FIND_IN_SET(?, category_id) > 0", [$row->id])->whereNull('deleted_at')->count();
            $profile_list = Profiles::whereRaw("FIND_IN_SET(?, category_id) > 0", [$row->id])->whereNull('deleted_at')->count();
            $parameter_list = Parameter::whereRaw("FIND_IN_SET(?, category_id) > 0", [$row->id])->whereNull('deleted_at')->count();

            if ($package_list != 0 and $profile_list != 0 and $parameter_list != 0) {
                $category[] = $row;
            }

        }

        $inputLatitude = $request->session()->get('latitude');
        $inputLongitude = $request->session()->get('longitude');
       
        
        $data_popular = array();
        $branchId = $defaultcityID;
        
        // check karo data hai ya nahi
        $branchExists = DB::table('package_branch')
            ->where('branch_id', $branchId)
            ->exists();
        
        if (!$branchExists) {
            $branchId = DB::table('package_branch')->value('branch_id'); // fallback
        }
        
        $uniquePkg = Package::join('package_branch', 'packages.id', '=', 'package_branch.package_id')
            ->where('package_branch.branch_id', $branchId)
            ->select('packages.*','package_branch.mrp','package_branch.price')
            ->whereNull('packages.deleted_at')
            ->distinct()
            ->take(6)
            ->get();

            foreach ($uniquePkg as $p) {
                $ls = array();
                $parameter = 0;
                $find_pa = TestDetails::where("package_id", $p->id)->get();
                $dis_pa = $this->get_discount($p->id,'Package',$p->mrp);
                $mrp = 0;
                
                foreach ($find_pa as $d) {
                    $p_data=[];
                    if ($d->type == 1) {
                        $p_data['name'] = Parameter::find($d->type_id) ? Parameter::find($d->type_id)->name : '';
                        $mrp += Parameter::find($d->type_id) ? Parameter::find($d->type_id)->mrp : 0;
                        $parameter = $parameter + 1;
                    }
                    if ($d->type == 2) {
                        $a = Profiles::find($d->type_id);
                        $p_data['name'] = Profiles::find($d->type_id) ? Profiles::find($d->type_id)->profile_name : '';
                        // $mrp += Profiles::find($d->type_id) ? Profiles::find($d->type_id)->mrp : 0;
                        
                        if ($a) {
                            $arr = explode(",", $a->no_of_parameter);
                            foreach ($arr as $l) {
                                $mrp += Parameter::find($l) ? Parameter::find($l)->mrp : 0;
                            }
                            $p_data['count']= count($arr);
                            $parameter = $parameter + count($arr);
                        }
                    }
                    $ls[]=$p_data;
                }

                $p->no_of_parameter = $parameter;
                $p->paramater_data = $ls;
                $p->discount = $dis_pa;

            }
            $data_popular = $uniquePkg;
        
        $setting = Setting::find(1);
        $data_feedback = Feedback::with('userdata')->orderby('id', 'DESC')->get();
        
        $blogdata = Blog::orderBy('id', 'DESC')->take(6)->get();
        
        $contentdata = Content::get();
        Session::put("active_menu", "1");
        return view("front.home")->with('lab', $lab)->with('test', $test)->with('offer', $offer)->with("category", $category)
            ->with("setting", $setting)->with("data_popular", $data_popular)->with("data_feedback", $data_feedback)->with("blogdata", $blogdata)
            ->with("contentdata", $contentdata)->with("totalcartmember", $this->gettotalcartmember());
    }
    
    public function save_contact_detail(Request $request)
    {
        if ($request->captcha_input !== session('captcha')) {

                return back()->with('message', 'Invalid CAPTCHA!')->with('alert-class', 'alert-danger')->withInput();
            }
        $store = new Contactus();
        $store->name = $request->get("name");
        $store->email = $request->get("email");
        $store->phone = $request->get("phone");
        $store->subject = $request->get("subject");
        $store->message = $request->get("message");
        $store->save();
        Session::flash('message', __('message.Connect To You Very Soon'));
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }

    public function show_post_user_feedback(Request $request)
    {
       
        $store = new Feedback();
        $store->user_id = Auth::id();
        $store->order_id = $request->get("order_id");
        $store->description = $request->get("description");
        $store->date = $this->getsitedate();
        $store->save();
        Session::flash('message', __('message.Thanks For Your Feedback'));
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }

    public function getallpack()
    {
        $data1 = Package::whereNull('deleted_at')->get();
        $data2 = Profiles::whereNull('deleted_at')->get();
        $data3 = Parameter::whereNull('deleted_at')->get();
        $ls = array();
        foreach ($data1 as $d1) {
            $a = array();
            $a['id'] = $d1->id;
            $a['name'] = $d1->name;
            $ls[] = $a;
        }
        foreach ($data2 as $d1) {
            $a = array();
            $a['id'] = $d1->id;
            $a['name'] = $d1->profile_name;
            $ls[] = $a;
        }
        foreach ($data3 as $d1) {
            $a = array();
            $a['id'] = $d1->id;
            $a['name'] = $d1->name;
            $ls[] = $a;
        }
        return json_encode($ls);
    }
    public function searchtag(Request $request){
     
        $branchIds = $this->getdefaultcityid(session()->get('cityName'));
        $searchText = $request->input('tags');
        $results = DB::table('profiles')
        ->select('profiles.id','profiles.tag', 'profiles.profile_name',DB::raw("'profile' as typetable")) // Align column names using "as"
        ->join('profile_branch', 'profiles.id', '=', 'profile_branch.profile_id')
        ->whereIn('profile_branch.branch_id', [$branchIds])
        ->where(function($q) use ($searchText) {
            $q->where('profiles.tag', 'LIKE', "%$searchText%")
              ->orWhere('profiles.profile_name', 'LIKE', "%$searchText%");
        })
        ->union(
                DB::table('packages')
                    ->select('packages.id','packages.tag', 'packages.name',DB::raw("'package' as typetable")) // Use "name" from `packages`
                    ->join('package_branch', 'packages.id', '=', 'package_branch.package_id')
                    ->whereIn('package_branch.branch_id', [$branchIds])
                    ->where(function($q) use ($searchText) {
                        $q->where('packages.tag', 'LIKE', "%$searchText%")
                          ->orWhere('packages.name', 'LIKE', "%$searchText%");
                    })
                )
        ->union(
                DB::table('parameters')
                    ->select('parameters.id',DB::raw("'tag' as tag"), 'parameters.name', DB::raw("'parameter' as typetable"))
                    ->join('parameter_branch', 'parameters.id', '=', 'parameter_branch.parameter_id')
                    ->whereIn('parameter_branch.branch_id', [$branchIds])
                    ->where(function($q) use ($searchText) {
                        $q->where('parameters.test_short_code', 'LIKE', "%$searchText%")
                          ->orWhere('parameters.name', 'LIKE', "%$searchText%");
                    })
                
        )
        ->paginate(16); 
        
        $data = $results->items();
      
        $html='';
        $cityName = session()->get('cityName');
        if($cityName == ''){ $cityName='Jamnagar';}
        foreach($data as $item){
            
            if($item->typetable === 'profile'){
                $itemData = Profiles::join('profile_branch', 'profiles.id', '=', 'profile_branch.profile_id')
                                ->select('profiles.*','profile_branch.mrp','profile_branch.price')
                                ->whereIn('profile_branch.branch_id', [$branchIds])->find($item->id);
                if($itemData){
                    $arr = explode(",", $itemData->no_of_parameter);
                    $no_of_parameter = count($arr);
                    $ls = array();
                    $mrp = 0;
                    foreach ($arr as $a) {
                        $parameter = Parameter::find($a);
                        if ($parameter) {
                            $mrp += $parameter->mrp;
                            $ls[] = Parameter::find($a) ? Parameter::find($a)->name : '';
                        }
                    }
                    $itemData->paramater_data = implode(",", $ls);
                    $html .='<div class="col-lg-4 col-md-6 col-sm-12 pricing-block">
                              <div class="pricing-block-one">
                                <div class="pricing-table">
                                  <div class="box_badges" style="font-size:11px;">'.$no_of_parameter.'<br/>Parameters</div>
                                    <div class="table-header"> 
                                      <h2 style="font-size:16px;"><a href="' . route('profile', ['city' => $cityName, 'id' => $itemData->slug]) . '" style="text-decoration: none; color: inherit;">' . $itemData->profile_name .'</a></h2>
                                    </div>
                                <div class="table-content">
                                    <div class="row" style="font-size:12px;line-height:1.2;">';
                                        $arr = explode(",", $itemData->paramater_data); // Convert the data to an array
                                        $arr = array_slice($arr, 0, 8); // Limit to the first 8 items
                                        $chunks = array_chunk($arr, 4); // Split into chunks of 4
                                        foreach ($chunks as $chunk){
                                            $html .='<div class="col-6">';
                                                    foreach ($chunk as $item){
                                                        $html .='&#10003; '.$item.'<br>';
                                                    }
                                            $html .='</div>';
                                        }
                                        
                                $html .='</div>
                                    <a href="'.route('profile', ['city'=>$cityName,'id' => $itemData->slug ]) .'" class="more-link">+ Know More</a>
                                </div>
                                <div class="table-footer">';
                        		  if($itemData->price > 0 ){
                            	   $html .='<h4><span class="price">'.number_format($itemData->price,2,'.','').'</span> / <span class="discount_price">'.number_format($itemData->mrp,2,'.','').'</span> </h4>';
                                  }else{
                                   $html .='<h4><span class="discount_price">'.number_format($itemData->mrp,2,'.','').'</span></h4>';
                                    }
                        $html .='<div class="btn-box">
                                <a href="'.route('checkouts', ['id' => $itemData->id, 'type' => 3, 'parameter' => $no_of_parameter ?? '0']).'" class="theme-btn-one">
                                    Book Now<i class="icon-Arrow-Right"></i>
                                </a>
                                
                            </div>
                        </div>';
                    $html .='</div>
                                </div>
                                    </div>';
                }
            }elseif($item->typetable === 'parameter'){
                $itemData = Parameter::join('parameter_branch', 'parameters.id', '=', 'parameter_branch.parameter_id')
                                        ->select('parameters.*','parameter_branch.mrp','parameter_branch.price')
                                        ->whereIn('parameter_branch.branch_id', [$branchIds])
                                        ->find($item->id);
                if($itemData){
                    $no_of_parameter = 1;
                    $itemData->price = $itemData->mrp;
                    $html .='<div class="col-lg-4 col-md-6 col-sm-12 pricing-block">
                              <div class="pricing-block-one">
                                <div class="pricing-table">
                                  <div class="box_badges" style="font-size:11px;">'.$no_of_parameter.'<br/>Parameters</div>
                                    <div class="table-header"> 
                                      <h2 style="font-size:16px;"><a href="' . route('parameter', ['city' => $cityName, 'id' => $itemData->slug]) . '" style="text-decoration: none; color: inherit;">' . $itemData->name .'</a></h2>
                                    </div>
                                <div class="table-footer">';
                        		  //if($itemData->price > 0 ){
                            // 	   $html .='<h4><span class="price">'.number_format($itemData->price,2,'.','').'</span> / <span class="discount_price">'.number_format($itemData->mrp,2,'.','').'</span> </h4>';
                            //       }else{
                                   $html .='<h4><span class="discount_price">'.number_format($itemData->mrp,2,'.','').'</span></h4>';
                                    // }
                        $html .='<div class="btn-box">
                                <a href="'.route('checkouts', ['id' => $itemData->id, 'type' => 2, 'parameter' => $no_of_parameter ?? '0']).'" class="theme-btn-one">
                                    Book Now<i class="icon-Arrow-Right"></i>
                                </a>
                            </div>
                        </div>';
                    $html .='</div>
                                </div>
                                    </div>';
                }
            }else{
                $itemData = Package::join('package_branch', 'packages.id', '=', 'package_branch.package_id')
                                        ->select('packages.*','package_branch.mrp','package_branch.price')
                                        ->whereIn('package_branch.branch_id', [$branchIds])->find($item->id);
                if($itemData){
                    $ls = array();
                    $find_pa = TestDetails::where("package_id", $item->id)->get();
                    $parameter = 0;
                    $mrp =0;
                    foreach ($find_pa as $d) {
                        $p_data=[];
                        if ($d->type == 1) {
                            $p_data['name'] = Parameter::find($d->type_id) ? Parameter::find($d->type_id)->name : '';
                            $parameter = $parameter + 1;
                            $mrp += Parameter::find($d->type_id) ? Parameter::find($d->type_id)->mrp : 0;
                        }
                        if ($d->type == 2) {
                            $a = Profiles::find($d->type_id);
                            $p_data['name'] = Profiles::find($d->type_id) ? Profiles::find($d->type_id)->profile_name : '';
                            if ($a) {
                                $arr = explode(",", $a->no_of_parameter);
                                $parameter = $parameter + count($arr);
                                foreach($arr as $l){
                                    $mrp += Parameter::find($l) ? Parameter::find($l)->mrp : 0;
                                }
                            }
                        }
                        $ls[]=$p_data;
                    }
                    $itemData->paramater_data = $ls;
                    $html .='<div class="col-lg-4 col-md-6 col-sm-12 pricing-block">
                                <div class="pricing-block-one">
                                    <div class="pricing-table">
                                      <div class="box_badges" style="font-size:11px;">'.$parameter.'<br/>Parameters</div>
                                      <div class="table-header"> 
                                        <h2 style="font-size:16px;"><a href="' . route('package', ['city' => $cityName, 'id' => $itemData->slug]) . '" style="text-decoration: none; color: inherit;">' . $itemData->name . '</a></h2>
                                      </div>
                                 <div class="table-content">
                                     <div class="row" style="font-size:12px;line-height:1.2;">';
                                        $arrs = array_slice($itemData->paramater_data, 0, 8); // Get only the first 8 items
                                        $chunks = array_chunk($arrs, 4);
                                        foreach ($chunks as $chunk){
                                            $html .='<div class="col-6">';
                                                foreach ($chunk as $arr){
                                                    $html .='&#10003; '.$arr['name'];
                                                    if(isset($arr['count'])){
                                                        $html .='('. $arr['count'] .')'; 
                                                    }
                                                    $html .='<br>';
                                                }
                                            $html .='</div>';
                                        }
                                    $html .='</div>
                                    <a href="'.route('package', ['city'=>$cityName,'id' => $itemData->slug ]).'" class="more-link">+ Know More</a>
                                  </div>
                                <div class="table-footer">';
                                    if($itemData->price > 0 ){
                                    $html .='<div>
                                      <h3><span class="price">'.number_format($itemData->price,2,'.','').'</span>/
                                            <span class="discount_price">'.number_format($itemData->mrp,2,'.','').'</span></h3>
                                    </div>';
                                    }else{
                                    $html .='<div>
                                      <h3><span class="discount_price">'.number_format($itemData->mrp,2,'.','').'</span></h3>
                                    </div>';
                                    }
                                   $html .='<div class="btn-box"><a href="'.route('checkouts', ['id' => $itemData->id, 'type' => 1, 'parameter' => $parameter ?? '0']).'" class="book_now">Book Now<i class="icon-Arrow-Right"></i></a></div>
                                  </div>';
                    
                    $html .='</div>
                                </div>
                                    </div>';
                }
            }
        }
        
        return response()->json([
        'data' => $data, // Current page data
        'output'=>$html,
        'next_page_url' => $results->nextPageUrl()
    ]);

    }
    public function search(Request $request){
        $searchText = $request->input('tags');
        $setting = Setting::find(1);
        return view("front.search")->with("setting", $setting)->with('searchText',$searchText);
    }
    public function show_search_item(Request $request)
    {
        //dd($request->all());
        $cityName = session()->get('cityName');
        if ($cityName == '') {
            $cityName = 'Jamnagar';
        }
        $tags = $request->get("tags");
        $data1 = Package::whereNull('deleted_at')->Where('name', $tags)->first();
        if ($data1) {

            $url = route('package', ['city' => $cityName, 'id' => $data1->slug]);
            return redirect($url);
        }
        $data2 = Profiles::whereNull('deleted_at')->Where('profile_name', $tags)->first();
        if ($data2) {
            $url = route('profile', ['city' => $cityName, 'id' => $data2->slug]);
            return redirect($url);
        }
        $data21 = Profiles::whereNull('deleted_at')->Where('test_short_code', $tags)->first();
        if ($data21) {
            $url = route('profile', ['city' => $cityName, 'id' => $data21->slug]);
            return redirect($url);
        }
        $data3 = Parameter::whereNull('deleted_at')->Where('name', $tags)->first();
        if ($data3) {

            $url = route('parameter', ['city' => $cityName, 'id' => $data3->slug]);
            return redirect($url);
        }
        $data31 = Parameter::whereNull('deleted_at')->Where('test_short_code', $tags)->first();
        if ($data31) {

            $url = route('parameter', ['city' => $cityName, 'id' => $data31->slug]);
            return redirect($url);
        }
        return redirect()->back();
    }

    public function addnewsletter($email)
    {
        $store = new News();
        $store->email = $email;
        $store->save();
        return 1;
    }

    public function show_postreview(Request $request)
    {
        $data = new Review();
        $data->user_id = Auth::id();
        $data->type = $request->get("type");
        $data->type_id = $request->get("type_id");
        $data->ratting = $request->get("rating");
        $data->description = $request->get("description");
        $data->date = $this->getsitedate();
        $data->save();
        Session::flash('message', __('message.Review Record Successfully'));
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }

    public function show_categorylist($cityid)
    {

        $this->change_city($cityid);

        $labs = $this->get_selected_city_other_labs($cityid);
        $popular_package = Popular_package::whereNull('deleted_at')->get();
        $category = Category::where('is_deleted', '0')->get();
        $subcategory = array();
        $categorydata = Subcategory::where('is_deleted', '0')->get();
        $defaultcityID = $this->getdefaultcityid(session()->get('cityName'));
        
        foreach ($categorydata as $row) {
            $package_list = Package::join('package_branch', 'packages.id', '=', 'package_branch.package_id')
                               ->whereIn('package_branch.branch_id', [$defaultcityID])->whereNull('packages.deleted_at')
                               ->select('packages.*','package_branch.mrp','package_branch.price')
                               ->whereRaw("FIND_IN_SET(?, category_id) > 0", [$row->id])->count();
            $profile_list = Profiles::join('profile_branch as pb', 'pb.profile_id', '=','profiles.id')
                                    ->whereIn('pb.branch_id', [$defaultcityID])
                                    ->whereNull('profiles.deleted_at')
                                    ->select('profiles.*','pb.mrp','pb.price')
                                    ->whereRaw("FIND_IN_SET(?, category_id) > 0", [$row->id])->count();
            $parameter_list = Parameter::join('parameter_branch', 'parameters.id', '=', 'parameter_branch.parameter_id')
                                ->whereIn('parameter_branch.branch_id', [$defaultcityID])
                                ->whereNull('parameters.deleted_at')
                                ->select('parameters.*','parameter_branch.mrp','parameter_branch.price')
                                ->whereRaw("FIND_IN_SET(?, category_id) > 0", [$row->id])->count();

            if ($package_list != 0 || $profile_list != 0 || $parameter_list != 0) {
                $subcategory[] = $row;
            }

        }
        
        
        $contentdata = Content::get();
        Session::put("active_menu", "5");
        $setting = Setting::find(1);
        return view("front.category_list")->with('labs', $labs)->with("category", $category)->with("subcategory", $subcategory)->with("contentdata", $contentdata)->with("popular_package", $popular_package)->with("setting", $setting)->with("totalcartmember", $this->gettotalcartmember());
    }




    public function change_city($cityid)
    {
        $cityData = City::where('slug', $cityid)->first();
        if ($cityData) {
            session(['cityName' => $cityData->slug, 'loctionID' => $cityData->id, 'latitude' => $cityData->lat, 'longitude' => $cityData->lng]);
        }
        return;
    }
    
    public function show_test_list(Request $request, $cityid)
    {
        $this->change_city($cityid);
        $labs = $this->get_selected_city_other_labs($cityid);
        $setting = Setting::find(1);
        $category = Category::where('is_deleted', '0')->get();
        $inputLatitude = (float) $request->session()->get('latitude');
        $inputLongitude = (float) $request->session()->get('longitude');
        if ($inputLatitude == '') {
            $inputLatitude = 26.9124;
            $inputLongitude = 75.7873;
        }

        $city = City::with('users')->whereBetween('lat', [$inputLatitude - 0.1, $inputLatitude + 0.1])
            ->whereBetween('lng', [$inputLongitude - 0.1, $inputLongitude + 0.1])
            ->get();
        $usersIds = $city->pluck('users.*.id')->flatten();
        $defaultcityID = $this->getdefaultcityid(session()->get('cityName'));
        #-----------------pearametr------------------------------
        $pera = array();
        $uniquepera = collect();

        foreach ($usersIds as $branchId) {
            $data = Parameter::where('branch_id', 'REGEXP', '[[:<:]]' . $branchId . '[[:>:]]')->whereNull('deleted_at')->get();

            foreach ($data as $package) {
                $uniquepera->add($package);
            }
        }

        $pera = $uniquepera->unique('id');

        if (count($pera) == 0) {
            $inputLatitude = 26.9124;
            $inputLongitude = 75.7873;


            $city = City::with('users')->whereBetween('lat', [$inputLatitude - 0.1, $inputLatitude + 0.1])
                ->whereBetween('lng', [$inputLongitude - 0.1, $inputLongitude + 0.1])
                ->get();
            $usersIds = $city->pluck('users.*.id')->flatten();

            $uniquepera = collect();

            foreach ($usersIds as $branchId) {
                $data = Parameter::where('branch_id', 'REGEXP', '[[:<:]]' . $branchId . '[[:>:]]')->whereNull('deleted_at')->get();

                foreach ($data as $package) {
                    $uniquepera->add($package);
                }
            }

            $pera = $uniquepera->unique('id');


        }
        // dd($pera);
        #---------------------end pera-----------------------------

        $test = array();

        $uniquePackages = Profiles::query()
                ->join('profile_branch as pb', 'pb.profile_id', '=', 'profiles.id')
                ->whereIn('pb.branch_id', [$defaultcityID])   // $usersIds can be [1812, ...] or a single id
                ->whereNull('profiles.deleted_at')
                ->select('profiles.*','pb.mrp','pb.price')                         // important: select base table columns
                ->distinct('profiles.id')  
                ->get();
                // dd($uniquePackages[0]);
        $ls = array();
        if ($uniquePackages) {

            foreach ($uniquePackages as $row) {
                $mrp = 0;
                $dis_pa = $this->get_discount($row->id,'Profiles',$row->mrp);
                    
                $row->discount = $dis_pa;

                $arr = explode(",", $row->no_of_parameter);

                $i = 0;
                foreach ($arr as $a) {

                    $ls[] = Parameter::find($a) ? Parameter::find($a)->name : '';
                    $mrp += Parameter::find($a) ? Parameter::find($a)->mrp : 0;
                    ++$i;
                }
                $row->no_of_parameter = count($ls);
                $row->paramater_data = implode(",", $ls);
                
                $ls = [];
            }
            $test = $uniquePackages;
        }
        $contentdata = Content::get();
        Session::put("active_menu", "11");
        return view("front.test_list")->with('labs', $labs)->with('pera', $pera)->with("category", $category)->with("popular_package", $test)->with("contentdata", $contentdata)->with("setting", $setting)->with("totalcartmember", $this->gettotalcartmember());
    }

    public function show_package_list(Request $request, $cityid)
    {
        // dd($cityid);
        $this->change_city($cityid);
        $labs = $this->get_selected_city_other_labs($cityid);
        // dd($labs);
        $inputLatitude = (float) $request->session()->get('latitude');
        $inputLongitude = (float) $request->session()->get('longitude');
        if ($inputLatitude == '') {
            $inputLatitude = 26.9124;
            $inputLongitude = 75.7873;
        }

        $city = City::with('users')->whereBetween('lat', [$inputLatitude - 0.1, $inputLatitude + 0.1])
            ->whereBetween('lng', [$inputLongitude - 0.1, $inputLongitude + 0.1])
            ->get();
        $usersIds = $city->pluck('users.*.id')->flatten();

        $category = Category::where('is_deleted', '0')->get();
        $setting = Setting::find(1);
        $defaultcityID = $this->getdefaultcityid(session()->get('cityName'));
        $uniquePackages = Package::join('package_branch', 'packages.id', '=', 'package_branch.package_id')
                   ->whereIn('package_branch.branch_id', [$defaultcityID])->whereNull('deleted_at')
                   ->select('packages.*','package_branch.mrp','package_branch.price')
                   ->distinct('packages.id')
                   ->get();

        $popular_package = array();

        foreach ($uniquePackages as $p) {
            $ls = array();
            $find_pa = TestDetails::where("package_id", $p->id)->get();
            $parameter = 0;
            $i = 0;
            $mrp = 0;
            foreach ($find_pa as $d) {
                
                $p_data=[];
                $i++;
                if ($d->type == 1) {
                    $p_data['name'] = Parameter::find($d->type_id) ? Parameter::find($d->type_id)->name : '';
                    $mrp += Parameter::find($d->type_id) ? Parameter::find($d->type_id)->mrp : 0;
                    $parameter = $parameter + 1;
                }
                if ($d->type == 2) {
                    $a = Profiles::find($d->type_id);
                    $p_data['name'] = Profiles::find($d->type_id) ? Profiles::find($d->type_id)->profile_name : '';
                    
                    // $mrp += Profiles::find($d->type_id) ? Profiles::find($d->type_id)->mrp : 0;
                    
                    if($a) {
                        $arr = explode(",", $a->no_of_parameter);
                        $p_data['count'] = count($arr);
                        foreach ($arr as $l) {
                            $mrp += Parameter::find($l) ? Parameter::find($l)->mrp : 0;
                        }
                        $parameter = $parameter + count($arr);
                    }
                }
                $ls[] = $p_data;
            }
            $dis_pa = $this->get_discount($p->id,'Package',$p->mrp);
            $p->discount = $dis_pa;
            $p->no_of_parameter = $parameter;
            $p->paramater_data =  $ls;

        }
         $contentdata = Content::get();
        Session::put("active_menu", "4");
        return view("front.package_list")->with('labs', $labs)->with("category", $category)->with("popular_package", $uniquePackages)->with("contentdata", $contentdata)->with("setting", $setting)->with("totalcartmember", $this->gettotalcartmember());
    }

    public function show_subcategory_detail($city, $slug)
    {

        $this->change_city($city);
        $category = Category::where('is_deleted', '0')->get();

        $subcategory = Subcategory::where('slug', $slug)->first();
        
        if(!$subcategory){
            return "not found!";
        }
        $defaultcityID = $this->getdefaultcityid(session()->get('cityName'));
        
        $id = $subcategory->id;
        $setting = Setting::find(1);
        $data1 = Package::join('package_branch', 'packages.id', '=', 'package_branch.package_id')
                           ->whereIn('package_branch.branch_id', [$defaultcityID])->whereNull('packages.deleted_at')
                           ->select('packages.*','package_branch.mrp','package_branch.price')
                           ->whereRaw("FIND_IN_SET(?, packages.category_id) > 0", [$id])->get();
                    
        $data2 = Profiles::join('profile_branch as pb', 'pb.profile_id', '=','profiles.id')
                            ->whereIn('pb.branch_id', [$defaultcityID])
                            ->whereNull('profiles.deleted_at')
                            ->select('profiles.*','pb.mrp','pb.price')
                            ->whereRaw("FIND_IN_SET(?, category_id) > 0", [$id])->get();
        $data3 = Parameter::join('parameter_branch', 'parameters.id', '=', 'parameter_branch.parameter_id')
                            ->whereIn('parameter_branch.branch_id', [$defaultcityID])
                            ->whereNull('parameters.deleted_at')
                            ->select('parameters.*','parameter_branch.mrp','parameter_branch.price')
                            ->whereRaw("FIND_IN_SET(?, category_id) > 0", [$id])->get();
        $ls = array();
        foreach ($data1 as $d1) {
            
            $find_pa = TestDetails::where("package_id", $d1->id)->get();
            $parameter = 0;
            $mrp = 0;
            $ls1 = array();
            foreach ($find_pa as $d) {
                $p_data=[];
                if ($d->type == 1) {
                    $p_data['name'] = Parameter::find($d->type_id) ? Parameter::find($d->type_id)->name : '';
                    $parameter = $parameter + 1;
                    $mrp += Parameter::find($d->type_id) ? Parameter::find($d->type_id)->mrp : 0;
                }
                if ($d->type == 2) {
                    $a = Profiles::find($d->type_id);
                    $p_data['name'] = Profiles::find($d->type_id) ? Profiles::find($d->type_id)->profile_name : '';
                    
                    if ($a) {
                        $arr = explode(",", $a->no_of_parameter);
                        $p_data['count'] = count($arr);
                        foreach ($arr as $l) {
                            $mrp += Parameter::find($l) ? Parameter::find($l)->mrp : 0;
                        }
                        $parameter = $parameter + count($arr);
                    }
                }
                $ls1[]=$p_data;
            }      
            $d1->paramater_data = $ls1;
            $d1->type = '1';
            $d1->no_of_parameter = $parameter;
            $d1->parameter_list = $ls1;
            $ls[] = $d1;
        }
        $total2 = 0;
        foreach ($data2 as $d1) {
            $mrp = 0;
            $arr = explode(",", $d1->no_of_parameter);
            
            $ls1 = array();
           
            foreach ($arr as $a) {
                $parameter = Parameter::withTrashed()->find($a);
                if ($parameter) {
                    $ls1[] = $parameter->name;
                    $mrp += $parameter->mrp;
                }
            }
            $lsd = implode(",", $ls1);
           
            $d1->paramater_data = $lsd;
            $d1->name = $d1->profile_name;
            $d1->type = '3';
            $d1->no_of_parameter = count($arr);
            $d1->parameter_list = $ls1;
            $ls[] = $d1;
        }
        
        $data = $ls;
        Session::put("active_menu", "5");
        return view("front.subcategory_list")->with("category", $category)->with("subcategory", $subcategory)
            ->with("package_list", $data)
            ->with("setting", $setting)->with("totalcartmember", $this->gettotalcartmember());
    }
    public function show_bloglist()
    {
        $setting = Setting::find(1);
        $blogdata = Blog::orderBy('id', 'DESC')->get();
        return view("front.blog_list")->with('blogdata', $blogdata)->with('setting', $setting);
    }

    public function show_blog_detail($slug)
    {
        $blog = Blog::where('slug', $slug)->with('likes','comments')->first();
        if($blog){
            $selectedTags = explode(',', $blog->tag); 
            $tag = Tag::whereIn('id',$selectedTags)->orderBy('id', 'DESC')->get();
    
            $setting = Setting::find(1);
            return view("front.blog_detail")->with("blog", $blog)->with("tag", $tag)->with("setting", $setting);
        }
        return "Not Found!";
        
    }

    public function getselectedtest($type,$id){
        $defaultcityID = $this->getdefaultcityid(session()->get('cityName'));
        if($type == 1){
            $data = Package::join('package_branch', 'packages.id', '=', 'package_branch.package_id')
                           ->whereIn('package_branch.branch_id', [$defaultcityID])->whereNull('packages.deleted_at')
                           ->select('packages.*','package_branch.mrp','package_branch.price')->find($id);
            if($data){
                $find_pa = TestDetails::where("package_id", $id)->get();
                $mrp =0;
                foreach ($find_pa as $d) {
                    if ($d->type == 1) {
                        $mrp += Parameter::find($d->type_id) ? Parameter::find($d->type_id)->mrp : 0;
                    }
                    if ($d->type == 2) {
                        $a = Profiles::find($d->type_id);
                        if ($a) {
                            $arr = explode(",", $a->no_of_parameter);
                            foreach($arr as $l){
                                $mrp += Parameter::find($l) ? Parameter::find($l)->mrp : 0;
                            }
                        }
                    }
                } 
            }
           
            
        }
        if($type == 2){
            $data = Parameter::join('parameter_branch', 'parameters.id', '=', 'parameter_branch.parameter_id')
                            ->whereIn('parameter_branch.branch_id', [$defaultcityID])
                            ->whereNull('parameters.deleted_at')
                            ->select('parameters.*','parameter_branch.mrp','parameter_branch.price')->find($id);
         
        }
        if($type == 3){
            $data = Profiles::join('profile_branch as pb', 'pb.profile_id', '=','profiles.id')
                            ->whereIn('pb.branch_id', [$defaultcityID])
                            ->whereNull('profiles.deleted_at')
                            ->select('profiles.*','pb.mrp','pb.price')->find($id);
            if($data){
                $data->name = $data->profile_name;
                $mrp = 0;
                $arr = explode(",", $data->no_of_parameter);
                foreach ($arr as $a) {
                    $mrp += Parameter::find($a) ? Parameter::find($a)->mrp : 0;
                }
            }
            
           
        }
        return $data;
    }
    public function show_checkout($id=null,$type=null,$parameter=null)
    {
        $new_card_data = ['test_id'=>$id,'test_type'=>$type,'parameter'=>$parameter];
        $cart = CartMember::where("user_id", Auth::id())->get();
        $walet = Setting::select('wallet_cashback_per', 'wallet_cashback_point')->first();
        $selectedtest='';
        if($type != null & $id != null){
            $selectedtest = $this->getselectedtest($type,$id);
        }
        if (count($cart) < 0) {
            return redirect()->route('home');
        }
        $popular_package = Popular_package::whereNull('deleted_at')->get();
        $category = Category::where('is_deleted', '0')->get();
        $getfamilymemenber = FamilyMember::where("user_id", Auth::id())->get();
        $cartmember = CartMember::with('family_member_data')->where("user_id", Auth::id())->get();
        foreach ($getfamilymemenber as $g) {
            $store = CartMember::where("family_member_id", $g->id)->where("user_id", Auth::id())->first();
            if ($store) {
                $g->cartmember = '1';
            } else {
                $g->cartmember = '0';
            }
        }
        $setting = Setting::find(1);
        $getcurrency = explode("-", $setting->currency);
        $useraddress = UserAddress::where("user_id", Auth::id())->get();
        $getallkeys = PaymentGateway::all();
        // $getcity = City::where("is_deleted",'0')->get();
        $userLat = session()->get('latitude');
        $userLng = session()->get('longitude');
        if ($userLat == '') {
            $userLat = 26.9124;
            $userLng = 75.7873;
        }
        $getcity = City::select(
            '*',
            DB::raw('(6371 * acos(cos(radians(' . $userLat . ')) * cos(radians(lat)) * cos(radians(lng) - radians(' . $userLng . ')) + sin(radians(' . $userLat . ')) * sin(radians(lat)))) as distance')
        )->where('is_deleted', '0')
            ->orderBy('distance', 'asc')
            ->get();
        $ls = array();
        foreach ($getallkeys as $g) {
            $ls[$g->payment_gateway_name . "_" . $g->key_name] = $g->meta_value;
        }
        $ls1 = $this->getcartcontent();
        $clientToken = "";
        if ($ls['Braintree_is_active'] == '1') {
            $gateway = new \Braintree\Gateway([
                'environment' => $ls['Braintree_environment'],
                'merchantId' => $ls['Braintree_merchantId'],
                'publicKey' => $ls['Braintree_publicKey'],
                'privateKey' => $ls['Braintree_privateKey']
            ]);
            $clientToken = $gateway->clientToken()->generate();
        }

        #-------------coupon---------------------
        //where('branch_id', 'REGEXP', '[[:<:]]' . $branchId . '[[:>:]]')
        $Coupon = collect();
        foreach ($cart as $cp) {
            $Coupon = $Coupon->merge(
                Coupon::with(['test', 'package', 'parameter'])
                    ->where('available_for','user')
                    ->where('type', $cp->type)
                    ->where('product_ids', 'REGEXP', '[[:<:]]' . $cp->type_id . '[[:>:]]')
                    ->where('coupon_start_date', '<=', date('Y-m-d'))
                    ->where('coupon_end_date', '>=', date('Y-m-d'))
                    ->get()
            );
        }
        $Coupon = $Coupon->merge(
            Coupon::with(['test', 'package', 'parameter'])
                ->where('available_for','user')
                ->where('type', 4)
                ->where('coupon_start_date', '<=', date('Y-m-d'))
                ->where('coupon_end_date', '>=', date('Y-m-d'))
                ->get()
        );

        $timeslot = Timeslote::get();
        
       $walletpoints = Wallet::where('user_id', Auth::id())->where('expire_on', '>=', Carbon::now())->where('action', 1)->get();
       $wallet_points = 0;
       
       foreach($walletpoints as $k=>$v){
           $wallet_points += $v->wallet_points;
           
       }


        $point = User::find(Auth::id());
        Session::put("active_menu", "");
        return view("front.checkout")->with('point', $point)->with('walletsetting', $walet)->with('coupon', $Coupon)->with("category", $category)
            ->with("popular_package", $popular_package)->with("getfamilymemenber", $getfamilymemenber)->with('new_card_data',$new_card_data)
            ->with("cartmember", $cartmember)->with("useraddress", $useraddress)->with("setting", $setting)->with("currency", $getcurrency[1])
            ->with("token", $clientToken)->with("paymentkeys", $ls)->with("city", $getcity)->with("totalcartmember", $this->gettotalcartmember())
            ->with("cartdata", $ls1)->with('timeslot', $timeslot)->with('selectedtest',$selectedtest)->with('wallet_points',$wallet_points);

    }

    public function show_update_user_family(Request $request)
    {
        if ($request->get("id") != "") {
            $store = FamilyMember::find($request->get("id"));
            // $msg = "Member Update Successfully";
            $msg = __('message.Member Update Successfully');
        } else {
            $store = new FamilyMember();
            // $msg = "Member Add Successfully";
            $msg = __('message.Member Add Successfully');
        }

        $store->name = $request->get("name");
        $store->mobile_no = $request->get("phone");
        $store->age = $request->get("age");
        $store->email = $request->get("email");
        $store->dob = $request->get("dob");
        $store->relation = $request->get("relation");
        $store->gender = $request->get("gender");
        $store->user_id = Auth::id();
        $store->save();
        Session::flash('message', $msg);
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();

    }

    public function deletememer($id)
    {
        $store = FamilyMember::find($id);
        if ($store) {
            $store->delete();
        }
        // Session::flash('message',"Member Delete Successfully"); 
        Session::flash('message', __('message.Member Delete Successfully'));
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }

    function deleteaddress($id)
    {
        $store = UserAddress::find($id);
        if ($store) {
            $store->delete();
        }
        // Session::flash('message',"Address Delete Successfully"); 
        Session::flash('message', __('message.Address Delete Successfully'));
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }
    function deletevisit($id)
    {
        $store = Homevisit::find($id);
        if ($store) {
            $store->delete();
        }
        // Session::flash('message',"Address Delete Successfully"); 
        Session::flash('message', 'Home Visit Request Delete Successfully');
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }

    public function show_getmember(Request $request)
    {
        return json_encode(FamilyMember::where("id", $request->get("id"))->where("user_id", Auth::id())->first());
    }

    public function show_post_user_address(Request $request)
    {
        if ($request->get("id") != "") {
            $store = UserAddress::find($request->get("id"));
            // $msg = "User Address Update Successfully";
            $msg = __('message.User Address Update Successfully');
        } else {
            $store = new UserAddress();
            // $msg = "User Address Add Successfully";
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
        // dd($request->get("is_default") );
        if ($request->get("is_default") == "" || $request->get("is_default") == null) {
            $store->is_default = 0;
        } else {
            $store->is_default = $request->get("is_default");
        }

        $store->address = $request->get("address");
        $store->lat = $request->get("lat");
        $store->long = $request->get("long");
        $store->save();
        if ($request->get("is_default") != "" || $request->get("is_default") != null) {
            UserAddress::where('id', '!=', $store->id)->update(['is_default' => 0]);
        }
        Session::flash('message', $msg);
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();

    }

    public function show_update_user_member(Request $request)
    {
        $store = new FamilyMember();
        $store->name = $request->get("name");
        $store->mobile_no = $request->get("phone");
        $store->age = $request->get("age");
        $store->email = $request->get("email");
        $store->dob = $request->get("dob");
        $store->relation = $request->get("relation");
        $store->gender = $request->get("gender");
        $store->user_id = Auth::id();
        $store->save();
        return $store->id;
    }

    public function show_user_logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }

    public function show_login()
    { 
        if(Auth::check()){
            return redirect()->route('home');
        }
        // Store the intended URL in the session
        Session::put("intended_url", url()->previous());

        $popular_package = Popular_package::whereNull('deleted_at')->get();
        $category = Category::where('is_deleted', '0')->get();
        $setting = Setting::find(1);
        Session::put("active_menu", "");
        return view("front.login")->with("category", $category)->with("popular_package", $popular_package)->with("setting", $setting)->with("totalcartmember", $this->gettotalcartmember());
    }

    public function show_home_visit()
    {
        $popular_package = Popular_package::whereNull('deleted_at')->get();
        $category = Category::where('is_deleted', '0')->get();
        $userLat = session()->get('latitude');
        $userLng = session()->get('longitude');
        if ($userLat == '') {
            $userLat = 26.9124;
            $userLng = 75.7873;
        }

        $city = City::select(
            '*',
            DB::raw('(6371 * acos(cos(radians(' . $userLat . ')) * cos(radians(lat)) * cos(radians(lng) - radians(' . $userLng . ')) + sin(radians(' . $userLat . ')) * sin(radians(lat)))) as distance')
        )->where('is_deleted', '0')
            ->orderBy('distance', 'asc')
            ->get();
        $setting = Setting::find(1);
        Session::put("active_menu", "45");
        return view("front.homevisit")->with('city', $city)->with("category", $category)->with("popular_package", $popular_package)->with("setting", $setting)->with("totalcartmember", $this->gettotalcartmember());
    }
    public function feedback()
    {

        $setting = Setting::first();
        Session::put("active_menu", "49");
        return view("front.feedback")->with("setting", $setting);
    }
    public function prescription()
    {
        $popular_package = Popular_package::whereNull('deleted_at')->get();
        $category = Category::where('is_deleted', '0')->get();

        $userLat = session()->get('latitude');
        $userLng = session()->get('longitude');
        if ($userLat == '') {
            $userLat = 26.9124;
            $userLng = 75.7873;
        }

        $city = City::select(
            '*',
            DB::raw('(6371 * acos(cos(radians(' . $userLat . ')) * cos(radians(lat)) * cos(radians(lng) - radians(' . $userLng . ')) + sin(radians(' . $userLat . ')) * sin(radians(lat)))) as distance')
        )->where('is_deleted', '0')
            ->orderBy('distance', 'asc')
            ->get();


        $setting = Setting::find(1);
        Session::put("active_menu", "45");
        return view("front.prescription")->with('city', $city)->with("category", $category)->with("popular_package", $popular_package)->with("setting", $setting)->with("totalcartmember", $this->gettotalcartmember());
    }
    public function show_aboutus()
    {
        $popular_package = Popular_package::whereNull('deleted_at')->get();
        $category = Category::where('is_deleted', '0')->get();
        $setting = Setting::find(1);
        $title = "About Us";
        $content = $setting->about;
        Session::put("active_menu", "2");
        return view("front.aboutus")->with('title', $title)->with('content', $content)->with("category", $category)->with("popular_package", $popular_package)->with("setting", $setting)->with("totalcartmember", $this->gettotalcartmember());
    }
    public function refund_policy()
    {
        // dd('test');
        $popular_package = Popular_package::whereNull('deleted_at')->get();
        $category = Category::where('is_deleted', '0')->get();
        $setting = Setting::find(1);
        $title = "Refund Policy";
        $content = $setting->refund_policy;
        Session::put("active_menu", "2");
        return view("front.page")->with('title', $title)->with('content', $content)->with("category", $category)->with("popular_package", $popular_package)->with("setting", $setting)->with("totalcartmember", $this->gettotalcartmember());
    }
    public function Terms_of_Service()
    {
        $popular_package = Popular_package::whereNull('deleted_at')->get();
        $category = Category::where('is_deleted', '0')->get();
        $setting = Setting::find(1);
        $title = "Terms of Service";
        $content = $setting->t_s;
        Session::put("active_menu", "2");
        return view("front.terms_of_service")->with('title', $title)->with('content', $content)->with("category", $category)->with("popular_package", $popular_package)->with("setting", $setting)->with("totalcartmember", $this->gettotalcartmember());
    }
    public function Privacy_Policy()
    {
        $popular_package = Popular_package::whereNull('deleted_at')->get();
        $category = Category::where('is_deleted', '0')->get();
        $setting = Setting::find(1);
        $title = "Privacy Policy";
        $content = $setting->privacy;
        Session::put("active_menu", "2");
        return view("front.privacy_policy")->with('title', $title)->with('content', $content)->with("category", $category)->with("popular_package", $popular_package)->with("setting", $setting)->with("totalcartmember", $this->gettotalcartmember());
    }
    public function franchise()
    {
        $popular_package = Popular_package::whereNull('deleted_at')->get();
        $category = Category::where('is_deleted', '0')->get();
        $setting = Setting::find(1);
        $title = "Franchise";
        $content = $setting->franchise;
        Session::put("active_menu", "2");
        return view("front.page")->with('title', $title)->with('content', $content)->with("category", $category)->with("popular_package", $popular_package)->with("setting", $setting)->with("totalcartmember", $this->gettotalcartmember());
    }
    public function show_forgotpassword()
    {
        $popular_package = Popular_package::whereNull('deleted_at')->get();
        $category = Category::where('is_deleted', '0')->get();
        $setting = Setting::find(1);
        Session::put("active_menu", "2");
        return view("front.forgotpassword")->with("category", $category)->with("popular_package", $popular_package)->with("setting", $setting)->with("totalcartmember", $this->gettotalcartmember());
    }

    public function post_forgotpassword(Request $request)
    {
        $getuser = User::where("email", $request->get("email"))->where("user_type", '3')->first();
        if ($getuser) {
            $code = mt_rand(100000, 999999);
            $store = array();
            $store['email'] = $getuser->email;
            $store['name'] = $getuser->name;
            $store['code'] = $code;
            $reset = new Resetpassword();
            $reset->code = $code;
            $reset->user_id = Auth::id();
            $reset->save();
            try {
                Mail::send('email.forgotpassword', ['user' => $store], function ($message) use ($store) {
                    $message->to($store['email'], $store['name'])->subject(__("message.site_name"));
                });
            } catch (\Exception $e) {
            }
            // Session::flash('message',"Mail Send Successfully");
            Session::flash('message', __('message.Mail Send Successfully'));
            Session::flash('alert-class', 'alert-success');
            return redirect()->back();
        } else {
            // Session::flash('message',"Email id match with our system");
            Session::flash('message', __('message.Email id match with our system'));
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }

    }

    public function resetpassword($code)
    {
        $setting = Setting::find(1);
        $popular_package = Popular_package::whereNull('deleted_at')->get();
        $category = Category::where('is_deleted', '0')->get();
        $setting = Setting::find(1);
        $data = Resetpassword::where("code", $code)->first();
        if ($data) {
            return view('front.resetpwd')->with("id", $data->user_id)->with("code", $code)->with("type", $data->type)->with("category", $category)->with("popular_package", $popular_package)->with("setting", $setting)->with("totalcartmember", $this->gettotalcartmember());
        } else {
            return view('front.resetpwd')->with("msg", __('message.Code Expired'))->with("setting", $setting)->with("category", $category)->with("popular_package", $popular_package)->with("totalcartmember", $this->gettotalcartmember());
        }
    }

    public function resetnewpwd(Request $request)
    {
        $setting = Setting::find(1);
        $popular_package = Popular_package::whereNull('deleted_at')->get();
        $category = Category::where('is_deleted', '0')->get();
        if ($request->get('id') == "") {
            return view('front.resetpwd')->with("msg", __('message.pwd_reset'))->with("setting", $setting)->with("category", $category)->with("popular_package", $popular_package)->with("totalcartmember", $this->gettotalcartmember());
        } else {
            if ($request->get("type") == 1) {
                $user = Patient::find($request->get('id'));
            } else {
                $user = Doctors::find($request->get('id'));
            }
            $user->password = $request->get('npwd');
            $user->save();
            $codedel = Resetpassword::where('user_id', $request->get("id"))->delete();
            return view('front.resetpwd')->with("msg", __('message.pwd_reset'))->with("setting", $setting)->with("category", $category)->with("popular_package", $popular_package)->with("totalcartmember", $this->gettotalcartmember());
        }
    }

    public function show_service()
    {
        $popular_package = Popular_package::whereNull('deleted_at')->get();
        $category = Category::where('is_deleted', '0')->get();
        $setting = Setting::find(1);
        Session::put("active_menu", "3");
        $data_feedback = Feedback::with('userdata')->orderby('id', 'DESC')->get();
        // dd($data_feedback);
        return view("front.service")->with("category", $category)->with("popular_package", $popular_package)->with("setting", $setting)->with("data_feedback", $data_feedback)->with("totalcartmember", $this->gettotalcartmember());
    }

    public function show_contactus()
    {
        $popular_package = Popular_package::whereNull('deleted_at')->get();
        $category = Category::where('is_deleted', '0')->get();
        $setting = Setting::find(1);
        Session::put("active_menu", "6");
        return view("front.contactus")->with("category", $category)->with("popular_package", $popular_package)->with("setting", $setting)->with("totalcartmember", $this->gettotalcartmember());
    }

    public function show_register()
    {
        if (Auth::id()) {
            return redirect()->route('dashboard');
        }
        // Registration is only reachable with an OTP-verified mobile number.
        if (!session()->has('otp_verified_phone') || time() > (int) session('otp_verified_expires_at')) {
            session()->forget(['otp_verified_phone', 'otp_verified_expires_at']);
            Session::flash('message', 'Please verify your mobile number with an OTP to create an account.');
            Session::flash('alert-class', 'alert-info');
            return redirect()->route('user-login');
        }
        $popular_package = Popular_package::whereNull('deleted_at')->get();
        $category = Category::where('is_deleted', '0')->get();
        $setting = Setting::find(1);
        Session::put("active_menu", "");
        return view("front.register")->with("category", $category)->with("popular_package", $popular_package)->with("setting", $setting)->with("totalcartmember", $this->gettotalcartmember());
    }

    public function show_changepassword()
    {
        $popular_package = Popular_package::whereNull('deleted_at')->get();
        $category = Category::where('is_deleted', '0')->get();
        $setting = Setting::find(1);
        return view("front.changepassword")->with("category", $category)->with("popular_package", $popular_package)->with("setting", $setting)->with("totalcartmember", $this->gettotalcartmember());
    }

    public function update_change_password(Request $request)
    {
        $store = User::find(Auth::id());
        $store->password = $request->get("npassword");
        $store->save();
        Session::flash('message', __('message.Password Update Successfully'));
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }

    public function show_user_profile()
    {
        $popular_package = Popular_package::whereNull('deleted_at')->get();
        $category = Category::where('is_deleted', '0')->get();
        $setting = Setting::find(1);
        return view("front.myprofile")->with("category", $category)->with("popular_package", $popular_package)->with("setting", $setting)->with("totalcartmember", $this->gettotalcartmember());
    }

    public function show_my_addresses()
    {
        $popular_package = Popular_package::whereNull('deleted_at')->get();
        $category = Category::where('is_deleted', '0')->get();
        $setting = Setting::find(1);
        $city = City::where("is_deleted", '0')->get();
        $myaddresses = UserAddress::where("user_id", Auth::id())->whereNull('deleted_at')->get();
      
        return view("front.myaddresses")->with("category", $category)->with("popular_package", $popular_package)->with("setting", $setting)->with("myaddresses", $myaddresses)->with("city", $city)->with("totalcartmember", $this->gettotalcartmember());
    }
    public function my_home()
    {
        $popular_package = Popular_package::whereNull('deleted_at')->get();
        $category = Category::where('is_deleted', '0')->get();
        $setting = Setting::find(1);
        $city = City::where("is_deleted", '0')->get();
        $myaddresses = Homevisit::with('citydata', 'lab')->where("user_id", Auth::id())->get();
        return view("front.myhome")->with("category", $category)->with("popular_package", $popular_package)
        ->with("setting", $setting)->with("myaddresses", $myaddresses)->with("city", $city)->with("totalcartmember", $this->gettotalcartmember());
    }
    public function my_prescription()
    {
        $popular_package = Popular_package::whereNull('deleted_at')->get();
        $category = Category::where('is_deleted', '0')->get();
        $setting = Setting::find(1);
        $city = City::where("is_deleted", '0')->get();
        $myaddresses = Userprescription::with('location')->where("user_id", Auth::id())->get();
        // dd($myaddresses);
        return view("front.myprescription")->with("category", $category)->with("popular_package", $popular_package)->with("setting", $setting)->with("myaddresses", $myaddresses)->with("city", $city)->with("totalcartmember", $this->gettotalcartmember());
    }


    public function show_my_family_member()
    {
        $popular_package = Popular_package::whereNull('deleted_at')->get();
        $category = Category::where('is_deleted', '0')->get();
        $setting = Setting::find(1);
        $myfamily = FamilyMember::where("user_id", Auth::id())->whereNull('deleted_at')->get();
        return view("front.my_family_member")->with("category", $category)->with("popular_package", $popular_package)->with("setting", $setting)->with("myfamily", $myfamily)->with("totalcartmember", $this->gettotalcartmember());
    }

    public function show_update_profile_info(Request $request)
    {
        $getusers = User::where("email", $request->get("name"))->where("id", "!=", Auth::id())->first();

        if ($getusers) {
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
        $store = User::find(Auth::id());
        $store->name = $request->get("name");
        $store->email = $request->get("email");
        if ($request->file("upload_image")) {
            if (Auth::user()->profile_pic != "") {
                $this->removeImage('profile/' . $store->profile_pic);
            }
            $store->profile_pic = $this->fileuploadFileImage($request, 'profile', 'upload_image');
        }
        $store->save();

        Session::flash('message', __('message.Profile Update Successfully'));
        Session::flash('alert-class', 'alert-success');
        return redirect('user_profile');
    }

    public function show_dashboard(Request $request)
    {
        $popular_package = Popular_package::whereNull('deleted_at')->get();
        $point = User::find(Auth::id());
        $credit_walletpoints = Wallet::where('user_id', Auth::id())->where('expire_on', '>=', Carbon::now())->where('action', 1)->get();
        $credit_wallet_points = 0;
        
        foreach($credit_walletpoints as $k=>$v){
             $credit_wallet_points += $v->wallet_points;

       }
        $debit_walletpoints = Wallet::where('user_id', Auth::id())->where('action', 0)->get();
        $debit_wallet_points = 0;
        
        foreach($debit_walletpoints as $k=>$v){
             $debit_wallet_points += $v->wallet_points;

       }
       
       $wallet_points =  $credit_wallet_points - $debit_wallet_points;
        $category = Category::where('is_deleted', '0')->get();
        $setting = Setting::find(1);
        $totalorders = count(Orders::where("user_id", Auth::id())->get());
        $pendingorders = count(Orders::where("user_id", Auth::id())->whereIn("status", array(2, 6, 5))->get());
        $completeorders = count(Orders::where("user_id", Auth::id())->where("status", '7')->get());
        if ($request->get("type") == 'past') {
            $type = 1;
            $data = Orders::with("partiallyreports", "sampleboyDetails")->where("user_id", Auth::id())->where("date", "<", date('Y-m-d'))->get();
        } else if ($request->get("type") == 'upcomming') {
            $type = 2;
            $data = Orders::with("partiallyreports", "sampleboyDetails")->where("user_id", Auth::id())->where("date", ">", date('Y-m-d'))->get();
        } else {
            $type = 3;
            $data = Orders::with("partiallyreports", "sampleboyDetails")->where("user_id", Auth::id())->where("date", date('Y-m-d'))->get();
        }
        foreach ($data as $d) {
            $d->is_feedback = Feedback::where("order_id", $d->id)->first() ? 1 : 0;
        }
        return view("front.dashboard")->with('point', $point)->with('wallet_points',$wallet_points)->with("category", $category)->with("popular_package", $popular_package)
            ->with("setting", $setting)->with("totalorders", $totalorders)->with("pendingorders", $pendingorders)->with("completeorders", $completeorders)->with("data", $data)->with("type", $type)->with("totalcartmember", $this->gettotalcartmember());
    }
    public function numberToWords($number) {
        $hyphen      = '-';
        $conjunction = ' and ';
        $separator   = ', ';
        $negative    = 'negative ';
        $decimal     = ' point ';
        $dictionary  = [
            0 => 'zero',
            1 => 'one',
            2 => 'two',
            3 => 'three',
            4 => 'four',
            5 => 'five',
            6 => 'six',
            7 => 'seven',
            8 => 'eight',
            9 => 'nine',
            10 => 'ten',
            11 => 'eleven',
            12 => 'twelve',
            13 => 'thirteen',
            14 => 'fourteen',
            15 => 'fifteen',
            16 => 'sixteen',
            17 => 'seventeen',
            18 => 'eighteen',
            19 => 'nineteen',
            20 => 'twenty',
            30 => 'thirty',
            40 => 'forty',
            50 => 'fifty',
            60 => 'sixty',
            70 => 'seventy',
            80 => 'eighty',
            90 => 'ninety',
            100 => 'hundred',
            1000 => 'thousand',
            1000000 => 'million',
            1000000000 => 'billion'
        ];
    
        if (!is_numeric($number)) {
            return false;
        }
    
        if ($number < 0) {
            return $negative . $this->numberToWords(abs($number));
        }
    
        $string = '';
    
        if ($number < 21) {
            $string = $dictionary[$number];
        } elseif ($number < 100) {
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
        } elseif ($number < 1000) {
            $hundreds  = (int) ($number / 100);
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' hundred';
            if ($remainder) {
                $string .= $conjunction . $this->numberToWords($remainder);
            }
        } else {
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = $this->numberToWords($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .=$this->numberToWords($remainder);
            }
        }
    
        return $string;
    }

    public function show_printorder(Request $request)
    {
        $data = Orders::with('useraddressdetails', 'partiallyreports','franchise')->where("user_id", Auth::id())->where("id", $request->get("id"))->first();
        if ($data) {
            $numberToWords = $this->numberToWords($data->final_total);
            $data->final_total_word = $numberToWords;
            $data->orderdata = OrdersData::with("memberdetails")->where("order_id", $request->get("id"))->get();
            $popular_package = Popular_package::whereNull('deleted_at')->get();
            $category = Category::where('is_deleted', '0')->get();
            $setting = Setting::find(1);
            $getcurrency = explode("-", $setting->currency);
            return view("front.print")->with("category", $category)->with("popular_package", $popular_package)->with("setting", $setting)->with("data", $data)->with("currency", $getcurrency[1]);
        }
        Session::flash('message', "Data Not Found");
        Session::flash('alert-class', 'alert-danger');
        return redirect()->back();

    }

    public function show_admin_printorder($id)
    {
        $data = Orders::with('useraddressdetails','customer')->where("id", $id)->first();
        
        if ($data) {

            $setting = Setting::find(1);
            $data->orderdata = OrdersData::with("memberdetails")->where("order_id", $id)->get();
            $popular_package = Popular_package::whereNull('deleted_at')->get();
            $category = Category::where('is_deleted', '0')->get();
            $setting = Setting::find(1);
            $getcurrency = explode("-", $setting->currency);
            return view("front.print")->with("category", $category)->with("popular_package", $popular_package)->with("setting", $setting)->with("data", $data)->with("currency", $getcurrency[1]);
            $msg = __('message.Order Is Complete');
            $this->send_notification_order_android($setting->android_server_key, $data->user_id, $msg, $data->id);
            $this->send_notification_order_android($setting->ios_server_key, $data->user_id, $msg, $data->id);

        }
        // Session::flash('message',"Data Not Found");
        Session::flash('message', __('message.Data Not Found'));
        Session::flash('alert-class', 'alert-danger');
        return redirect()->back();
    }

    public function show_appointmentbook($id)
    {
        $popular_package = Popular_package::whereNull('deleted_at')->get();
        $category = Category::where('is_deleted', '0')->get();
        $setting = Setting::find(1);
        return view("front.appointment_details")->with("category", $category)->with("popular_package", $popular_package)->with("setting", $setting)->with("totalcartmember", $this->gettotalcartmember());
    }
    public function otp_verify(Request $request)
    {

        $otp = trim((string) $request->input('otp'));
        $phone = (string) $request->input('phone');

        if ($otp === '' || $phone === '') {
            return response()->json(['success' => false, 'msg' => 'Please enter the OTP.']);
        }

        // Throttle verification attempts per phone + IP.
        $verifyKey = 'otp-verify:' . $phone . '|' . $request->ip();
        if (RateLimiter::tooManyAttempts($verifyKey, (int) config('auth.otp.max_verifies_per_10min', 10))) {
            return response()->json(['success' => false, 'msg' => 'Too many attempts. Please try again after some time.']);
        }
        RateLimiter::hit($verifyKey, 600);

        // ---- Login-flow OTP (hashed, single-use, expiring; stored in session) ----
        if (session('login_otp_phone') === $phone && session()->has('login_otp')) {

            if (time() > (int) session('login_otp_expires_at')) {
                $this->forget_login_otp();
                return response()->json(['success' => false, 'msg' => 'This OTP has expired. Please request a new one.']);
            }

            $attempts = (int) session('login_otp_attempts') + 1;
            session(['login_otp_attempts' => $attempts]);
            if ($attempts > (int) config('auth.otp.max_verify_attempts', 5)) {
                $this->forget_login_otp();
                return response()->json(['success' => false, 'msg' => 'Too many wrong attempts. Please request a new OTP.']);
            }

            if (Hash::check($otp, session('login_otp'))) {
                // Single use: the OTP is gone the moment it verifies.
                $this->forget_login_otp();
                RateLimiter::clear($verifyKey);

                $checkuser = User::where("phone", $phone)->where("user_type", '3')->first();

                if ($checkuser && $checkuser->name) {
                    // Invalidate any stale OTP the legacy flow left on the row,
                    // so it cannot be replayed through the DB path below.
                    if ($checkuser->otp !== null) {
                        $checkuser->otp = null;
                        $checkuser->save();
                    }
                    $intendedUrl = Session::get('intended_url');
                    session()->forget('intended_url');
                    Auth::login($checkuser, true);
                    return response()->json(['success' => true, 'intended_url' => $intendedUrl]);
                }

                // Unknown number (or a checkout shell account without a profile):
                // hand over to registration with the verified phone pre-filled.
                session([
                    'otp_verified_phone' => $phone,
                    'otp_verified_expires_at' => time() + ((int) config('auth.otp.register_window_minutes', 30) * 60),
                ]);
                return response()->json(['success' => true, 'register' => true, 'redirect' => route('user-register')]);
            }

            // Wrong code for the login flow — fall through so a parallel
            // checkout-flow OTP (stored on the user row) can still verify.
        }

        // ---- Existing checkout / report-login OTP path ----
        $checkuser = User::where("phone", $phone)->where("otp", $otp)->first();
        if ($checkuser) {

        // Single use: consume the OTP so it cannot be replayed.
        $checkuser->otp = null;
        $checkuser->save();

        $intendedUrl = Session::get('intended_url');
        session()->forget('intended_url');
            Auth::login($checkuser, true);
             if (!$checkuser->name) {
                        return response()->json(['success' => true, 'new_user' => true]);
                    }
            return response()->json(['success' => true, 'intended_url' => $intendedUrl]);


        } else {
            return response()->json(['success' => false]);
        }
    }
    public function save_user_details(Request $request)
    {
        $user = Auth::user();
        
        if ($user) {
            $user->name = $request->input('name');
            $user->d_o_b = $request->input('dob');
            $user->sex = $request->input('gender');
            $user->age = $request->input('age');
            $user->save();
            
            $storeFamily = new FamilyMember();
            $storeFamily->name = $user->name;
            $storeFamily->mobile_no = $user->phone;
            $storeFamily->age =$user->age;
            // $storeFamily->email = $request->get("email");
            $storeFamily->dob = $user->d_o_b;
            $storeFamily->relation = 'Self';
            $storeFamily->gender = $user->sex;
            $storeFamily->user_id = $user->id;
            $storeFamily->save();
            
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'msg' => 'User not found.']);
        }
    }

    public function job_otp_verify(Request $request)
    {

        $otp = $request->input('otp');
        $id = $request->input('id');
        $checkuser = Application::where("id", $id)->where("otp", $otp)->first();
        if ($checkuser) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
    public function appId($id)
    {

        $data = Application::find($id);
        $setting = Setting::find(1);
        return view("front.application-form")->with("data", $data)->with("setting", $setting);

    }
    public function applyjob_otp(Request $request)
    {

        $checkuser = Application::where("number", $request->mobile)->where('v_id', $request->v_id)->first();
        if (!$checkuser) {
            $checkuser = new Application;
            $checkuser->number = $request->mobile;
            $checkuser->v_id = $request->v_id;
            $checkuser->save();
        }
        $url = 'http://103.10.234.154/vendorsms/pushsms.aspx';
        $user = 'Healthwave';
        $password = 'XVGY7XU1';
        $msisdn = $request->mobile;
        $sid = 'RDCPLR';
        $otp = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        $checkuser->otp = $otp;
        $checkuser->save();
        $msg = 'Your OTP to login is ' . $otp . ' Please do not share it with anyone. Team Reliable Diagnostics';
        $fl = '0';
        $gwid = '2';

        $response = Http::get($url, [
            'user' => $user,
            'password' => $password,
            'msisdn' => $msisdn,
            'sid' => $sid,
            'msg' => $msg,
            'fl' => $fl,
            'gwid' => $gwid,
        ]);

        if ($response->successful()) {
            $setting = Setting::find(1);
            Session::put("active_menu", "");

            Session::flash('message', 'OTP send to your mobile number.');
            Session::flash('alert-class', 'alert-success');
            return view("front.job-otp")->with('data', $checkuser)->with("setting", $setting);

        } else {
            Session::flash('message', 'OTP sending failed! Please try again.');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
    }
    // public function otpsend(Request $request)
    // {
    //     $checkuser = User::where("phone", $request->get("phone"))->where("user_type", '3')->first();
    //     if ($checkuser) {
    //         $url = 'https://msg.smsguruonline.com/fe/api/v1/send?';
    //         $user = 'Healthwave';
    //         $password = 'XVGY7XU1';
    //         $msisdn = $request->get("phone");
    //         $sid = 'RDCPLR';
    //         $otp = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

    //         if($msisdn == 6367289664){
    //             $otp = 1234;
    //         }
    //         $checkuser->otp = $otp;
            
    //         $checkuser->save();
    //         $msg = 'Your OTP to login is ' . $otp . ' Please do not share it with anyone. Team Reliable Diagnostics';
    //         $fl = '0';
    //         $gwid = '2';
    //         $response = Http::get($url, [
    //             'username' => 'reliablediagnostic.trans',
    //             'password' => 'HJdUk',
    //             'to' => $msisdn,
    //             'from' => 'RDCPLR',
    //             'text' => $msg,
    //             'dltPrincipalEntityId' => 1701164077392632789,
    //             'dltContentId' => 1707172500285213469,
    //             'unicode' => false  // corrected this line
    //         ]);
            
    //     }
    //     if ($response) {
    //         return response()->json(['success' => true, 'msg' => 'otp send successfuly!']);
    //     } else {
    //         return response()->json(['success' => false,'msg'=>'fail']);
    //     }
    // }
    public function otpsend(Request $request)
    {
        $phone = $request->get("phone");
        // Check if the user exists
        $checkuser = User::where("phone", $phone)->where("user_type", '3')->first();
    
        if (!$checkuser) {
            // Create a new user
            $checkuser = new User();
            $checkuser->phone = $phone;
            $checkuser->password='kdjgdhijjwyefijqwer9e2933492';
            $checkuser->user_type = '3'; // Assuming '3' is the default user type
            $checkuser->otp = null; // Will be updated below
            $checkuser->save();
        }
    
        // Generate OTP
        $otp = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        // if ($phone == "6367289664") {
            $otp = "1234";
        // }
    
        // Save OTP
        $checkuser->otp = $otp;
        $checkuser->save();
    
        // Send OTP via SMS API
        // $msg = 'Your OTP to login is ' . $otp . ' Please do not share it with anyone. Team Reliable Diagnostics';
        // $response = Http::get('https://msg.smsguruonline.com/fe/api/v1/send', [
        //     'username' => 'reliablediagnostic.trans',
        //     'password' => 'HJdUk',
        //     'to' => $phone,
        //     'from' => 'RDCPLR',
        //     'text' => $msg,
        //     'dltPrincipalEntityId' => 1701164077392632789,
        //     'dltContentId' => 1707172500285213469,
        //     'unicode' => false
        // ]);
    
        // if ($response) {
            return response()->json(['success' => true, 'msg' => 'OTP sent successfully!', 'new_user' => !$checkuser->name]);
        // } else {
        //     return response()->json(['success' => false, 'msg' => 'Failed to send OTP.']);
        // }
    }

    
    /**
     * Generates a login OTP for the given phone, stores it hashed in the
     * session (single-use, expiring) and sends it through the existing SMS
     * gateway. Returns ['success' => bool, 'msg' => string].
     */
    private function send_login_otp($phone)
    {
        $resendSeconds = (int) config('auth.otp.resend_seconds', 45);
        $maxSends = (int) config('auth.otp.max_sends_per_10min', 5);

        // Resend cool-down for this session
        $lastSent = session('login_otp_sent_at');
        if ($lastSent && (time() - (int) $lastSent) < $resendSeconds) {
            $wait = $resendSeconds - (time() - (int) $lastSent);
            return ['success' => false, 'msg' => 'Please wait ' . $wait . ' seconds before requesting a new OTP.'];
        }

        // Hard limit per phone + IP
        $sendKey = 'otp-send:' . $phone . '|' . request()->ip();
        if (RateLimiter::tooManyAttempts($sendKey, $maxSends)) {
            return ['success' => false, 'msg' => 'Too many OTP requests. Please try again after some time.'];
        }
        RateLimiter::hit($sendKey, 600);

        $otp = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

        $smsOk = true;
        if ($phone == '6367289664') {
            // Existing internal test number keeps its fixed OTP and skips the gateway.
            $otp = '1234';
        } else {
            $msg = 'Your OTP for 369 HealthDex login is ' . $otp . ' Do not share this code with anyone. Team 369 HealthDex.';
            $response = Http::get('https://msg.smsguruonline.com/fe/api/v1/send?', [
                'username' => '369healthdex.trans',
                'password' => 'DBLD2',
                'to' => $phone,
                'from' => 'HLTHDX',
                'text' => $msg,
                'dltPrincipalEntityId' => 1701176959781053032,
                'dltContentId' => 1707176967358120748,
                'unicode' => false
            ]);
            $smsOk = $response->successful();
        }

        if (!$smsOk) {
            return ['success' => false, 'msg' => 'OTP sending failed! Please try again.'];
        }

        session([
            'login_otp' => Hash::make($otp),
            'login_otp_phone' => (string) $phone,
            'login_otp_expires_at' => time() + ((int) config('auth.otp.expiry_minutes', 5) * 60),
            'login_otp_attempts' => 0,
            'login_otp_sent_at' => time(),
        ]);

        return ['success' => true, 'msg' => 'OTP send to your mobile number.'];
    }

    private function forget_login_otp()
    {
        session()->forget(['login_otp', 'login_otp_phone', 'login_otp_expires_at', 'login_otp_attempts']);
    }

    public function post_user_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|digits_between:8,15',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $msisdn = (string) $request->get("phone");

        // The OTP is sent to any number: existing users log straight in after
        // verification, unknown numbers continue to registration.
        $result = $this->send_login_otp($msisdn);

        if ($result['success']) {
            $popular_package = Popular_package::whereNull('deleted_at')->get();
            $category = Category::where('is_deleted', '0')->get();

            $setting = Setting::find(1);
            Session::put("active_menu", "");

            Session::flash('message', $result['msg']);
            Session::flash('alert-class', 'alert-success');
            return view("front.otp")->with('phone', $msisdn)->with("category", $category)->with("popular_package", $popular_package)->with("setting", $setting)->with("totalcartmember", $this->gettotalcartmember());
        }

        Session::flash('message', $result['msg']);
        Session::flash('alert-class', 'alert-danger');
        return redirect()->back()->withInput();
    }

    /**
     * AJAX endpoint used by the OTP page's "Resend OTP" link. Only resends
     * to the phone number the current session already requested an OTP for.
     */
    public function resend_login_otp(Request $request)
    {
        $phone = (string) $request->get('phone');
        if ($phone === '' || session('login_otp_phone') !== $phone) {
            return response()->json(['success' => false, 'msg' => 'Session expired. Please start again from the login page.']);
        }
        $result = $this->send_login_otp($phone);
        return response()->json($result);
    }

    public function post_user_register(Request $request)
    {
        $setting = Setting::find(1);

        // The mobile number must have been OTP-verified in this session, and
        // the submitted value must match it (the field is read-only in the UI,
        // but the session is the source of truth).
        $verifiedPhone = (string) session('otp_verified_phone', '');
        if ($verifiedPhone === '' || time() > (int) session('otp_verified_expires_at')) {
            session()->forget(['otp_verified_phone', 'otp_verified_expires_at']);
            Session::flash('message', 'Your verification expired. Please verify your mobile number again.');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('user-login');
        }

        $request->merge(['phone' => $verifiedPhone]);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'required|digits_between:8,15',
            'd_o_b' => 'required|date|before:tomorrow',
            'age' => 'nullable|integer|min:0|max:130',
            'sex' => 'required|in:Male,Female',
        ]);

        $validator->after(function ($validator) use ($request, $verifiedPhone) {
            $emailTaken = User::where("email", $request->get("email"))
                ->where("user_type", '3')
                ->whereNotNull('name')
                ->first();
            if ($emailTaken) {
                $validator->errors()->add('email', 'This email is already registered.');
            }

            // A phone row with a completed profile means the account exists.
            // A row without a name is a checkout "shell" and gets claimed below.
            $phoneTaken = User::where("phone", $verifiedPhone)
                ->where("user_type", '3')
                ->whereNotNull('name')
                ->first();
            if ($phoneTaken) {
                $validator->errors()->add('phone', 'This mobile number is already registered. Please login instead.');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Claim an OTP shell account created by the checkout flow, if any.
        $store = User::where("phone", $verifiedPhone)
            ->where("user_type", '3')
            ->whereNull('name')
            ->first();
        $isNewUser = !$store;
        if ($isNewUser) {
            $store = new User();
            $store->phone = $verifiedPhone;
            $store->user_type = '3';
        }

        $store->name = $request->get("name");
        $store->email = $request->get("email");
        $store->d_o_b = $request->get("d_o_b");
        $store->age = $request->get("age");
        $store->sex = $request->get("sex");
        // OTP-only authentication: no password is collected. A random hash
        // keeps the column filled and unusable for guessing.
        $store->password = Hash::make(Str::random(40));
        if ($isNewUser || !$store->wallet_amount) {
            $store->wallet_amount = $setting->wallet_point_on_register;
        }
        $store->save();

        $hasSelf = FamilyMember::where('user_id', $store->id)->where('relation', 'Self')->first();
        if (!$hasSelf) {
            $storeFamily = new FamilyMember();
            $storeFamily->name = $request->get("name");
            $storeFamily->mobile_no = $verifiedPhone;
            $storeFamily->age = $request->get("age");
            $storeFamily->email = $request->get("email");
            $storeFamily->dob = $request->get("d_o_b");
            $storeFamily->relation = 'Self';
            $storeFamily->gender = $request->get("sex");
            $storeFamily->user_id = $store->id;
            $storeFamily->save();
        }

        $hasRegisterWallet = Wallet::where('user_id', $store->id)->where('order_id', 0)->where('action', 1)->first();
        if (!$hasRegisterWallet) {
            $wallet_data = new Wallet();
            $wallet_data->user_id  =  $store->id;
            $wallet_data->wallet_points  =  $setting->wallet_point_on_register;
            $wallet_data->order_id  =  0  ;
            $wallet_data->action  =  1;
            $wallet_data->expire_on  =  date('Y-m-d', strtotime('+1 year'));
            $wallet_data->save();
        }

        // Verified phone is consumed; log the new user straight in.
        session()->forget(['otp_verified_phone', 'otp_verified_expires_at']);
        Auth::login($store, true);

        $intendedUrl = Session::get('intended_url');
        session()->forget('intended_url');

        Session::flash('message', __('message.Your Profile Register Successfully'));
        Session::flash('alert-class', 'alert-success');
        return $intendedUrl ? redirect($intendedUrl) : redirect()->route('dashboard');
    }
    public function get_selected_city_other_labs($city)
    {
        $cityData = City::where('slug', $city)->first();
        if(isset($cityData->lat)){
            $latitude = (float) $cityData->lat;
            $longitude = (float) $cityData->lng;
            $labs = User::with('location')
                ->join('city as user_city', 'users.city', '=', 'user_city.id')
                ->select('users.*', 'user_city.lat', 'user_city.lng',
                DB::raw("(6371 * acos(cos(radians($latitude)) * cos(radians(user_city.lat)) * cos(radians(user_city.lng) - radians($longitude)) + sin(radians($latitude)) * sin(radians(user_city.lat)))) AS distance"))
                ->where('users.user_type', 2)
                ->whereBetween('user_city.lat', [$latitude - 0.1, $latitude + 0.1])
                ->whereBetween('user_city.lng', [$longitude - 0.1, $longitude + 0.1])
                ->orderBy('distance')
                ->get();
           
            return $labs;
        }
        return;
    }
    
    public function show_package_detail($city, $slug)
    {
        $this->change_city($city);
        
        $labs = $this->get_selected_city_other_labs($city);
        $defaultcityID = $this->getdefaultcityid(session()->get('cityName'));
        $data = Package::join('package_branch', 'packages.id', '=', 'package_branch.package_id')
                   ->whereIn('package_branch.branch_id', [$defaultcityID])
                   ->select('packages.*','package_branch.mrp','package_branch.price')
                   ->where('packages.slug', $slug)->first();
        
        Session::put("active_menu", "");
        if ($data) {
            $subIds = explode(',', $data->category_id);
            $id = $data->id;
            $dis_pa = $this->get_discount($data->id,'Package',$data->mrp);
            $data->discount = $dis_pa;
            $data->package_frq = Package_FRQ::where("package_id", $id)->where("type", '1')->get();
            $data->testdetails = TestDetails::where("package_id", $id)->get();
            $profiles_list = Profiles::whereNull('deleted_at')->get();
            $parameter_list = Parameter::whereNull('deleted_at')->get();
            $find_pa = TestDetails::where("package_id", $id)->get();
            $parameter = 0;
            $mrp =0;
            foreach ($find_pa as $d) {
                if ($d->type == 1) {
                    $parameter = $parameter + 1;
                    $mrp += Parameter::find($d->type_id) ? Parameter::find($d->type_id)->mrp : 0;
                }
                if ($d->type == 2) {
                    $a = Profiles::find($d->type_id);
                    if ($a) {
                        $arr = explode(",", $a->no_of_parameter);
                        $parameter = $parameter + count($arr);
                        foreach($arr as $l){
                            $mrp += Parameter::find($l) ? Parameter::find($l)->mrp : 0;
                        }
                    }
                }
            }
            $data->parameter = $parameter;
            // echo $parameter;exit;
            $arr = array();
            if ($data->realted_package != "") {
                $arr = explode(",", $data->realted_package);
            } else {
                $rel = Package::whereNull('deleted_at')->where("id", "!=", $slug)->get();
                foreach ($rel as $r) {
                    $arr[] = $r->id;
                }
            }

            $list_related = array();
            foreach ($arr as $a) {
                $ls = Package::find($a);
    
                if ($ls) {
                    $find_pa = TestDetails::where("package_id", $a)->get();
                    $parameter = 0;
                    $b = array();
                   
                    foreach ($find_pa as $d) {
                        $p_data=[];
                        if ($d->type == 1) {
                            $p_data['name'] = Parameter::find($d->type_id) ? Parameter::find($d->type_id)->name : '';
                            
                            $parameter = $parameter + 1;
                        }
                        if ($d->type == 2) {
                            $a = Profiles::find($d->type_id);
                            $p_data['name'] = Profiles::find($d->type_id) ? Profiles::find($d->type_id)->profile_name : '';

                            if ($a) {
                                $arr = explode(",", $a->no_of_parameter);
                                $p_data['count'] = count($arr);
                                // foreach ($arr as $l) {
                                //     // $b[] = Parameter::find($l) ? Parameter::find($l)->name : '';
                                    
                                // }
                                 $parameter = $parameter + count($arr);
                            }
                        }
                        $b[]=$p_data;
                    }
                    
                    $ls->paramater_data = $b;
                    $ls->parameter = $parameter;
                    $list_related[] = $ls;
                }


            }
            $data->realted_package = $list_related;

            $category = Subcategory::whereIn('id', $subIds)->where('is_deleted', '0')->get();
            //   dd($category);
            $popular_package = Popular_package::whereNull('deleted_at')->get();
            $setting = Setting::find(1);
            $package_list = Package::where("category_id", $data->category_id)->whereNull('deleted_at')->get();
            $reviewlist = Review::with('userdata')->where("type", '1')->where("type_id", $id)->get();
            $data->total_review = count(Review::where("type", '1')->where("type_id", $id)->get());
            $data->avg_review = Review::where("type", '1')->where("type_id", $id)->avg('ratting');

            $member_list = FamilyMember::where("user_id", Auth::id())->whereNull("deleted_at")->get();
            return view("front.package_detail")->with('labs', $labs)->with("category", $category)->with("data", $data)->with("package_list", $package_list)
            ->with("popular_package", $popular_package)->with("profiles_list", $profiles_list)->with("parameter_list", $parameter_list)
            ->with("setting", $setting)->with("reviewlist", $reviewlist)->with("member_list", $member_list)->with("totalcartmember", $this->gettotalcartmember());

        } else {
            return redirect()->back();
        }
    }

    public function show_parameter_detail($city, $slug)
    {
        $this->change_city($city);
        $labs = $this->get_selected_city_other_labs($city);
        Session::put("active_menu", "");
        $defaultcityID = $this->getdefaultcityid(session()->get('cityName'));
        $data = Parameter::join('parameter_branch', 'parameters.id', '=', 'parameter_branch.parameter_id')
                        ->whereIn('parameter_branch.branch_id', [$defaultcityID])
                        ->whereNull('parameters.deleted_at')
                        ->select('parameters.*','parameter_branch.mrp','parameter_branch.price')->where('parameters.slug', $slug)->first();
                        
        if ($data) {
            $id = $data->id;
            $dis_pa = $this->get_discount($data->id,'Parameter',$data->mrp);
            $data->discount = $dis_pa;
            $data->package_frq = Package_FRQ::where("package_id", $id)->where("type", '2')->get();
            $category = Category::where('is_deleted', '0')->get();
            $popular_package = Popular_package::whereNull('deleted_at')->get();
            $setting = Setting::find(1);
            $package_list = Package::where("category_id", $id)->whereNull('deleted_at')->get();
            $reviewlist = Review::with('userdata')->where("type", '2')->where("type_id", $id)->get();
            
            $data->total_review = count(Review::where("type", '2')->where("type_id", $id)->get());
            $member_list = FamilyMember::where("user_id", Auth::id())->whereNull("deleted_at")->get();
            // dd($data); 
            return view("front.parameter_detail")->with('labs', $labs)->with("category", $category)->with("data", $data)->with("package_list", $package_list)->with("popular_package", $popular_package)->with("setting", $setting)->with("reviewlist", $reviewlist)->with("totalcartmember", $this->gettotalcartmember())->with("member_list", $member_list);

        } else {
            return redirect()->back();
        }
    }

    public function show_profile_detail($city, $slug)
    {
        $this->change_city($city);
        $labs = $this->get_selected_city_other_labs($city);
        Session::put("active_menu", "");
        $defaultcityID = $this->getdefaultcityid(session()->get('cityName'));
        $data = Profiles::query()
                    ->join('profile_branch as pb', 'pb.profile_id', '=', 'profiles.id')
                    ->whereIn('pb.branch_id', [$defaultcityID])  
                    ->whereNull('profiles.deleted_at')
                    ->select('profiles.*','pb.mrp','pb.price')->where('profiles.slug', $slug)->first();
      
        if ($data) {
            $id = $data->id;
            $dis_pa = $this->get_discount($data->id,'Profiles',$data->mrp);
            $data->discount = $dis_pa;
            $data->package_frq = Package_FRQ::where("package_id", $id)->where("type", '3')->get();
            $category = Category::where('is_deleted', '0')->get();
            $popular_package = Popular_package::whereNull('deleted_at')->get();
            $package_list = Package::where("category_id", $id)->whereNull('deleted_at')->get();
            $profiles_list = Profiles::whereNull('deleted_at')->get();
            $setting = Setting::find(1);
            $parameter_list = Parameter::whereNull('deleted_at')->get();
            $arr = explode(",", $data->no_of_parameter);
            $data->parameter = count($arr);
            $ls = array();
            $i = 0;
            $mrp = 0;
            foreach ($arr as $a) {
                $parameter = Parameter::find($a);
                if ($parameter) {
                    $mrp += $parameter->mrp;
                    $parameter['id'] = (int) $parameter->id;
                    $parameter['slug'] = $parameter->slug;
                    $ls[] = $parameter;
                }
                // $ls[] = (int) (Parameter::find($a) ? Parameter::find($a) : '');
            }
            $data->no_of_per = count($arr);

            $profiles = Profiles::whereNull('deleted_at')->get()->map(function ($profile) {
                $profile->id = (int) $profile->id; // Convert 'id' to an integer
                return $profile;
            });
            $data->testdetails = $ls;
            #----------
            $reviewlist = Review::with('userdata')->where("type", '3')->where("type_id", $id)->get();
            $data->total_review = count(Review::where("type", '3')->where("type_id", $id)->get());
            $member_list = FamilyMember::where("user_id", Auth::id())->whereNull("deleted_at")->get();
            
            return view("front.profile_detail")->with('labs', $labs)->with("category", $category)->with("data", $data)->with("package_list", $package_list)->with("popular_package", $popular_package)->with("setting", $setting)->with("reviewlist", $reviewlist)->with("totalcartmember", $this->gettotalcartmember())->with("member_list", $member_list);

        } else {
            return redirect()->back();
        }
    }

    public function getaddress(Request $request)
    {
        return json_encode(UserAddress::where("id", $request->get("id"))->where("user_id", Auth::id())->first());
    }
    public function getUsersByCity($city_id)
    {
        $city = UserAddress::find($city_id);
        $lat = $city->lat;
        $lng = $city->long;
        $latRange = 0.1; // 0.1 degree range
        $lngRange = 0.1; // 0.1 degree range
        $cityname = session()->get('cityName');
        if ($cityname == '') {
            $cityname = 'Jamnagar';
        }
        // $lab = User::where('user_type', 2)->where('city', $request->get("member_id"))->first();

        $users = City::select('city.*')->join('users','users.city','city.id')->where('users.user_type', 2)->whereBetween('city.lat', [$lat - $latRange, $lat + $latRange])
                        ->whereBetween('city.lng', [$lng - $lngRange, $lng + $lngRange])->where('users.status', 1)
                        ->where('city.city',$cityname)
                        ->distinct()
                        ->get(); // Use pluck to get an array of city IDs

        return response()->json($users);
    }
     public function getUsersByCityHome($city_id)
    {
        $city = City::find($city_id);
        $lat = $city->lat;
        $lng = $city->lng;
        $latRange = 0.1; // 0.1 degree range
        $lngRange = 0.1; // 0.1 degree range
        $users = City::whereBetween('lat', [$lat - $latRange, $lat + $latRange])
            ->whereBetween('lng', [$lng - $lngRange, $lng + $lngRange])
            ->get(); // Use pluck to get an array of city IDs

        return response()->json($users);
    }
    public function applycouponbyBoy(Request $request)
    {

        #------------------coupon----------------

        $cart_data = json_decode($request->book_test);



        $price = 0;
        $discount = 0;
        $coupon_data = Coupon::where('coupon_code', $request->input('id'))->first();
        if (!$coupon_data) {
            return response()->json($discount);
        }

        $today = date('l');
        $days = explode(',', $coupon_data->day);
        foreach ($days as $dy) {
            if ($dy == $today) {

                if ($coupon_data->type == 4) {
                    $price = $request->input('subtotal');
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


        return response()->json($discount);
    }
    public function applycoupon(Request $request)
    {
        #------------------coupon----------------
        $discount = 0;
        $user_id=Auth::id();
        $cp = Coupon::where("coupon_code", $request->input('code'))->first();
        // dd($cp);
        if($cp){
            $discount =$this->ApplyCoupononUser($user_id,$cp->id,$request->input('subtotal'),$request->cart);
            // $discount =$this->applycoupononcoustomer($user_id,$cp->id,$request->input('subtotal'));
        }
        
        return response()->json($discount);
    }
    public function checkout_online($id){
        $data = Orders::find($id);
        $amount = (int)$data->final_total; 
        // $amount = 1;
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
    
        $orderData = [
            'receipt'         => 'rcptid_11',
            'amount'          => $amount * 100, // amount in the smallest currency unit
            'currency'        => 'INR',
        ];
        
        $razorpayOrder = $api->order->create($orderData);
        
        $orderId = $razorpayOrder['id'];
        return view('rz_pay', compact('orderId','orderData','id'));
    }
    public function post_Book_order(Request $request)
    {
        // dd($request->all());
        $walletSetting = Setting::first();
        $ls = array();
       
        $dis = 0;
        $setting = Setting::find(1);
        $lab = User::where('user_type', 2)->where('city', $request->get("member_id"));
     

        if ($lab == null) {
            $e = "Lab not found at this location";
            Session::flash('message1', $e);
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
        
        $member = 1;//$lab->id;
        $subtotal = $request->get("subtotal");

        $final_total = $request->get("final_total");
        // dd($final_total);
        $wallet_cashback_point = 0;
        $store = new Orders();
        #--------------------wallet----------------
        if (isset($request['wallet_point']) && $request['wallet_point'] > 0) {
            $userupdate = User::find(Auth::id());
            $userupdate->wallet_amount -= $request['wallet_point'];
            $userupdate->save();
            $dis = $request['wallet_point'] / $setting->wallet_cashback_point;
            
        }
        // dd($final_total);
        #-------------- waller cash back---------------------------
        $wallet_cashback_per = $walletSetting->wallet_cashback_per / 100;
        $wallet_cashback_point = ($subtotal * $wallet_cashback_per) * $setting->wallet_cashback_point;
        $wallet_cashback_point = number_format($wallet_cashback_point, 2);
        $userupdate = User::find(Auth::id());
        $userupdate->wallet_amount += number_format($wallet_cashback_point,0);
        $userupdate->save();

        #------------------coupon----------------

        $cart_data = $request->cart;

        $price = 0;
        $discount = 0;
        $store->coupon_id = $request['coupon_id'];
        $store->coupon_discount = $request['coupon_dis'];
        
        Try{
            DB::beginTransaction();
            // -- detail
            $user_id =  Auth::id();
            $store->user_id = $user_id;
            $store->sample_collection_address_id = $request->get("sample_collection_address_id");
            $store->date = $request->get("date");
            $store->time = $request->get("time");
            $store->visit_type = $request['visit_type'];
            $store->subtotal = $subtotal;
            $store->wallet_discount = $dis;
            $store->manager_id = $member;
            $store->cashback_point = $request['wallet_point'];
            $store->final_total = $final_total;
            $store->tax = $request->get("tax");
            $store->status = 1;
            $store->orderplace_date = $this->getsitedate();
            if ($request->get("payment_type") == "cod") {
                $store->payment_method = $request->get("payment_type");
                $store->token = '';              
                $store->save();
            }else{
                $store->payment_method = "cod";
                $store->token = $request->get("tr"); 
                $store->save();
            }
           
         
            $order_id =  $store->id; 
            
            $wallet_data = new Wallet();
            $wallet_data->user_id  = Auth::id();
            $wallet_data->wallet_points  =  $setting->wallet_cashback_point;
            $wallet_data->order_id  =  $order_id   ;
            $wallet_data->action  =  1;
            $wallet_data->expire_on  =  date('Y-m-d', strtotime('+1 year'));
            $wallet_data->save();
            
            if (isset($request['wallet_point']) && $request['wallet_point'] > 0) {
        
            $wallet_data = new Wallet();
            $wallet_data->user_id  = Auth::id();
            $wallet_data->wallet_points  =  $request['wallet_point'];
            $wallet_data->order_id  =  $order_id   ;
            $wallet_data->action  =  0;
            $wallet_data->save();
            }
                       
                        
                $store1 =$cart_data;
                foreach ($store1 as $s) {
                        // dd($s);
                        $mrp = 0;
                        if ($s['type'] == 1) {
                            $item_data = Package::find($s['type_id']);
                             $find_pa = TestDetails::where("package_id", $item_data->id)->get();
                        } else if ($s['type'] == 2) {
                            $item_data = Parameter::find($s['type_id']);
                          
                        } else {
                            $item_data = Profiles::find($s['type_id']);
                             
                            if ($item_data) {
                                $item_data->name = $item_data->profile_name;
                            }
                        }
                        
                        // dd($s);
                        $data = new OrdersData();
                        $data->order_id = $store->id;
                        $data->member_id = $member;
                        $data->item_id = $s['type_id'];
                        $data->family_member_id = $s['family_member_id'];
                        //  dd($s);
                        $data->type = $s['type'];
                        $data->item_name = $item_data->name;
                        $data->parameter = $s['parameter'];
                        $data->mrp = $s['price'];
                        $data->price = $s['mrp'];
                        $data->save();

                    }
                 
               
                CartMember::where("user_id", Auth::id())->delete();
                DB::commit();
                $getuseraddress = UserAddress::find($store->sample_collection_address_id);
                if ($getuseraddress) {
                    $getmanager = User::where("user_type", "2")->where("city", $getuseraddress->city)->get();
                    foreach ($getmanager as $gm) {
                        $gm->order_notification = $gm->order_notification + 1;
                        $gm->save();
                        $data1 = array();
                        $data1['email'] = $gm->email;
                        $data1['msg'] = __("message.You Get New Booking For Test");
                        $data1['order_id'] = $store->id;
                        $data1['customer_name'] = User::find($data->user_id) ? User::find($data->user_id)->name : '';
                        $data1['manager_name'] = $gm->name;
                        try {
                            $result = Mail::send('email.order_status', ['user' => $data1], function ($message) use ($data1) {
                                $message->to($data1['email'], $data1['manager_name'])->subject(__('message.site_name'));
                            });
                        } catch (\Exception $e) {
                        }
                    }
                }
                
                $msg = __('message.Test Book Successfully');
                //------------ SMS data----
                        $userdata = User::find($store->user_id);
                        $userdatalab = User::find($store->manager_id);
                        $to = $userdatalab->phone;
                        
                        $getorderdatat = OrdersData::where('order_id',$store->id)->first();
                            $test = 'Test';
                        if($getorderdatat){
                            $test = $getorderdatat->item_name;
                        }
                            $templateName='Order_Received';
                            // New order received. Order ID: {orderId}, Test: {test}, Customer: {name}. Please check the portal for further details. Reliable Diagnostics
                            $datatm=[
                            'orderId'=>$store->id,'name'=>$userdata->name,'test'=>$test,
                            ];
                            
                            // $this->sendSms($to ,$datatm, $templateName);
                            // For 8094416508 , 7976526802 
                            $templateName='Order_Received';
                            // New order received. Order ID: {orderId}, Test: {test}, Customer: {name}. Please check the portal for further details. Reliable Diagnostics
                            $datatm=[
                            'orderId'=>$store->id,'name'=>$userdata->name,'test'=>$test,
                            ];
                            
                            // $this->sendSms(8094416508 ,$datatm, $templateName);
                            // --
                            $templateName='Order_Received';
                            // New order received. Order ID: {orderId}, Test: {test}, Customer: {name}. Please check the portal for further details. Reliable Diagnostics
                            $datatm=[
                            'orderId'=>$store->id,'name'=>$userdata->name,'test'=>$test,
                            ];
                            
                            // $this->sendSms(7976526802 ,$datatm, $templateName);
                        // ------------------------
                if($request->get("payment_type") != "cod"){
                    return redirect()->route('checkout_online', ['id' => $store->id]);
                }
                $this->send_notification_order_android($setting->android_server_key, $store->user_id, $msg, $store->id);
                $this->send_notification_order_android($setting->ios_server_key, $store->user_id, $msg, $store->id);
                Session::flash('message', __('message.Test Book Successfully'));
                Session::flash('alert-class', 'alert-success');
                return redirect('user_dashboard');
            // --
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('message1', $e);
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
            
    }
    


    public function book_payment(Request $request)
    {
        //   dd($request->all());
        $lab = User::where('user_type', 2)->where('city', $request->member_id)->first();

        if ($lab == null) {
            $e = "Lab not found at this location";
            Session::flash('message1', $e);
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
        $date = date("Ymd"); // Format the current date as YYYYMMDD
        $order_id = $date . rand() . time();
        $data = [
            'sample_collection_address_id' => $request->sample_collection_address_id,
            'date' => $request->date,
            'time' => $request->time,
            'member_id' => $request->member_id,
            'coupon_id' => $request->coupon_id,
            'wallet_point' => $request->wallet_point,
            'visit_type' => $request->visit_type,
            'subtotal' => $request->subtotal,
            'tax' => $request->tax,
            'final_total' => $request->final_total,
            'payment_type' => $request->payment_type,
            'user_id' => auth()->id(),
            'order_id' => $order_id
        ];

        // Insert the data into the 'booking_payments' table
        DB::table('booking_payments')->insert($data);

        // Retrieve the ID of the inserted record (assuming 'id' is an auto-incrementing primary key)
        $insertedId = DB::getPdo()->lastInsertId();
        $datad = DB::table('booking_payments')->find($insertedId);

        #-----------------------
        $userdetils = Useraddress::find($request->get("sample_collection_address_id"));
        $userdetils2 = User::find(Auth::id());
        // $input['amount'] = $request->final_total;
        $input['amount'] = 1;
        //  $input['merchant_param1'] = $insertedId;
        $input['order_id'] = $order_id;
        $input['currency'] = "INR";
        $input['billing_name'] = $userdetils->name;
        $input['billing_address'] = $userdetils->address;
        $input['billing_city'] = $userdetils->city;
        $input['billing_state'] = $userdetils->state;
        $input['billing_zip'] = $userdetils->pincode;
        $input['billing_country'] = "India";
        $input['billing_tel'] = $userdetils2->phone;
        $input['billing_email'] = $userdetils2->email;
        $input['redirect_url'] = route('pay_online');
        $input['cancel_url'] = route('home');
        $input['language'] = "EN";
        $input['merchant_id'] = env('merchant_id');

        $merchant_data = "";

        $working_key = env('working_key'); //Shared by CCAVENUES
        $access_code = env('access_code'); //Shared by CCAVENUES

        foreach ($input as $key => $value) {
            $merchant_data .= $key . '=' . $value . '&';
        }

        $encrypted_data = $this->encryptCC($merchant_data, $working_key);

        return view("front.payment")->with('access_code', $access_code)->with('encrypted_data', $encrypted_data);


    }
    public function api_payment_status($status)
    {
        echo $status;
    }

    public function api_payment_cancle()
    {
        $url = route('api_payment_status', ['status' => "cancel"]);
        return redirect($url);
    }
}
