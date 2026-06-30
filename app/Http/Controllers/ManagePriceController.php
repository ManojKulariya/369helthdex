<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Package;
use App\Models\Parameter;
use App\Models\Profiles;
use App\Models\TestDetails;
use App\Models\SampleType;
use Session;
use App\Models\ProfileBranch;
use App\Models\PackageBranch;
use App\Models\ParameterBranch;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use ZipArchive;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
class ManagePriceController extends Controller
{
    public function export_master_data($type){
      
        ini_set('memory_limit', '512M'); // or 1024M if needed
        set_time_limit(300);
        if($type == 'parameter'){
            $profileIds = Parameter::get();
        }
        if($type == 'package'){
            $profileIds = Package::get();
        }
        if($type == 'profile'){
            $profileIds = Profiles::get();
        }
        $sampleTypeList = SampleType::pluck('sample_name')->map(function ($name) {
            return str_replace('"', '""', $name); // Escape double quotes
        })->toArray();
        
        $sampleListString = '"' . implode(',', $sampleTypeList) . '"';
        
        $recclist = ['Male','Female','Both'];
        $recclistListString = '"' . implode(',', $recclist) . '"';
        
        $isfasting = ['No','Yes'];
        $isfastingListString = '"' . implode(',', $isfasting) . '"';
        
        $zip = new ZipArchive();
        $zipFileName = 'master_data_'.$type.'_'. date('Y-m-d_H-i-s') . '.zip';
        $zipFilePath = storage_path("app/$zipFileName");
        if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                // Header
                $sheet->setCellValue('A1', 'ID');
                $sheet->setCellValue('B1', 'Name');
                // $sheet->setCellValue('C1', "$test Name");
                $sheet->setCellValue('C1', 'Sort Order');
                $sheet->setCellValue('D1', 'Report Time');
                $sheet->setCellValue('E1', 'Sample Type');
                $sheet->setCellValue('F1', 'Is Fast Required');
                $sheet->setCellValue('G1', 'Is Fast Required');
                $sheet->setCellValue('H1', 'Tag');
                $sheet->setCellValue('I1', 'Test Recommended For');
                $sheet->setCellValue('J1', 'Recommended For Age');
                $sheet->setCellValue('K1', 'Description');
                // $sheet->setCellValue('L1', 'Description');
                $rowNum = 2;
                foreach ($profileIds as $profileId) {
                    $selectedSampleTypeId = explode(',',$profileId->sample_type);
                    // dd($selectedSampleTypeId);
                    $selectedSampleType = SampleType::whereIn('id',$selectedSampleTypeId)->pluck('sample_name')->map(function ($name) {
                        return str_replace('"', '""', $name); // Escape double quotes
                    })->toArray();
                    $selectedSampleType=implode(',',$selectedSampleType);
                    // dd($selectedSampleType);

                    $included = '';
                    $parameter = 0;
                    $b = array();
                    if($type == 'package'){
                        $textname = $profileId->name;
                            $find_pa = TestDetails::where("package_id", $profileId->id)->get();
                            foreach ($find_pa as $d) {
                                $p_data='';
                                if ($d->type == 1) {
                                    $p_data = Parameter::find($d->type_id) ? Parameter::find($d->type_id)->name : '';
                                    $parameter +=1;
                                    $b[] = "$p_data (Parameter)";
                                }
                                if ($d->type == 2) {
                                    $a = Profiles::find($d->type_id);
                                    $p_data = Profiles::find($d->type_id) ? Profiles::find($d->type_id)->profile_name : '';
                                    $b[] = "$p_data (Profile)";
                                }
                            }
                            $included = implode(PHP_EOL,$b);
                            $noprms = count($b);
                    }
                    if($type == 'profile'){
                        $textname = $profileId->profile_name;
                        $arr = explode(",", $profileId->no_of_parameter);
                        foreach ($arr as $a) {
                            $parameter = Parameter::find($a);
                            if ($parameter) {
                                $b[] = "$parameter->name (Parameter)";
                                
                            }
                        }
                        $included = implode(PHP_EOL,$b);
                        $noprms = count($b);
                    }
                    if($type == 'parameter'){
                        $textname = $profileId->name;
                        $noprms =1;
                    }
                  
                    $sheet->setCellValue("A$rowNum", $profileId->id);
                    $sheet->setCellValue("B$rowNum", $textname);
                    $sheet->setCellValue("C$rowNum", $profileId->sort_order);  
                    
                    $recom = "$profileId->test_recommended_for $profileId->test_recommended_for_age";
                    if($profileId->fasting_time == 1){
                        $fasting = "Yes";
                    }else{
                        $fasting = "No";
                    }
                    $sheet->setCellValue("D$rowNum", $profileId->report_time);
                    $sheet->setCellValue("E$rowNum", $selectedSampleType);
                    
                    
                    $sheet->setCellValue("F$rowNum", $fasting);
                    $validation = $sheet->getCell("F$rowNum")->getDataValidation();
                    $validation->setType(DataValidation::TYPE_LIST);
                    $validation->setErrorStyle(DataValidation::STYLE_STOP);
                    $validation->setAllowBlank(true);
                    $validation->setShowInputMessage(true);
                    $validation->setShowErrorMessage(true);
                    $validation->setShowDropDown(true);
                    $validation->setFormula1($isfastingListString);
                    $sheet->setCellValue("G$rowNum", $profileId->fast_time);
                    
                    $sheet->setCellValue("H$rowNum", $profileId->tag);
                    
                    $sheet->setCellValue("I$rowNum", $profileId->test_recommended_for);
                    $validation = $sheet->getCell("I$rowNum")->getDataValidation();
                    $validation->setType(DataValidation::TYPE_LIST);
                    $validation->setErrorStyle(DataValidation::STYLE_STOP);
                    $validation->setAllowBlank(true);
                    $validation->setShowInputMessage(true);
                    $validation->setShowErrorMessage(true);
                    $validation->setShowDropDown(true);
                    $validation->setFormula1($recclistListString);
                    
                    $sheet->setCellValue("J$rowNum", $profileId->test_recommended_for_age);

                    // $sheet->setCellValue("F$rowNum", $type);
                    $sheet->setCellValue("K$rowNum", $profileId->description);
                    
                    // $sheet->setCellValue("H$rowNum", $included);
                    // $sheet->setCellValueExplicit("H$rowNum", $included, DataType::TYPE_STRING);
                    // // Enable wrap text
                    // $sheet->getStyle("H$rowNum")->getAlignment()->setWrapText(true);

                    // $sheet->setCellValue("I$rowNum", $noprms);
                    // $sheet->setCellValue("J$rowNum", $recom);
                    // $sheet->setCellValue("K$rowNum", $profileId->report_time);
                    // $sheet->setCellValue("L$rowNum", $fasting);
    
                    $rowNum++;
                }
    
                $tempFileName = "master_data_{$type}.xlsx";
                $tempFilePath = storage_path("app/$tempFileName");
    
                $writer = new Xlsx($spreadsheet);
                $writer->save($tempFilePath);
    
                // Add to zip
                $zip->addFile($tempFilePath, $tempFileName);
                $tempFiles[] = $tempFilePath;
            
    
            $zip->close();
            foreach ($tempFiles as $file) {
                if (file_exists($file)) {
                    unlink($file);
                }
            }
    
            // Set headers and return ZIP for download
            return response()->download($zipFilePath)->deleteFileAfterSend(true);
        } else {
            return response()->json(['error' => 'Failed to create zip file'], 500);
        }
    }
    public function export_multiple_center_prices(Request $request)
    {
        $test_type = $request->test_type;
        $branch = $request->center;
        ini_set('memory_limit', '512M'); // or 1024M if needed
        set_time_limit(600);
        $tempFiles = [];
        if($test_type == 'parameter'){
            $profileIds = Parameter::get();
        }
        if($test_type == 'package'){
            $profileIds = Package::get();
        }
        if($test_type == 'profile'){
            $profileIds = Profiles::get();
        }
        $zip = new ZipArchive();
        $zipFileName = 'center_prices_'.$test_type.'_'. date('Y-m-d_H-i-s') . '.zip';
        $zipFilePath = storage_path("app/$zipFileName");
    
        if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
            foreach ($branch as $row) {
                $rw = User::find($row);
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                // Header
                $sheet->setCellValue('A1', 'Center ID');
                $sheet->setCellValue('B1', 'Center Name');
                $sheet->setCellValue('C1', "$test_type Name");
                $sheet->setCellValue('D1', 'Price');
                $sheet->setCellValue('E1', 'Saleable Price');
                $sheet->setCellValue('F1', 'Type');
                $sheet->setCellValue('G1', 'TestId');
                $sheet->setCellValue('H1', 'Included');
                $sheet->setCellValue('I1', 'No. of Parameters');
                $sheet->setCellValue('J1', 'Recommended For');
                $sheet->setCellValue('K1', 'Reporting Time');
                $sheet->setCellValue('L1', 'Fasting Required');
                $rowNum = 2;
                foreach ($profileIds as $profileId) {
                        $mrp = 0;
                        $price = 0;
                        $included = '';
                        $parameter = 0;
                        $b = array();
                        if($test_type == 'package'){
                            $textname = $profileId->name;
                            $find_pa = TestDetails::where("package_id", $profileId->id)->get();
                            foreach ($find_pa as $d) {
                                $p_data='';
                                if ($d->type == 1) {
                                    $p_data = Parameter::find($d->type_id) ? Parameter::find($d->type_id)->name : '';
                                    $parameter +=1;
                                    $b[] = "$p_data (Parameter)";
                                }
                                if ($d->type == 2) {
                                    $a = Profiles::find($d->type_id);
                                    $p_data = Profiles::find($d->type_id) ? Profiles::find($d->type_id)->profile_name : '';
                                    $b[] = "$p_data (Profile)";
                                    if ($a) {
                                        $arr = explode(",", $a->no_of_parameter);
                                       
                                    }
                                }
                                
                            }
                            $included = implode(PHP_EOL,$b);
                            $noprms = count($b);
                            $pricedata = PackageBranch::where('branch_id', $row)->where('package_id', $profileId->id)->get();
                        }
                        if($test_type == 'profile'){
                            $textname = $profileId->profile_name;
                            $arr = explode(",", $profileId->no_of_parameter);
                            foreach ($arr as $a) {
                                $parameter = Parameter::find($a);
                                if ($parameter) {
                                    $b[] = "$parameter->name (Parameter)";
                                    
                                }
                            }
                            $included = implode(PHP_EOL,$b);
                            $noprms = count($b);
                            
                            $pricedata = ProfileBranch::where('branch_id', $row)->where('profile_id', $profileId->id)->get();
                        }
                        if($test_type == 'parameter'){
                            $textname = $profileId->name;
                            $noprms =1;
                            $pricedata = ParameterBranch::where('branch_id', $row)->where('parameter_id', $profileId->id)->get();
                        }
                        
                        $price_map = [];
                        foreach ($pricedata as $p) {
                            $price = $p->price != 0 ? $p->price : $price;
                            $mrp = $p->mrp != 0 ? $p->mrp : $mrp;
                            $price_map[$row] = ['price' => $price , 'mrp' => $p->mrp, 'test_type' => 'profile', 'test_id' => $p->test_id];
                        }
                    $price = $price_map[$row]['price'] ?? $price;
                    $mrp = $price_map[$row]['mrp'] ?? $mrp;
    
                    $sheet->setCellValue("A$rowNum", $row);
                    $sheet->setCellValue("B$rowNum", $rw->name);
                    $sheet->setCellValue("C$rowNum", "$textname");  
                    
                    $recom = "$profileId->test_recommended_for $profileId->test_recommended_for_age";
                    if($profileId->fasting_time == 1){
                        $fasting = "Yes, $profileId->fast_time";
                    }else{
                        $fasting = "No";
                    }
                    $sheet->setCellValue("D$rowNum", $price);
                    $sheet->setCellValue("E$rowNum", $mrp);
                    $sheet->setCellValue("F$rowNum", $test_type);
                    $sheet->setCellValue("G$rowNum", $profileId->id);
                    // $sheet->setCellValue("H$rowNum", $included);
                    $sheet->setCellValueExplicit("H$rowNum", $included, DataType::TYPE_STRING);

                    // Enable wrap text
                    $sheet->getStyle("H$rowNum")->getAlignment()->setWrapText(true);

                    $sheet->setCellValue("I$rowNum", $noprms);
                    $sheet->setCellValue("J$rowNum", $recom);
                    $sheet->setCellValue("K$rowNum", $profileId->report_time);
                    $sheet->setCellValue("L$rowNum", $fasting);
    
                    $rowNum++;
                }
    
                $tempFileName = "center_prices_{$test_type}_{$rw->name}.xlsx";
                $tempFilePath = storage_path("app/$tempFileName");
    
                $writer = new Xlsx($spreadsheet);
                $writer->save($tempFilePath);
                // Add to zip
                $zip->addFile($tempFilePath, $tempFileName);
                $tempFiles[] = $tempFilePath;
            }
    
            $zip->close();
            foreach ($tempFiles as $file) {
                if (file_exists($file)) {
                    // unlink($file);
                }
            }
            return response()->download($zipFilePath)->deleteFileAfterSend(true);
        } else {
            return response()->json(['error' => 'Failed to create zip file'], 500);
        }
    }

    public function import_multiple_center_prices(Request $request){
        $testType = $request->input('test_type');
        $centers = $request->input('center');
        $files = $request->file('excel_file');
        foreach ($files as $index => $file) {
            $centerIdFromForm = $centers[$index];
            $spreadsheet = IOFactory::load($file->getPathname());
            $sheet = $spreadsheet->getSheet(0);
            $rows = $sheet->toArray();
            
            for ($i = 1; $i < count($rows); $i++) {
                $price = $rows[$i][3];
                $mrp = $rows[$i][4];
                $testId = $rows[$i][6]; // Assuming test ID is in Excel file
                if($price != 0 || $mrp != 0){
                if($testType == 'profile'){
                    $ProfileBranch = ProfileBranch::where('branch_id',$centerIdFromForm)->where('profile_id',$testId)->first();
                    if(!$ProfileBranch){
                       $ProfileBranch = new ProfileBranch();
                       $ProfileBranch->branch_id = $centerIdFromForm;
                       $ProfileBranch->profile_id = $testId;
                    }
                    $ProfileBranch->mrp = $mrp;
                    $ProfileBranch->price = $price;
                    $ProfileBranch->save();
                }
                if($testType == 'parameter'){
                    $ProfileBranch = ParameterBranch::where('branch_id',$centerIdFromForm)->where('parameter_id',$testId)->first();
                    if(!$ProfileBranch){
                       $ProfileBranch = new ParameterBranch();
                       $ProfileBranch->branch_id = $centerIdFromForm;
                       $ProfileBranch->parameter_id = $testId;
                    }
                    $ProfileBranch->mrp = $mrp;
                    $ProfileBranch->price = $price;
                    $ProfileBranch->save();
                }
                if($testType == 'package'){
                    $ProfileBranch = PackageBranch::where('branch_id',$centerIdFromForm)->where('package_id',$testId)->first();
                    if(!$ProfileBranch){
                       $ProfileBranch = new PackageBranch();
                       $ProfileBranch->branch_id = $centerIdFromForm;
                       $ProfileBranch->package_id = $testId;
                    }
                    $ProfileBranch->mrp = $mrp;
                    $ProfileBranch->price = $price;
                    $ProfileBranch->save();
                }
            }
                
                
            }
        }
        Session::flash('message', 'price updated!');
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }
   
    public function export_center_prices($profileId,$test_type)
    {
        $branch = User::where('user_type', 2)->get();
        $pricedata = Price::where('test_type', $test_type)->where('test_id', $profileId)->get();
    
        // Map prices by center_id
        $price_map = [];
        foreach ($pricedata as $p) {
            $price_map[$p->center_id] = ['price' => $p->price, 'mrp' => $p->mrp,'test_type'=>'profile','test_id'=>$p->test_id];
        }
    
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
    
        // Header
        $sheet->setCellValue('A1', 'Center ID');
        $sheet->setCellValue('B1', 'Center Name');
        $sheet->setCellValue('C1', 'Price');
        $sheet->setCellValue('D1', 'Saleable Price');
        $sheet->setCellValue('E1', 'Type');
        $sheet->setCellValue('F1', 'TestId');
    
        $rowNum = 2;
        foreach ($branch as $row) {
            $price = isset($price_map[$row->id]) ? $price_map[$row->id]['price'] : 0;
            $mrp = isset($price_map[$row->id]) ? $price_map[$row->id]['mrp'] : 0;
        //   $price = 200;
        //   $mrp = 120;
            $sheet->setCellValue("A$rowNum", $row->id);
            $sheet->setCellValue("B$rowNum", $row->name . ' - ' . $row->company_name);
            $sheet->setCellValue("C$rowNum", $price);
            $sheet->setCellValue("D$rowNum", $mrp);
            $sheet->setCellValue("E$rowNum", $test_type);
            $sheet->setCellValue("F$rowNum", $profileId);
    
            $rowNum++;
        }
    
        // Download Excel
        
        // $filename = "center_prices_profile_$profileId.xlsx";
        $datetime = date('Y-m-d_H-i-s');
        $filename = "center_prices_{$test_type}_{$profileId}_{$datetime}.xlsx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
    public function importCenterPrices(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls',
            'profile_id' => 'required|integer'
        ]);
        $test_type = $request->input('type');
        $profileId = $request->input('profile_id');
        $file = $request->file('excel_file');
        
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();
    
        // Skip header row (assume 1st row is header)
        for ($i = 1; $i < count($rows); $i++) {
            $centerId = $rows[$i][0];
            $centerName = $rows[$i][1]; // Optional
            $price = $rows[$i][2];
            $mrp = $rows[$i][3];
            
            // Update or Insert
            $existing = Price::where('test_type', $test_type)
                            ->where('test_id', $profileId)
                            ->where('center_id', $centerId)
                            ->first();
    
            if ($existing) {
                $existing->price = $price;
                $existing->mrp = $mrp;
                $existing->save();
            } else {
                Price::create([
                    'test_type' => $test_type,
                    'test_id' => $profileId,
                    'center_id' => $centerId,
                    'price' => $price,
                    'mrp' => $mrp
                ]);
            }
        }
    
        return redirect()->back()->with('success', 'Center prices updated successfully from Excel.');
    }
  
}
