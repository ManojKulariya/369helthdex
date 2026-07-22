<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\City;
use App\Models\Category;
use App\Models\Setting;
use App\Models\PaymentGateway;
use App\Models\Orders;
use App\Models\Package;
use App\Models\Parameter;
use App\Models\Profiles;
use App\Models\Popular_package;
use Session;
use App\Models\News;
use Hash;
use Mail;
use Auth;
use DateTimeZone;
use DateTime;
use App\Models\Contactus;
use DataTables;

class AdminController extends Controller
{
    // public function rowdata(Request $request){
    //     $ip = $request->ip();
    //     $geoData = file_get_contents("http://ip-api.com/json/{$ip}");
    // $location = json_decode($geoData, true);
    //     dd($location);

    // }
    public function getloc($ip)
    {
        $loc = [
                'latitude'=>'',
                'longitude'=>''
            ] ;
        $url = "http://ip-api.com/json/{$ip}";
        $ch = curl_init();
        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Set timeout to avoid hanging requests
    
        // Execute cURL request
        $response = curl_exec($ch);
    
        // Check for cURL errors
        if (curl_errno($ch)) {
            return response()->json(['error' => 'Unable to retrieve location: ' . curl_error($ch)], 500);
        }
    
        // Close cURL session
        curl_close($ch);
    
        // Decode JSON response
        $location = json_decode($response, true);
    
        if ($location['status'] === 'success') {
            $latitude = $location['lat'];
            $longitude = $location['lon'];
            
            $loc = [
                'latitude'=>$latitude,
                'longitude'=>$longitude
            ] ;
            
        }
        return $loc;
        
    
    }
    public function rowdata(Request $request)
    {
        dd($request->session()->get('cityName'));
        if (session()->has('cityName')) {
    $cityName = session('cityName');
}
        $res = $this->getloc($request->ip());
        // dd($res['latitude']);
        $latitude = $res['latitude'];
        $longitude = $res['longitude'];
        $tolerance = 1;
        $city = City::whereBetween('lat', [$latitude - 0.1, $latitude + 0.1])
            ->whereBetween('lng', [$longitude - 0.1, $longitude + 0.1])
            ->first();
            dd($city);
        if (is_numeric($latitude) || is_numeric($longitude)) {
            if ($city) {
                $cityId = $city->id;
                $cityName = $city->slug;
                session(['cityName' => $cityName, 'loctionID' => $cityId]);
            }
            session(['latitude' => (float) $latitude, 'longitude' => (float) $longitude, 'userlatitude' => (float) $latitude, 'userlongitude' => (float) $longitude]);
            return response()->json(['message' => 'Location updated and stored in session']);
        } else {
            if ($latitude == '' || $longitude == '') {
                if ($city) {
                    $cityId = $city->id;
                    $cityName = $city->slug;
                    session(['cityName' => $cityName, 'loctionID' => $cityId]);

                }
                session(['latitude' => (float) $latitude, 'longitude' => (float) $longitude, 'userlatitude' => (float) $latitude, 'userlongitude' => (float) $longitude]);
                return response()->json(['message' => 'Invalid latitude or longitude provided'], 400);
            }
        }
    }
//     public function rowdata(Request $request)
// {
//     $ip = $request->ip(); // Get the user's IP address
    
//     // Set the API URL
//     $url = "http://ip-api.com/json/{$ip}";

//     // Initialize cURL session
//     $ch = curl_init();

//     // Set cURL options
//     curl_setopt($ch, CURLOPT_URL, $url);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Set timeout to avoid hanging requests

//     // Execute cURL request
//     $response = curl_exec($ch);

//     // Check for cURL errors
//     if (curl_errno($ch)) {
//         return response()->json(['error' => 'Unable to retrieve location: ' . curl_error($ch)], 500);
//     }

//     // Close cURL session
//     curl_close($ch);

//     // Decode JSON response
//     $location = json_decode($response, true);

//     if ($location['status'] === 'success') {
//         $latitude = $location['lat'];
//         $longitude = $location['lon'];

//         return response()->json([
//             'latitude' => $latitude,
//             'longitude' => $longitude,
//         ]);
//     }

//     return response()->json(['error' => 'Unable to retrieve location'], 400);
// }

    // public function rowdata(){
    //     $dataList = [
    //         "Major Surender Hospital, Under Hanumangarh Road Flyover, Abohar, Punjab- 152116, India",
    //         "Nagar Nigam, Near By Soorsadan MG Road, Agra, Uttar Pradesh - 282002, India",
    //         "358/4, Green House , Todarmal Lane, Revenue Board Road , Civil Lines, Ajmer, Rajasthan, India",
    //         "Chandraprabhu Tower, Plot No. 6, Anand Vihar, Agarsen Circle, Alwar, Rajasthan, India",
    //         "Gupta Nursing Home, Harsuli Raod, Khairthal - 301404, Rajasthan, India",
    //         "51, Kumbha Marg, Savitri Vihar, Sanganer, Sector 9, Pratap Nagar, Jaipur, Rajasthan - 302033, India",
    //         "GS Low Collage Ke Samne, Fafund Road, Auraiya, Uttar Pradesh, India",
    //         "6/622, Sant Colony, Railway Road, Bahadurgarh, Haryana – 124507, India",
    //         "Madhur Hospital, Beneath, ICICI Bank, Bandikui Rd, Bandikui - 303313, Rajasthan, India",
    //         "New Petrol Pump Ke Samne, Sikndera Road, Bandikui - 303313, Rajasthan,, India",
    //         "Axis Bank Meerana Tiraya, Bayana, Rajasthan, India",
    //         "Opp. Hanuman Temple, Suraj Pul Chouraha, Bharatpur-321001, Rajasthan, India",
    //         "Opp. MG Hospital, Dargar Niwas, Manikya Nagar, Bhilwara, Rajasthan, India",
    //         "Shrinath Hospital, Vardhman Vihar, Beawar Road, Bijainagar - 305624, Rajasthan, India",
    //         "B-4/10/11, Pawan Puri S Ext Rd, Sudarshna Nagar, Pawan Puri South Extension, Bikaner, Rajasthan 334003, India",
    //         "204, Coral Kamla Residency, New Shiv Bari Road, Chankya Nagar, Bikaner, Rajasthan, India",
    //         "Opposite Zanana Hospital Gate No.-2, Chandpol, Jaipur, Rajasthan 302001, India",
    //         "Dr. Deepak Gupta Child Hospital, Near Mangalam City Gate, Jaipur Road, Chomu Bypass Tiraha, Chomu, Rajasthan, India",
    //         "C-314 A, Hari Marg, Mavliya Nagar, Jaipur - 302017, Rajasthan, India",
    //         "Ward Number 23, Nandini Market, Thandi Sadak, Opposite Kanha Garden, Datia, Madhya Pradesh 475661, India",
    //         "Shiv Colony Near Govt Hospital, Lalsot Road, Dausa, Rajasthan, India",
    //         "Plot No. 12, Chandrakala Colony, 40, Sunder, Tonk Rd, Near Overhead Water Tank, Durga Vihar Colony, Jaipur, Rajasthan, India",
    //         "Near Old CP Hospital, Gangarpur City, Rajasthan, India",
    //         "103, Polo Frist, Paota, Jodhpur, Rajasthan, India",
    //         "Patrakar Colony, Banrangargh ByPass Road, Guna, Madhya Pradesh, India",
    //         "1a, 110, Hari Path, Shiv Shakti Colony, Ram Nagar, Shastri Nagar, Jaipur, Rajasthan 302016, India",
    //         "1st Floor Premy Complex, Rajpayga Road, Opposit Madhar Dispensary, Lashkar, Madhya Pradesh - 474001, India",
    //         "Near Bharatmata Chowk, Hanumangarh Town, Rajasthan, India",
    //         "Opp. Govt. Hospital, Hindaun, Rajasthan, India",
    //         "Near Naini Bai Ji Temple, Udaimandir, Jodhpur, Rajasthan, India",
    //         "10/0b/48, Ring Road Project, Bagrana, Agra Road Jaipur 303012, Rajasthan, India",
    //         "B-4, Iind Floor, Royal Tower Dist Shopping Centre, Near Laxmi Mandir Cinema, Kalwar Road, Jaipur, Rajasthan, India",
    //         "Jawaharlal Nehru Marg, Near Trimurti Circle, Gangwala Park, Adarsh Nagar, Jaipur 302004, Rajasthan, India",
    //         "Paota Main Mandori Road, Jodhpur, Rajasthan, India",
    //         "H.No: 139, 2nd Polo Behind Aastha Hospital, Paota Jodhpur, Rajasthan, India",
    //         "C/O Shyamlal Chandrashekar Medical Collage & Shaeed Prab hu Narayan Multispeciality Hospital, Paramanandpur, Khagaria- 851205, Bihar, India",
    //         "1-D-14, 1st Floor, SFS, Talwandi, Kota, India",
    //         "Garh Colony, Kotputali Dist., Jaipur 303108, Rajasthan, India",
    //         "Shakti Bihar Cut, N-H.48, Kotputli - 303108, Rajasthan, India",
    //         "Shop No.-12,13 , Near Govt Hosp. NH -08, Kotputli, Rajasthan, India",
    //         "Salarpur Rd, Kurukshetra, Haryana 136118, India",
    //         "Red Rd, Sector 17, Jyoti Nagar, Kurukshetra, Haryana 136118, India",
    //         "Rathi Hospital Complex Near Nagar Nigam Office Morena 476001, Madhya Pradesh, India",
    //         "Opp. Trends Showroom, Hero honda Chowk, Nizampur Road, Narnaul, Haryana, India",
    //         "Shop No. B-11, Near Shiv Mandir Shastri Circle, Jodhpur, Rajasthan, India",
    //         "Opp. Govt Kapil Hospital, Near Chanduka Garden, Neem Ka Thana, Rajasthan, India",
    //         "In Front Of Pillar No. 83, Raja Bajar, Bailey Road, Patna, Bihar, India",
    //         "Near Shipra Path Thana, Aravali Marg, Mansarovar Jaipur, Rajasthan-302020, India",
    //         "Near Kamla Drug Chotha Pulia, Ratangar, Rajasthan, India",
    //         "Near Jems Garden, Agra Road, Jaipur, Rajasthan, India",
    //         "First Floor, Jangir Medical, Opp. Govt. Hospital, Ringus, India",
    //         "Mahaveer Nagar, Bherdari, Bihar - 852201, India",
    //         "4, Hare Krishna Marg, Shyam Vihar Colony, Vishnupuri, Model Town, Malviya Nagar, Jaipur, Rajasthan 302017, India",
    //         "Shop No. 12 , 13, Bhaskar Height, Near S. K. Hospital , Sikar, Rajasthan, India",
    //         "Suratgarh Hanumangarh Bypass, Ridhi Sidhi Enclave, Sri Ganganagar, Rajasthan - 335001, India",
    //         "Near Govt Hospital, Tara Nagar, Churu, Rajasthan, India",
    //         "Shree Laxmi Medicose, Mahindi Bagh, Patel Circel, Tonk, Rajasthan, India",
    //         "24-C Madhuban, Opp. Govt Post Office, Chetak Circle, Udaipur - 313001, Rajasthan, India",
    //         "New Kapil Diagnostic Centre, SBS Chowk, Near Jaitu Chungi, Kotkapura, Faridkot, Punjab - 151204, India",
    //         "Ward No. 09, Near Madan Jain Hospital, Ellenabad, Sirsa, Hariyana - 125102, India",
    //         "Pilar No. 4, Palm View Hospital, Bailey Rd, Jyotipuram Colony, Nandanpuri Colony, Rukanpura, Patna, Bihar 800014, India",
    //         "Nowgam Byepass, Srinagar - 190015, India",
    //         "PKV Hospital, Beawar Rd, Opp Sanmati decor, Bijainagar, Rajasthan 305624, India",
    //         "45, Sindhi Colony, Opp. Uti, Sri Ganganagar, Rajasthan, India",
    //         "S1 S- Block, Opp. Hotel Mosaic , RFC Colony, Hanuman Nagar Extension, Krishna Nagar, Vaishali Nagar, Sirsi Road, Jaipur - 302021, Rajasthan, India",
    //         "Ward No. 08, C/O Indu Medicose, Opp. Bdk Hospital Station Road, Jhunjhnu - 333001, India",
    //         "52-53, Adrash Market, Panchbatti, Bharuch - 392001, Gujarat, India",
    //         "Gantaghar Road, Dholpur - 328001, Rajasthan, India",
    //         "Malhotra Deptt. Store, NH-52, Patan Road Oop, Jhalawar, Rajasthan - 326001, India",
    //         "Shri Ram Plaza, In Front Of Vaibhav Garden, Udaipur Road, Senthi, Chittorgarh - 312001, Rajasthan, India",
    //         "1b, Udaipur Rd, Near Apna Medical Store, Pratap Nagar, Chittorgarh, Rajasthan 312001, India",
    //         "Beside Government Hospital, New Sarak, Deeg, Rajasthan, India"
    //     ];
    //     $apiKey = 'AIzaSyCobHx38xPOGViCcqgs2uz_1UT94ls3Y_w';
    //     foreach($dataList as $data){
    //         echo "<pre>";
    //         echo "<------------ ";
    //         echo $data;
    //         $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($data) . "&key=" . $apiKey;
    //         $ch = curl_init();
    //         curl_setopt($ch, CURLOPT_URL, $url);
    //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //         $response = curl_exec($ch);
    //         // Check for cURL errors
    //         if (curl_errno($ch)) {
    //             echo 'Curl error: ' . curl_error($ch);
    //         }
    //         curl_close($ch);
    //         $data = json_decode($response);                    // Check if the response is valid and has results
    //         if ($data->status === 'OK') {
    //             $lat = $data->results[0]->geometry->location->lat; // Round to 6 decimal places
    //             $lng = $data->results[0]->geometry->location->lng; // Round to 6 decimal places
    //             echo " [ latitude:- $lat , longitude :- $lng ]";

    //         }else{
    //             echo " Not found !!";
    //         }
    //         echo " ------------>";
    //     }
    // }
//   public function rowdata(){
// //          $row =[
// //   [
// //     "S.NO"=>1,
// //     "STATE"=>"Punjab",
// //     "BRANCH_NAME"=>"Major surender hospital",
// //     "Location"=>"ABHOR",
// //     "COMPANY_NAME"=>"RELIABLE HEALTHCARE",
// //     "REGISTERED_ADDRESS"=>"Major surender hospital Under Hanumangarh road flyover, Abohar pin code 152116",
// //     "Contact_Person"=>"Mr. Avinash Rawat",
// //     "Contact_No"=>"7300044437",
// //     "Email_ID"=>"Reliablelababohar@gmail.com"
// //   ],
// //   [
// //     "S.NO"=>2,
// //     "STATE"=>"Uttar Pradesh",
// //     "BRANCH_NAME"=>"Agra",
// //     "Location"=>"AGRA",
// //     "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE(P)",
// //     "REGISTERED_ADDRESS"=>"Nagar Nigam Near By Soorsadan MG Road Agra 282002",
// //     "Contact_Person"=>"Mr. Vikas Kumar Saxena",
// //     "Contact_No"=>"9536577744",
// //     "Email_ID"=>"rdcagra2020@gmail.com"
// //   ],
// //   [
// //     "S.NO"=>3,
// //     "STATE"=>"Rajasthan",
// //     "BRANCH_NAME"=>"Ajmer",
// //     "Location"=>"AJMER",
// //     "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE(P)",
// //     "REGISTERED_ADDRESS"=>"358/4, green house , todarmal lane ,revenue board road , civil lines ajmer",
// //     "Contact_Person"=>"Dr. Santosh Kumar Sharma",
// //     "Contact_No"=>"9983007008",
// //     "Email_ID"=>"rdcajmer01@gmail.com"
// //   ],
// //   [
// //     "S.NO"=>4,
// //     "STATE"=>"Rajasthan",
// //     "BRANCH_NAME"=>"Alwar",
// //     "Location"=>"ALWAR",
// //     "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE PVT. LTD.",
// //     "REGISTERED_ADDRESS"=>"Chandraprabhu Tower Plot No. 6 Anand Vihar Agarsen Circle Alwar",
// //     "Contact_Person"=>"Mr. Sonu",
// //     "Contact_No"=>"9166129293",
// //     "Email_ID"=>"alwar@rdccare.com"
// //   ],
// //   [
// //     "S.NO"=>5,
// //     "STATE"=>"Rajasthan",
// //     "BRANCH_NAME"=>"KHAIRTAL",
// //     "Location"=>"Alwar",
// //     "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE PVT. LTD.",
// //     "REGISTERED_ADDRESS"=>"Gupta Nursing home, Harsuli Raod, Khairthal-301404",
// //     "Contact_Person"=>"Mr. Sonu",
// //     "Contact_No"=>"9166129293",
// //     "Email_ID"=>"alwar@rdccare.com"
// //   ],
// //   [
// //     "S.NO"=>6,
// //     "STATE"=>"Rajasthan",
// //     "BRANCH_NAME"=>"ASHIRWAD HOSPITAL",
// //     "Location"=>"Jaipur",
// //     "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE PVT. LTD.",
// //     "REGISTERED_ADDRESS"=>"51, Kumbha Marg, Savitri Vihar, Sanganer, Sector 9, Pratap Nagar, Jaipur, Rajasthan - 302033.",
// //     "Contact_Person"=>"Mr. Manish",
// //     "Contact_No"=>"7073484448",
// //     "Email_ID"=>"pritiagrawaldr@gmail.com"
// //   ],
// //   [
// //     "S.NO"=>7,
// //     "STATE"=>"Uttar Pradesh",
// //     "BRANCH_NAME"=>"Auraiya",
// //     "Location"=>"Auraiya",
// //     "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE PVT. LTD.",
// //     "REGISTERED_ADDRESS"=>"GS Low Collage ke Samne Fafund Road Auraiya UP",
// //     "Contact_Person"=>"Vikash",
// //     "Contact_No"=>"9549325488",
// //     "Email_ID"=>"auraiya@rdccare.com"
// //   ],
// //   [
// //     "S.NO"=>8,
// //     "STATE"=>"HARYANA",
// //     "BRANCH_NAME"=>"BAHADURGARH",
// //     "Location"=>"",
// //     "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE(P)",
// //     "REGISTERED_ADDRESS"=>"6/622, SANT COLONY, RAILWAY ROAD, BAHADURGARH, HARYANA – 124507",
// //     "Contact_Person"=>"Mr. Ravii Khurana",
// //     "Contact_No"=>"9581096559",
// //     "Email_ID"=>"ravi.khurana@rediffmail.com"
// //   ],
// //   [
// //     "S.NO"=>9,
// //     "STATE"=>"Rajasthan",
// //     "BRANCH_NAME"=>"BANDIKUI",
// //     "Location"=>"Dausa",
// //     "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE(P)",
// //     "REGISTERED_ADDRESS"=>"Madhur hospital",
// //     "Contact_Person"=>"Mr. Satyanarayan Saini",
// //     "Contact_No"=>"9667681315",
// //     "Email_ID"=>"bandikui@rdccare.com"
// //   ],
// //   [
// //     "S.NO"=>10,
// //     "STATE"=>"Rajasthan",
// //     "BRANCH_NAME"=>"Baran",
// //     "Location"=>"Baran",
// //     "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE(P)",
// //     "REGISTERED_ADDRESS"=>"New patol pump k samne sikndera road bandikui pin 303313",
// //     "Contact_Person"=>"Mr. K. K. Sharma",
// //     "Contact_No"=>"9649099991",
// //     "Email_ID"=>"rdckota1@gmail.com"
// //   ],
// //     [
// //       "S.NO"=>11,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"BAYANA",
// //       "Location"=>"Bharatpur",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE(P)",
// //       "REGISTERED_ADDRESS"=>"Axis Bank Meerana Tiraya, Bayana",
// //       "Contact_Person"=>"Nand Kumar Parashar",
// //       "Contact_No"=>"9413344860",
// //       "Email_ID"=>"nk1972sharma@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>12,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"BHARATPUR",
// //       "Location"=>"Bharatpur",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE PVT. LTD.",
// //       "REGISTERED_ADDRESS"=>"OPP. HANUMAN TEMPLE, SURAJ PUL CHOURAHA BHARATPUR-321001",
// //       "Contact_Person"=>"Mr. Devendra Kumar Sharma/ Mr. Nand Kumar Sharma",
// //       "Contact_No"=>"8503895657/9413344860",
// //       "Email_ID"=>"monu1068@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>13,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"BHILWARA",
// //       "Location"=>"Bhilwara",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE(P)",
// //       "REGISTERED_ADDRESS"=>"OPP. MG HOSPITAL,DARGAR NIWAS MANIKYA NAGAR, BHILWARA, RAJASTHAN",
// //       "Contact_Person"=>"Mr. Aatma Ram/Mr. Laxman Singh",
// //       "Contact_No"=>"8559995562/8003699767",
// //       "Email_ID"=>"rdcbhilwara@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>14,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"Bijainagar",
// //       "Location"=>"Bhilwara",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE",
// //       "REGISTERED_ADDRESS"=>"Shrinath Hospital Vardhman vihar Beawar Road Bijainagar 305624",
// //       "Contact_Person"=>"Mr. Raju Lal",
// //       "Contact_No"=>"9549942491",
// //       "Email_ID"=>"rdcbhilwara@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>15,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"Bikaner",
// //       "Location"=>"Bikaner",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE",
// //       "REGISTERED_ADDRESS"=>"B-4/10/11, Pawan Puri S Ext Rd, Sudarshna Nagar, Pawan Puri South Extension, Bikaner, Rajasthan 334003",
// //       "Contact_Person"=>"Mr. Vishnu Kumar Kachhawa",
// //       "Contact_No"=>"9214056337",
// //       "Email_ID"=>"rdcbikaner2017@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>16,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"BIKANER",
// //       "Location"=>"Bikaner",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE",
// //       "REGISTERED_ADDRESS"=>"204, CORAL KAMLA RESIDENCY, NEW SHIV BARI ROAD, CHANKYA NAGAR, BIKANER",
// //       "Contact_Person"=>"Mr. Vishnu Kumar Kachhawa",
// //       "Contact_No"=>"9214056337",
// //       "Email_ID"=>"rdcbikaner2017@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>17,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"CHANDPOLE",
// //       "Location"=>"Jaipur",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE PVT. LTD.",
// //       "REGISTERED_ADDRESS"=>"Opposite Zanana Hospital Gate No.-2 Chandpol Jaipur, Rajasthan 302001",
// //       "Contact_Person"=>"Mr. Arun",
// //       "Contact_No"=>"8290178231",
// //       "Email_ID"=>"rdc.chandpol@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>18,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"CHOMU",
// //       "Location"=>"Jaipur",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE PVT LTD",
// //       "REGISTERED_ADDRESS"=>"DR. DEEPAK GUPTA CHILD HOSPITAL,NEAR MANGALAM CITY GATE, JAIPUR ROAD, CHOMU BYPASS TIRAHA,CHOMU",
// //       "Contact_Person"=>"Mr. Sunil Kumar Sharma",
// //       "Contact_No"=>"7976157266",
// //       "Email_ID"=>"dgchreliablechomu@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>19,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"CORPORATE OFFICE",
// //       "Location"=>"Jaipur",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE PVT. LTD.",
// //       "REGISTERED_ADDRESS"=>"C-314 A, HARI MARG, MAVLIYA NAGAR,JAIPUR - 302017",
// //       "Contact_Person"=>"Mr. Rajesh Yadav/ Mr. Nand Kumar Sharma",
// //       "Contact_No"=>"9413344863/9413344860",
// //       "Email_ID"=>"rdcpljaipur@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>20,
// //       "STATE"=>"Madhya Pradesh",
// //       "BRANCH_NAME"=>"DATIA",
// //       "Location"=>"Gwalior",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE(P)",
// //       "REGISTERED_ADDRESS"=>"Ward Number 23, Nandini Market, Thandi Sadak, opposite Kanha Garden, Datia, Madhya Pradesh 475661",
// //       "Contact_Person"=>"Dr. Kalpit Agarwal",
// //       "Contact_No"=>"8878903938",
// //       "Email_ID"=>"rdcdatia@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>21,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"DAUSA",
// //       "Location"=>"Dausa",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE (P)",
// //       "REGISTERED_ADDRESS"=>"SHIV COLONY NEAR GOVT HOSPITAL, LALSOT ROAD,DAUSA",
// //       "Contact_Person"=>"Mr. Laxman Singh / Mr. Dulichand",
// //       "Contact_No"=>"8003699767/9351703258",
// //       "Email_ID"=>"rdc.dausa@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>22,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"DURGAPURA-JAIPUR",
// //       "Location"=>"Jaipur",
// //       "COMPANY_NAME"=>"ADARSH LABS",
// //       "REGISTERED_ADDRESS"=>"PLOT NO. 12, CHANDRAKALA COLONY, 40, SUNDER, TONK RD, NEAR OVERHEAD WATER TANK, DURGA VIHAR COLONY",
// //       "Contact_Person"=>"Mr. Krishan Kumar Sharma",
// //       "Contact_No"=>"9460538879",
// //       "Email_ID"=>"rdcdurgapura@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>23,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"GANGAPURCITY",
// //       "Location"=>"Gangapur",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE PVT. LTD.",
// //       "REGISTERED_ADDRESS"=>"Near Old CP Hospital Gangarpur City",
// //       "Contact_Person"=>"Mr Vishnu Sain",
// //       "Contact_No"=>"6378276817",
// //       "Email_ID"=>"rdcgangapur@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>24,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"Global Hospital Jodhpur",
// //       "Location"=>"Jodhpur",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE(P)",
// //       "REGISTERED_ADDRESS"=>"103 Polo Frist Paota Jodhpur",
// //       "Contact_Person"=>"Dr. Manish Dodwani",
// //       "Contact_No"=>"9602625688",
// //       "Email_ID"=>"rdc.jodhpur@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>25,
// //       "STATE"=>"Madhya Pradesh",
// //       "BRANCH_NAME"=>"Guna",
// //       "Location"=>"Gwalior",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE(P)",
// //       "REGISTERED_ADDRESS"=>"Patrakar Colony Banrangargh By Pass Road Guna M.P.",
// //       "Contact_Person"=>"Dr. Alekh Saxena",
// //       "Contact_No"=>"8959038649",
// //       "Email_ID"=>"rdcgwalior@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>26,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"Gupta Hospital Sastri Nagar",
// //       "Location"=>"Jaipur",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE PVT. LTD.",
// //       "REGISTERED_ADDRESS"=>"1A, 110, Hari Path, Shiv Shakti Colony, Ram Nagar, Shastri Nagar, Jaipur, Rajasthan 302016",
// //       "Contact_Person"=>"Mr Rajesh Yadav",
// //       "Contact_No"=>"9413344863",
// //       "Email_ID"=>"guptahospitallab74@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>27,
// //       "STATE"=>"Madhya Pradesh",
// //       "BRANCH_NAME"=>"GWALIOR",
// //       "Location"=>"Gwalior",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE(P)",
// //       "REGISTERED_ADDRESS"=>"1ST FLOOR PREMY COMPLEX, RAJPAYGA ROAD, OPPOSIT MADHAR DISPENSARY,LASHKAR, M.P.-474001",
// //       "Contact_Person"=>"Dr. Alekh Saxena",
// //       "Contact_No"=>"8959038649/8959681265",
// //       "Email_ID"=>"rdcgwalior@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>28,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"HANUMANGARH",
// //       "Location"=>"HANUMANGARH",
// //       "COMPANY_NAME"=>"RDC HEALTHCARE LLP",
// //       "REGISTERED_ADDRESS"=>"Near bharatmata Chowk Hanumangarh town",
// //       "Contact_Person"=>"Mr. Ashish Gupta",
// //       "Contact_No"=>"9610857309",
// //       "Email_ID"=>"hanumangarh@rdccare.com"
// //     ],
// //     [
// //       "S.NO"=>29,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"Hindaun City",
// //       "Location"=>"Hindaun City",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE PVT. LTD.",
// //       "REGISTERED_ADDRESS"=>"Opp. Govt. Hospital Hindaun",
// //       "Contact_Person"=>"Mr. Hamendra Sharma",
// //       "Contact_No"=>"9549657417",
// //       "Email_ID"=>"hindaunrdc@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>30,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"Jain child care clinic",
// //       "Location"=>"Jodhpur",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE",
// //       "REGISTERED_ADDRESS"=>"Near naini Bai ji Temple Udaimandir Jodhpur",
// //       "Contact_Person"=>"Dr. Manish Dodwani",
// //       "Contact_No"=>"9602625688",
// //       "Email_ID"=>"rdc.jodhpur@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>31,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"Jamdoli",
// //       "Location"=>"Jaipur",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE PVT. LTD.",
// //       "REGISTERED_ADDRESS"=>"10/0B/48 ringh Road project bagrana Agra Road Jaipur 303012",
// //       "Contact_Person"=>"Mr. Shekhar",
// //       "Contact_No"=>"9649522392",
// //       "Email_ID"=>"jgesntc@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>32,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"JHOTWARA-JAIPUR",
// //       "Location"=>"Jaipur",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE PVT. LTD.",
// //       "REGISTERED_ADDRESS"=>"B-4, IIND FLOOR, ROYAL TOWER DIST SHOPPING CENTRE NEAR LAXMI MANDIR CINEMA KALWAR ROAD, JAIPUR",
// //       "Contact_Person"=>"Mr. Rajendra Kumar",
// //       "Contact_No"=>"7733033215/8875831111",
// //       "Email_ID"=>"reliablejhotwara@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>33,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"JK LONE",
// //       "Location"=>"Jaipur",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE PVT. LTD.",
// //       "REGISTERED_ADDRESS"=>"Jawaharlal Nehru Marg, Near Trimurti Circle, Gangwala Park, Adarsh Nagar, Jaipur 302004, Rajasthan",
// //       "Contact_Person"=>"Mr. Inder",
// //       "Contact_No"=>"9413965957",
// //       "Email_ID"=>"rdcindra1234@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>34,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"Jodhpur",
// //       "Location"=>"Jodhpur",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE(P)",
// //       "REGISTERED_ADDRESS"=>"Paota Main Mandori Road Jodhpur",
// //       "Contact_Person"=>"Dr. Manish Dodwani",
// //       "Contact_No"=>"9602625688",
// //       "Email_ID"=>"rdc.jodhpur@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>35,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"Aastha hospital",
// //       "Location"=>"Jodhpur",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE(P)",
// //       "REGISTERED_ADDRESS"=>"H.NO=>139, 2ND POLO BEHIND AASTHA HOSPITAL, PAOTA JODHPUR",
// //       "Contact_Person"=>"Dr. Manish Dodwani",
// //       "Contact_No"=>"9602625688",
// //       "Email_ID"=>"rdc.jodhpur@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>36,
// //       "STATE"=>"Bihar",
// //       "BRANCH_NAME"=>"Shyamlal Chandrashekar Medical Collage",
// //       "Location"=>"Khagaria",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE PVT. LTD.",
// //       "REGISTERED_ADDRESS"=>"C/o Shyamlal Chandrashekar Medical Collage & Shaeed prabhu narayan Multispeciality Hospital Paramanandpur Khagaria 851205",
// //       "Contact_Person"=>"Mr. Durgesh",
// //       "Contact_No"=>"",
// //       "Email_ID"=>"rdcsaharsa19@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>37,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"KOTA",
// //       "Location"=>"Kota",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE(P)",
// //       "REGISTERED_ADDRESS"=>"1-D-14, 1ST FLOOR, SFS, TALWANDI, KOTA",
// //       "Contact_Person"=>"Mr. K. K. Sharma",
// //       "Contact_No"=>"9649099991",
// //       "Email_ID"=>"rdckota1@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>38,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"Sanjeevni Hospital",
// //       "Location"=>"KOTPUTLI",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE(P)",
// //       "REGISTERED_ADDRESS"=>"Garh Colony Kotputali Disst Jaipur 303108",
// //       "Contact_Person"=>"Mr. Ajay Kumar Yadav",
// //       "Contact_No"=>"9660911373",
// //       "Email_ID"=>"rdckotputli@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>39,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"Vinayak Hospital",
// //       "Location"=>"KOTPUTLI",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE(P)",
// //       "REGISTERED_ADDRESS"=>"Shakti Bihar Cut, N-H.48, Kotputli (303108)",
// //       "Contact_Person"=>"Mr. Ajay Kumar Yadav",
// //       "Contact_No"=>"9660911373",
// //       "Email_ID"=>"rdckotputli@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>40,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"KOTPUTLI",
// //       "Location"=>"KOTPUTLI",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE(P)",
// //       "REGISTERED_ADDRESS"=>"SHOP NO.-12,13 ,NEAR GOVT HOSP. NH -08 KOTPUTLI",
// //       "Contact_Person"=>"Mr. Ajay Kumar Yadav",
// //       "Contact_No"=>"9660911373",
// //       "Email_ID"=>"rdckotputli@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>41,
// //       "STATE"=>"HARYANA",
// //       "BRANCH_NAME"=>"Agarwal Hospital",
// //       "Location"=>"Kurukshetra",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE(P)",
// //       "REGISTERED_ADDRESS"=>"Salarpur Rd, Kurukshetra, Haryana 136118",
// //       "Contact_Person"=>"Mr. Pankaj Sharma",
// //       "Contact_No"=>"9079958398",
// //       "Email_ID"=>"rdckurushetra@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>42,
// //       "STATE"=>"HARYANA",
// //       "BRANCH_NAME"=>"Kurukshetra",
// //       "Location"=>"Kurukshetra",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE(P)",
// //       "REGISTERED_ADDRESS"=>"Red Rd, Sector 17, Jyoti Nagar, Kurukshetra, Haryana 136118",
// //       "Contact_Person"=>"Mr. Pankaj Sharma",
// //       "Contact_No"=>"9079958398",
// //       "Email_ID"=>"rdckurushetra@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>43,
// //       "STATE"=>"Madhya Pradesh",
// //       "BRANCH_NAME"=>"Morena",
// //       "Location"=>"Gwalior",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE(P)",
// //       "REGISTERED_ADDRESS"=>"Rathi Hospital Complex Near Nagar Nigam Office Morena 476001",
// //       "Contact_Person"=>"Dr. Alekh Saxena",
// //       "Contact_No"=>"8959038649",
// //       "Email_ID"=>"rdcgwalior@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>44,
// //       "STATE"=>"HARYANA",
// //       "BRANCH_NAME"=>"NARNAUL",
// //       "Location"=>"Narnaul",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE PVT. LTD.",
// //       "REGISTERED_ADDRESS"=>"Opp. Trends Showroom Herohona Chowk Nizampur Road Narnaul",
// //       "Contact_Person"=>"Mr. Rajendra Kumar",
// //       "Contact_No"=>"7733033215/8875831111",
// //       "Email_ID"=>"rdcnarnaul123@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>45,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"Near MDM Hospital Jodhpur",
// //       "Location"=>"Jodhpur",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE(P)",
// //       "REGISTERED_ADDRESS"=>"Shop No. B-11 Near Shiv Mandir Shastri Circle Jodhpur",
// //       "Contact_Person"=>"Dr. Manish Dodwani",
// //       "Contact_No"=>"9602625688",
// //       "Email_ID"=>"rdc.jodhpur@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>46,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"Neem ka thana",
// //       "Location"=>"Neem Ka Thana",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE PVT. LTD.",
// //       "REGISTERED_ADDRESS"=>"Opp. Govt Kapil Hospital Near Chanduka Garden Neem Ka Thana",
// //       "Contact_Person"=>"Mr. Rajendra Yadav",
// //       "Contact_No"=>"8432500849",
// //       "Email_ID"=>"rdcneemkathana@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>47,
// //       "STATE"=>"Bihar",
// //       "BRANCH_NAME"=>"Patna",
// //       "Location"=>"Patna",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE",
// //       "REGISTERED_ADDRESS"=>"In Front of Pillar No. 83 Raja Bajar Bailey Road Patna",
// //       "Contact_Person"=>"Mr. Durgesh",
// //       "Contact_No"=>"9462394420",
// //       "Email_ID"=>"rdcpatna19@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>48,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"PHCC",
// //       "Location"=>"Jaipur",
// //       "COMPANY_NAME"=>"RDC HEALTHCARE LLP",
// //       "REGISTERED_ADDRESS"=>"Near Shipra Path Thana, Aravali Marg, Mansarovar Jaipur, Rajasthan 302020",
// //       "Contact_Person"=>"Mr. Raj Ahuja",
// //       "Contact_No"=>"9983122991",
// //       "Email_ID"=>"phcc@rdccare.com"
// //     ],
// //     [
// //       "S.NO"=>49,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"Ratangargh",
// //       "Location"=>"Bikaner",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE",
// //       "REGISTERED_ADDRESS"=>"Near Kamla Drug Chotha Pulia Ratangar",
// //       "Contact_Person"=>"Mr. Vishnu Kumar Kachhawa",
// //       "Contact_No"=>"9214056337",
// //       "Email_ID"=>"rdcbikaner2017@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>50,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"RDC Agra Road",
// //       "Location"=>"Jaipur",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE PVT. LTD.",
// //       "REGISTERED_ADDRESS"=>"Near Jems Garden",
// //       "Contact_Person"=>"MR Santosh",
// //       "Contact_No"=>"8559995543",
// //       "Email_ID"=>"rdc.agraroad21@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>51,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"Ringus",
// //       "Location"=>"Jaipur",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE PVT LTD",
// //       "REGISTERED_ADDRESS"=>"First Floor Jangir Medical Opp. Govt. Hospital Ringus",
// //       "Contact_Person"=>"Mr Rajendra Yadav",
// //       "Contact_No"=>"8432500849",
// //       "Email_ID"=>"rdcringus@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>52,
// //       "STATE"=>"Bihar",
// //       "BRANCH_NAME"=>"SAHARSA",
// //       "Location"=>"SAHARSA",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE",
// //       "REGISTERED_ADDRESS"=>"Mahaveer Nagar, Bherdari, Bihar 852201",
// //       "Contact_Person"=>"Dr. Khalid",
// //       "Contact_No"=>"9667440908",
// //       "Email_ID"=>"rdcsaharsa19@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>53,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"SHRI HOSPITAL",
// //       "Location"=>"Jaipur",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE PVT. LTD.",
// //       "REGISTERED_ADDRESS"=>"4, Hare Krishna Marg, Shyam Vihar Colony, Vishnupuri, Model Town, Malviya Nagar, Jaipur, Rajasthan 302017",
// //       "Contact_Person"=>"Mr. Rohit Sharma",
// //       "Contact_No"=>"9887563365",
// //       "Email_ID"=>"shrihospitalpathlab@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>54,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"SIKAR",
// //       "Location"=>"Sikar",
// //       "COMPANY_NAME"=>"RELIABLE JAIPUR RESEARCH LABORATORY",
// //       "REGISTERED_ADDRESS"=>"SHOP NO. 12 , 13, BHASKAR HEIGHT, NEAR S. K. HOSPITAL , SIKAR",
// //       "Contact_Person"=>"Dr. Vibha Gupta",
// //       "Contact_No"=>"7976832839",
// //       "Email_ID"=>"rlabj.sikar@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>55,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"Sri Ganganagar",
// //       "Location"=>"Sri Ganganagar",
// //       "COMPANY_NAME"=>"RDC HEALTHCARE LLP",
// //       "REGISTERED_ADDRESS"=>"Suratgarh Hanumangarh Bypass, Ridhi Sidhi Enclave, Sri Ganganagar, Rajasthan 335001",
// //       "Contact_Person"=>"Mr. Sunil Yadav",
// //       "Contact_No"=>"8824313004",
// //       "Email_ID"=>"snmedantalab2018@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>56,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"Tara Nagar",
// //       "Location"=>"Tara Nagar",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE PVT. LTD.",
// //       "REGISTERED_ADDRESS"=>"Near Govt Hospital Tara Nagar Churu",
// //       "Contact_Person"=>"Ankit",
// //       "Contact_No"=>"7425864682",
// //       "Email_ID"=>"reliablediagnosticlab7@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>57,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"TONK",
// //       "Location"=>"Tonk",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE PVT. LTD.",
// //       "REGISTERED_ADDRESS"=>"Shree Laxmi Medicose Mahindi Bagh Patel Circel Tonk",
// //       "Contact_Person"=>"Mr. Roop Chand",
// //       "Contact_No"=>"9414245830",
// //       "Email_ID"=>"rdctonk26@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>58,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"Udaipur",
// //       "Location"=>"Udaipur",
// //       "COMPANY_NAME"=>"RDC PATHLABS LLP",
// //       "REGISTERED_ADDRESS"=>"24-C Madhuban Opp. Govt Post Office Chetak Circle Udaipur 313001",
// //       "Contact_Person"=>"Mr. Jaswant",
// //       "Contact_No"=>"8562067136",
// //       "Email_ID"=>"reliablediagnostic.udaipur@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>59,
// //       "STATE"=>"Punjab",
// //       "BRANCH_NAME"=>"KOTKAPURA",
// //       "Location"=>"Kotkapura",
// //       "COMPANY_NAME"=>"RELIABLE HEALTHCARE",
// //       "REGISTERED_ADDRESS"=>"New Kapil Diagnostic Centre SBS Chowk, Near Jaitu Chungi Kotkapura Faridkot Punjab 151204",
// //       "Contact_Person"=>"Mr. Ashish Gupta",
// //       "Contact_No"=>"9610857309",
// //       "Email_ID"=>"hanumangarh@rdccare.com"
// //     ],
// //     [
// //       "S.NO"=>60,
// //       "STATE"=>"HARYANA",
// //       "BRANCH_NAME"=>"ELLANABAD",
// //       "Location"=>"ELLANABAD",
// //       "COMPANY_NAME"=>"RELIABLE HEALTHCARE",
// //       "REGISTERED_ADDRESS"=>"Ward No. 09 Near Madan Jain Hospital Ellenabad Sirsa Haryana 125102",
// //       "Contact_Person"=>"Mr. Ashish Gupta",
// //       "Contact_No"=>"9610857309",
// //       "Email_ID"=>"hanumangarh@rdccare.com"
// //     ],
// //     [
// //       "S.NO"=>61,
// //       "STATE"=>"Bihar",
// //       "BRANCH_NAME"=>"Palm View",
// //       "Location"=>"Patna",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE(P)",
// //       "REGISTERED_ADDRESS"=>"PILAR NO. 4, PALM VIEW HOSPITAL, Bailey Rd, Jyotipuram Colony, Nandanpuri Colony, Rukanpura, Patna, Bihar 800014",
// //       "Contact_Person"=>"Mr. Durgesh",
// //       "Contact_No"=>"9462394420",
// //       "Email_ID"=>"rdcpatna19@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>62,
// //       "STATE"=>"J&K",
// //       "BRANCH_NAME"=>"SRI NAGAR",
// //       "Location"=>"Sri Nagar",
// //       "COMPANY_NAME"=>"RDC HEALTHCARE LLP",
// //       "REGISTERED_ADDRESS"=>"Nowgam Byepass Srinagar 190015",
// //       "Contact_Person"=>"MR. SHAHZAD",
// //       "Contact_No"=>"9596785531",
// //       "Email_ID"=>"Bioassaylab@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>63,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"Bijaynagar",
// //       "Location"=>"Bhilwara",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE(P)",
// //       "REGISTERED_ADDRESS"=>"PKV HOSPITAL",
// //       "Contact_Person"=>"MR. JITENDRA SHARMA",
// //       "Contact_No"=>"",
// //       "Email_ID"=>""
// //     ],
// //     [
// //       "S.NO"=>64,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"Sri Ganganagar",
// //       "Location"=>"Sri Ganganagar",
// //       "COMPANY_NAME"=>"RDC HEALTHCARE LLP",
// //       "REGISTERED_ADDRESS"=>"45 Sindhi Colony Opp. UTI Sri Ganganagr",
// //       "Contact_Person"=>"Mr. Sunil Yadav",
// //       "Contact_No"=>"9773330617",
// //       "Email_ID"=>"Ganganagar@rdccare.com"
// //     ],
// //     [
// //       "S.NO"=>65,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"SCR Hospital",
// //       "Location"=>"Jaipur",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE PVT. LTD.",
// //       "REGISTERED_ADDRESS"=>"S1 S- Block Opp. Hotel Mosaic RFC Colony Hanuman Nagar Extension Krishna Nagar Vaishali Nagar Sirsi Road Jaipur 302021",
// //       "Contact_Person"=>"MR. SHANKAR S RATHORE",
// //       "Contact_No"=>"7230068802",
// //       "Email_ID"=>"shnkars.rathore@rdccare.com"
// //     ],
// //     [
// //       "S.NO"=>66,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"JHUNJHUNU",
// //       "Location"=>"Jhunjhunu",
// //       "COMPANY_NAME"=>"RIYA RELIABLE DIAGNOSTIC CENTRE",
// //       "REGISTERED_ADDRESS"=>"Ward no. 08 C/o Indu Medicose, Opp. BDK Hospital Station Road Jhunjhnu 333001",
// //       "Contact_Person"=>"Mr. Laxman Singh",
// //       "Contact_No"=>"8003699767",
// //       "Email_ID"=>"Jhunjhunu@rdccare.com"
// //     ],
// //     [
// //       "S.NO"=>67,
// //       "STATE"=>"GUJARAT",
// //       "BRANCH_NAME"=>"BHARUCH",
// //       "Location"=>"Gujrat",
// //       "COMPANY_NAME"=>"Param Reliable Diagnostic Centre",
// //       "REGISTERED_ADDRESS"=>"52-53 Adrash Market Panchbatti Bharuch 392001",
// //       "Contact_Person"=>"MR AVINASH",
// //       "Contact_No"=>"7300044437",
// //       "Email_ID"=>"avinash.rawat@rdccare.com"
// //     ],
// //     [
// //       "S.NO"=>68,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"DHOLPUR",
// //       "Location"=>"Dholpur",
// //       "COMPANY_NAME"=>"Reliable Diagnostic Centre(P)",
// //       "REGISTERED_ADDRESS"=>"Statin Road Old Post Office City Branch 328001",
// //       "Contact_Person"=>"DR. ALEKH",
// //       "Contact_No"=>"8959038649",
// //       "Email_ID"=>"rdcgwalior@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>69,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"JHALAWAR",
// //       "Location"=>"Jhalawar",
// //       "COMPANY_NAME"=>"Reliable Diagnostic Centre(P)",
// //       "REGISTERED_ADDRESS"=>"",
// //       "Contact_Person"=>"MR KRISHNAKANT",
// //       "Contact_No"=>"",
// //       "Email_ID"=>""
// //     ],
// //     [
// //       "S.NO"=>70,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"CHITTORGARH",
// //       "Location"=>"Chittorgarh",
// //       "COMPANY_NAME"=>"RDC HEALTHCARE",
// //       "REGISTERED_ADDRESS"=>"Shri Ram Plaza In Front of Vaibhav Garden Udaipur Road Senthi Chittorgarh 312001",
// //       "Contact_Person"=>"DR. HIMMANI",
// //       "Contact_No"=>"9460607819",
// //       "Email_ID"=>"Chittorgarh@rdccare.com"
// //     ],
// //     [
// //       "S.NO"=>71,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"BAKSHI HOSPITAL",
// //       "Location"=>"Chittorgarh",
// //       "COMPANY_NAME"=>"RDC HEALTHCARE",
// //       "REGISTERED_ADDRESS"=>"1B, Udaipur Rd, Near Apna Medical Store, Pratap Nagar, Chittorgarh, Rajasthan 312001",
// //       "Contact_Person"=>"DR. HIMMANI",
// //       "Contact_No"=>"9460607819",
// //       "Email_ID"=>"Chittorgarh@rdccare.com"
// //     ],
// //     [
// //       "S.NO"=>72,
// //       "STATE"=>"Rajasthan",
// //       "BRANCH_NAME"=>"DEEG",
// //       "Location"=>"Deeg",
// //       "COMPANY_NAME"=>"RELIABLE DIAGNOSTIC CENTRE PVT. LTD.",
// //       "REGISTERED_ADDRESS"=>"Beside Government Hospital New Sarak",
// //       "Contact_Person"=>"Mr. Yadvir",
// //       "Contact_No"=>"9694263689",
// //       "Email_ID"=>"Yadvir.blal@gmail.com"
// //     ],
// //     [
// //       "S.NO"=>73,
// //       "STATE"=>"ASSAM",
// //       "BRANCH_NAME"=>"TEJPUR",
// //       "Location"=>"Tejpur",
// //       "COMPANY_NAME"=>"RDC HEALTHCARE LLP",
// //       "REGISTERED_ADDRESS"=>"",
// //       "Contact_Person"=>"",
// //       "Contact_No"=>"",
// //       "Email_ID"=>""
// //     ]
// //   ];
        
//                 $store = City::select('id','name','lat','lng','city')->where('lat',null)->get();
//                 $apiKey = 'AIzaSyCobHx38xPOGViCcqgs2uz_1UT94ls3Y_w';
//                 foreach($store as $s){
//                     $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($s->name) . "&key=" . $apiKey;
                    
//                     $ch = curl_init();

//                     curl_setopt($ch, CURLOPT_URL, $url);
//                     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                
//                     // Execute the request
//                     $response = curl_exec($ch);
                
//                     // Check for cURL errors
//                     if (curl_errno($ch)) {
//                         echo 'Curl error: ' . curl_error($ch);
//                         return ['lat' => null, 'lng' => null];
//                     }
                
//                     // Close cURL
//                     curl_close($ch);
                
//                     // Decode the JSON response
//                     $data = json_decode($response);
                
//                     // Check if the response is valid and has results
//                     if ($data->status === 'OK') {
//                          $lat = round($data->results[0]->geometry->location->lat, 6); // Round to 6 decimal places
//                             $lng = round($data->results[0]->geometry->location->lng, 6); // Round to 6 decimal places
       
//                         // $s->lat = $data->results[0]->geometry->location->lat;
//                         // $s->lng = $data->results[0]->geometry->location->lng;
//                         // return ['lat' => $lat, 'lng' => $lng];
//                     }
//                     $update = City::find($s->id);
//                     $update->lat = $lat;
//                     $update->lng=$lng;
//                     // $update->save();
//                     echo "<pre>";
//                     print_r("$s");
                    
                            
//                 }
// //   dd('Done');
  
//   }
    public function show_login(){
        $setting = Setting::find(1);
        return view("admin.login")->with("setting",$setting);
    }
    public function post_login(Request $request){
        $checkuser=User::where("email",$request->get("email"))->where("password",$request->get("password"))->where("user_type",'1')->first();      
        if($checkuser){
            Auth::login($checkuser, true);
            Session::put("id",$checkuser->id); 
            Session::put("name",$checkuser->name); 
            $setting = Setting::find(1); 
            Session::put("is_rtl",$setting->is_rtl);
            Session::put("is_demo",$setting->is_demo);
            Session::put("logo",asset('public/img').'/'.$setting->footer_logo);
            Session::put("favicon",asset('public/img').'/'.$setting->favicon);
            if($request->get("rem_me")==1){
                setcookie('email', $request->get("email"), time() + (86400 * 30), "/");
                setcookie('password',$request->get("password"), time() + (86400 * 30), "/");
                setcookie('remember',1, time() + (86400 * 30), "/");
            } 
            return redirect()->route("admin-dashboard");
        }else{
            Session::flash('message',__('message.Login credentials are wrong')); 
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
    }
    public function show_dashboard(){ 
        $totalcategory= count(Category::where('is_deleted','0')->get());
        $totalcity= count(City::get()); 
        $getcurrency = Setting::find(1);
        $currency = explode("-",$getcurrency->currency);
        $totalsales = Orders::sum('final_total');   
        $totalorder = count(Orders::all()); 
        $completeorder = count(Orders::where("status","7")->get());  
        $pendingorders = count(Orders::whereIn("status",array(2,6,5))->get());
        $totalusers = count(User::where("user_type","3")->get());
        $totalmanager = count(User::where("user_type","2")->get());  
        $totalpackage = count(Package::all());
        $totalprofile = count(Profiles::all());
        $totalparameter = count(Parameter::all());
        $totalpopular = count(Popular_package::all());

        return view("admin.dashboard")->with("totalcategory",$totalcategory)->with("totalcity",$totalcity)->with("totalsales",$totalsales)->with("currency",$currency[1])->with("totalorder",$totalorder)->with("completeorder",$completeorder)->with("pendingorders",$pendingorders)->with("totalusers",$totalusers)->with("totalmanager",$totalmanager)->with("totalpackage",$totalpackage)->with("totalprofile",$totalprofile)->with("totalparameter",$totalparameter)->with("totalpopular",$totalpopular);
    }
     public function logout(){
        Auth::logout();
        return redirect()->route('admin-login');
    }
     public function show_admin_profile(){
        return view("admin.editprofile");    
    }
    public function show_update_admin_profile(Request $request){
        $store = User::find(Auth::id());
       // $store->username = $request->get("username");
        $store->name = $request->get("name");
        $store->email = $request->get("emailId");
        if($request->file("upload_image")){
            if(Auth::user()->profile_pic!=""){
                $this->removeImage('profile/' . $store->profile_pic);
            }             
            $store->profile_pic = $this->fileuploadFileImage($request,'profile','upload_image');
        }        
        $store->save();
        Session::flash('message',__('message.Profile Update Successfully')); 
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }
    public function change_password(Request $request){
        return view("admin.changepassword");
    }

    public function update_check_admin_password($val){
        if($val== Auth::user()->password){
            return 0;
        }
        return 1;
    }

    public function show_update_admin_change_password(Request $request){
        $store = User::find(Auth::id());
        $store->password = $request->get("newPassword");
        $store->save();
        Session::flash('message',__('message.Password Update Successfully')); 
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }

    
   static public function generate_timezone_list(){
    static $regions = array(
      DateTimeZone::AFRICA,
      DateTimeZone::AMERICA,
      DateTimeZone::ANTARCTICA,
      DateTimeZone::ASIA,
      DateTimeZone::ATLANTIC,
      DateTimeZone::AUSTRALIA,
      DateTimeZone::EUROPE,
      DateTimeZone::INDIAN,
      DateTimeZone::PACIFIC,
    );

    $timezones = array();
    foreach($regions as $region) {
      $timezones = array_merge($timezones, DateTimeZone::listIdentifiers($region));
    }

    $timezone_offsets = array();
    foreach($timezones as $timezone) {
      $tz = new DateTimeZone($timezone);
      $timezone_offsets[$timezone] = $tz->getOffset(new DateTime);
    }

    asort($timezone_offsets);

    $timezone_list = array();
    
    foreach($timezone_offsets as $timezone=>$offset){
      $offset_prefix = $offset < 0 ? '-' : '+';
      $offset_formatted = gmdate('H:i', abs($offset));
      $pretty_offset = "UTC${offset_prefix}${offset_formatted}";
      $timezone_list[] = "(${pretty_offset}) $timezone";
    }

    return $timezone_list;
    ob_end_flush();
  }
    public function showsetting($id){
       $setting=Setting::find(1);
       $payment=PaymentGateway::all();
        $getallkeys = PaymentGateway::all();
        $ls = array();
        foreach($getallkeys as $g){
            $ls[$g->payment_gateway_name."_".$g->key_name] = $g->meta_value;
        }
        $timezone_list = $this->generate_timezone_list();
        
       return view("admin.setting.setting")->with("id",$id)->with("data",$setting)->with("payment",$ls)->with("timezone_list",$timezone_list);
   }
   public function remove_slider($id,$col){
       // dd($col);       
        $setting=Setting::first();
       
        $existingImagePaths = unserialize($setting->main_banner);
        if (array_key_exists($id, $existingImagePaths)) {
        // Remove the element with index $id
        unset($existingImagePaths[$id]);
        }
        
        
        $setting->$col = serialize($existingImagePaths);
        $setting->save();
        Session::flash('message','Delete Successfully'); 
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
   }

    public function savebasicsetting(Request $request)
    {
        $setting=Setting::find(1);
        $setting->email = $request->get("email");
        $setting->phone = $request->get("phone");
        $setting->address = $request->get("address");
        $setting->currency = $request->get("currency");
        $setting->txt_charge = $request->get("txt_charge");
        $setting->timezone = $request->get("timezone");
        $setting->is_rtl = $request->get("is_rtl")?'1':'0';
        $logo = $setting->logo;
        $favicon = $setting->favicon;
        if($request->file("logo_image"))
        {            
            $file = $request->file('logo_image');
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension() ?: 'png';
            $folderName = '/img';
            $picture = time().rand() . '.' . $extension;
            $destinationPath = public_path() . $folderName;
            $request->file('logo_image')->move($destinationPath, $picture);
            $setting->logo = $picture; 
            $img_url = asset('public/img').'/'.$logo;
            if(file_exists($img_url)){
                unlink($img_url);
            }
        }
        if($request->file("favicon_image"))
        {
            $file = $request->file('favicon_image');
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension() ?: 'png';
            $folderName = '/img';
            $picture = time().rand() . '.' . $extension;
            $destinationPath = public_path() . $folderName;
            $request->file('favicon_image')->move($destinationPath, $picture);
            $setting->favicon = $picture;
            $img_url = asset('public/img').'/'.$favicon;
            if(file_exists($img_url)){
                unlink($img_url);
            }
        }
        $setting->save();
        Session::flash('message',__('message.Basic Information Save Successfully')); 
        Session::flash('alert-class', 'alert-success');
        return redirect('setting/2');
   }


    public function server_key(Request $request)
    {
        $setting=Setting::find(1);
        $setting->android_server_key = $request->get("android_server_key");
        $setting->ios_server_key = $request->get("ios_server_key");
        $setting->save();
        // Session::flash('message',"Server Keys Save Successfully");
        Session::flash('message',__('message.Server Keys Save Successfully'));
        Session::flash('alert-class', 'alert-success');
        return redirect('setting/4');
    }

    public function change_payment_detail(Request $request){        
        if($request->get("payment_method")=="Braintree"){
            PaymentGateway::where("payment_gateway_name","Braintree")->where("key_name","is_active")->update(["meta_value"=>$request->get("status")]);
            PaymentGateway::where("payment_gateway_name","Braintree")->where("key_name","environment")->update(["meta_value"=>$request->get("environment")]);
            PaymentGateway::where("payment_gateway_name","Braintree")->where("key_name","merchantId")->update(["meta_value"=>$request->get("merchantId")]);
            PaymentGateway::where("payment_gateway_name","Braintree")->where("key_name","publicKey")->update(["meta_value"=>$request->get("publicKey")]);
            PaymentGateway::where("payment_gateway_name","Braintree")->where("key_name","privateKey")->update(["meta_value"=>$request->get("privateKey")]);
            PaymentGateway::where("payment_gateway_name","Braintree")->where("key_name","TokenizationKeys")->update(["meta_value"=>$request->get("TokenizationKeys")]);

            $msg = __('message.Braintree Payment Details Save Successfully');

        }
        if($request->get("payment_method")=="Stripe"){
             PaymentGateway::where("payment_gateway_name","Stripe")->where("key_name","is_active")->update(["meta_value"=>$request->get("status")]);
            PaymentGateway::where("payment_gateway_name","Stripe")->where("key_name","public_key")->update(["meta_value"=>$request->get("public_key")]);
            PaymentGateway::where("payment_gateway_name","Stripe")->where("key_name","secert_key")->update(["meta_value"=>$request->get("secert_key")]);
            PaymentGateway::where("payment_gateway_name","Stripe")->where("key_name","currency")->update(["meta_value"=>$request->get("currency")]);

            $msg = __('message.Stripe Payment Details Save Successfully');

        }
        Session::flash('message',$msg);
        Session::flash('alert-class', 'alert-success');
        return redirect('setting/3');
    }

    public function show_contactus(){
        return view("admin.contact");
    }

    public function show_update_website_details(Request $request){
       
        $setting=Setting::find(1);
        $setting->appstore_url = $request->get("appstore_url");
        $setting->playstore_url = $request->get("playstore_url");
        $setting->largest_phlebotomist = $request->get("largest_phlebotomist");
        $setting->satisfied_customers = $request->get("satisfied_customers");
        $setting->total_test = $request->get("total_test");
        $setting->presence_cities = $request->get("presence_cities");
        $footer_logo = $setting->footer_logo;
        $main_banner = $setting->main_banner;
        $search_banner = $setting->search_banner;
        $mobile_app_banner = $setting->mobile_app_banner;
        if($request->file("footer_logo"))
        {
            $file = $request->file('footer_logo');
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension() ?: 'png';
            $folderName = '/img';
            $picture = time().rand() . '.' . $extension;
            $destinationPath = public_path() . $folderName;
            $request->file('footer_logo')->move($destinationPath, $picture);
            $setting->footer_logo = $picture;
            $img_url = asset('public/img').'/'.$footer_logo;
            if(file_exists($img_url)){
                unlink($img_url);
            }
        }
        
        $images = $request->file('main_banner');

        if ($images) {
            $imagePaths = [];
        
            foreach ($images as $image) {
                $file = $image;
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension() ?: 'png';
                $folderName = '/img';
                $picture = time() . rand() . '.' . $extension;
                $destinationPath = public_path() . $folderName;
                $file->move($destinationPath, $picture); // Move the file, not the array
                $imagePaths[] = $folderName . '/' . $picture; // Store the image path in the array
            }
            $existingImagePaths = unserialize($request->old_main_banner);

            $updatedImagePaths = array_merge($existingImagePaths, $imagePaths);

            $setting->main_banner = serialize($updatedImagePaths); // Serialize the array before storing it in the database
        }
        
        $imagesapp = $request->file('app_banner');

        if ($imagesapp) {
            $imagePaths = [];
            foreach ($imagesapp as $image) {
                $file = $image;
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension() ?: 'png';
                $folderName = '/img';
                $picture = time() . rand() . '.' . $extension;
                $destinationPath = public_path() . $folderName;
                $file->move($destinationPath, $picture); // Move the file, not the array
                $imagePaths[] = $folderName . '/' . $picture; // Store the image path in the array
            }
           $existingImagePaths = unserialize($request->old_app_banner);

           $updatedImagePaths = array_merge($existingImagePaths, $imagePaths);

            $setting->app_banner = serialize($updatedImagePaths);
        }
        
        // if($request->file("main_banner"))
        // {
        //     $file = $request->file('main_banner');
        //     $filename = $file->getClientOriginalName();
        //     $extension = $file->getClientOriginalExtension() ?: 'png';
        //     $folderName = '/img';
        //     $picture = time().rand() . '.' . $extension;
        //     $destinationPath = public_path() . $folderName;
        //     $request->file('main_banner')->move($destinationPath, $picture);

           
        // }
        
        
        if($request->file("search_banner"))
        {
            $file = $request->file('search_banner');
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension() ?: 'png';
            $folderName = '/img';
            $picture = time().rand() . '.' . $extension;
            $destinationPath = public_path() . $folderName;
            $request->file('search_banner')->move($destinationPath, $picture);
            $setting->search_banner = $picture;
            $img_url = asset('public/img').'/'.$search_banner;
            if(file_exists($img_url)){
                unlink($img_url);
            }
        }

        if($request->file("mobile_app_banner"))
        {
            $file = $request->file('mobile_app_banner');
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension() ?: 'png';
            $folderName = '/img';
            $picture = time().rand() . '.' . $extension;
            $destinationPath = public_path() . $folderName;
            $request->file('mobile_app_banner')->move($destinationPath, $picture);
            $setting->mobile_app_banner = $picture;
            $img_url = asset('public/img').'/'.$mobile_app_banner;
            if(file_exists($img_url)){
                unlink($img_url);
            }
        }
        $setting->save();
     
        Session::flash('message',__('message.Website Info Save Successfully'));
        Session::flash('alert-class', 'alert-success');
        return redirect('setting/4');
    }
    public function show_update_wallet_details(Request $request){
       
        $setting=Setting::find(1);
        
        if(isset($request->about)){
            $setting->about = $request->about;
            $no= 9;
        }elseif(isset($request->t_s)){
            $setting->t_s = $request->t_s;
            $no= 10;
        }elseif(isset($request->privacy)){
            $setting->privacy = $request->privacy;
            $no= 11;
        }elseif(isset($request->franchise)){
            $setting->franchise = $request->franchise;
            $no= 12;
        }elseif(isset($request->refund_policy)){
            $setting->refund_policy = $request->refund_policy;
            $no= 13;
        }else{
            $setting->wallet_cashback_per = $request->wallet_cashback_per;
            $setting->wallet_cashback_point = $request->wallet_cashback_point;
            $setting->wallet_point_on_register = $request->wallet_point_on_register;
            $no= 8;
        }
      
       
     
     
        $setting->save();

        Session::flash('message', 'Info Save Successfully');
        Session::flash('alert-class', 'alert-success');
        return redirect('setting/'.$no);
    }

    public function contact_datatable(){
         $contact = Contactus::all();
         return DataTables::of($contact)
            ->editColumn('id', function ($contact) {
                return $contact->id;
            })
            ->editColumn('name', function ($contact) {
                return $contact->name;
            }) 
            ->editColumn('email', function ($contact) {
                return $contact->email;
            }) 
            ->editColumn('phone', function ($contact) {
                return $contact->phone;
            }) 
            ->editColumn('subject', function ($contact) {
                return $contact->subject;
            }) 
            ->editColumn('message', function ($contact) {
                return $contact->message;
            })     
            ->editColumn('action', function ($contact) {

                $deletetext = __('message.Delete');
                $delete = url('deletecontact',array('id'=>$contact->id));
                // The mailto/Gmail-compose params were previously concatenated
                // raw — any subject/message containing "&", "#", "%" or a
                // newline (all common in free-text submissions) broke the
                // link by prematurely truncating or corrupting the query
                // string. urlencode() each dynamic piece instead.
                $gmail = 'https://mail.google.com/mail/?view=cm&fs=1'
                    .'&to='.urlencode($contact->email)
                    .'&su='.urlencode($contact->subject)
                    .'&body='.urlencode($contact->message);
                return '<div class="adm-row-actions">'
                    .'<a href="'.$gmail.'" target="_blank" class="adm-cat-eye" title="Reply by email"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg></a>'
                    .'<a onclick="delete_record(' . "'" . $delete. "'" . ')" class="adm-act adm-act--red"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>'.$deletetext.'</a>'
                    .'</div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function deletecontact($id){
        $store = Contactus::where("id",$id)->delete();
        // Session::flash('message',"Contact Delete Successfully");
        Session::flash('message',__('message.Contact Delete Successfully')); 
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }

    public function show_news(){
        return view("admin.news");
    }

    public function sendnews(Request $request){
          $msg=$request->get("news");
          $getall=News::all();
          $setting=Setting::find(1);
          foreach($getall as $g){
              $data=array();
              $data['email']=$g->email;
              $data['msg']=$msg;
              try {
                      $result=Mail::send('email.news', ['user' => $data], function($message) use ($data){
                         $message->to($data['email'],'customer')->subject(__('message.site_name'));
                      });
            
               } catch (\Exception $e) {
              }        
          }
       Session::flash('message',__('message.News Send Successfully'));
       Session::flash('alert-class', 'alert-success');
       return redirect()->back();
    }


}
