<?php

namespace App\Http\Controllers;

use App\Shiftextend;
use App\Shiftextenddetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Carbon\Carbon;
use Datatables;
use DB;
use Illuminate\Support\Facades\Input;

class ShiftExtendController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
       
        $user = Auth::user();
        $permission = $user->can('employee-shift-extend-list');
        if (!$permission) {
            return response()->json(['error' => 'UnAuthorized'], 401);
        }

        $employees = DB::table('employees')->select('employees.emp_id','employees.emp_name_with_initial')->get();

        return view('EmployeeShift.shift_extend',compact('employees'));
    }

    public function insert(Request $request){
        $user = Auth::user();
        $permission = $user->can('employee-shift-extend-create');
        if (!$permission) {
            return response()->json(['error' => 'UnAuthorized'], 401);
        }
    
        $Shiftextend = new Shiftextend();
        $Shiftextend->date = $request->input('date');
        $Shiftextend->status = '1';
        $Shiftextend->created_by = Auth::id();
        $Shiftextend->updated_by = '0';
        $Shiftextend->save();
    
        $requestID = $Shiftextend->id;
        $date = $request->input('date');  
        $tableData = $request->input('tableData');
    
        foreach ($tableData as $rowtabledata) {
            $emp_id = $rowtabledata['col_1'];
    
            $Shiftextenddetail = new Shiftextenddetail();
            $Shiftextenddetail->shift_extend_id = $requestID;
            $Shiftextenddetail->emp_id = $emp_id;
            $Shiftextenddetail->date = $date;
            $Shiftextenddetail->status = '1';
            $Shiftextenddetail->created_by = Auth::id();
            $Shiftextenddetail->updated_by = '0';
            $Shiftextenddetail->save();
        }
        return response()->json(['success' => 'Employee Shift extend is Successfully Inserted']);
    }


    public function requestlist()
    {
        $types = DB::table('shift_extend')
            ->select('shift_extend.*')
            ->whereIn('shift_extend.status', [1, 2])
            ->get();

            return Datatables::of($types)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '';
                $user = Auth::user();


                        $btn .= ' <button name="view" id="'.$row->id.'" class="view btn btn-outline-secondary btn-sm" type="submit"><i class="fas fa-eye"></i></button>';

                        if($user->can('employee-shift-extend-edit')){
                            $btn .= ' <button name="edit" id="'.$row->id.'" class="edit btn btn-outline-primary btn-sm" type="submit"><i class="fas fa-pencil-alt"></i></button>';
                        }

                        if($user->can('employee-shift-extend-status')){
                            if($row->status == 1){
                                $btn .= ' <a href="'.route('empshiftextendstatus', ['id' => $row->id, 'stasus' => 2]) .'" onclick="return deactive_confirm()" target="_self" class="btn btn-outline-success btn-sm mr-1 "><i class="fas fa-check"></i></a>';
                            }else{
                                $btn .= '&nbsp;<a href="'.route('empshiftextendstatus', ['id' => $row->id, 'stasus' => 1]) .'" onclick="return active_confirm()" target="_self" class="btn btn-outline-warning btn-sm mr-1 "><i class="fas fa-times"></i></a>';
                            }
                        }
                        if($user->can('employee-shift-extend-delete')){
                            $btn .= ' <button name="delete" id="'.$row->id.'" class="delete btn btn-outline-danger btn-sm"><i class="far fa-trash-alt"></i></button>';
                        }
              
                return $btn;
            })
           
            ->rawColumns(['action'])
            ->make(true);
    }

    public function edit(Request $request){


        $id = Request('id');
        if (request()->ajax()){
        $data = DB::table('shift_extend')
        ->select('shift_extend.*')
        ->where('shift_extend.id', $id)
        ->get(); 
        $requestlist = $this->reqestcountlist($id); 
    
        $responseData = array(
            'mainData' => $data[0],
            'requestdata' => $requestlist,
        );

    return response() ->json(['result'=>  $responseData]);
    }
    }

    private function reqestcountlist($id){
        $recordID = $id;
        $data = DB::table('shift_extenddetails')
        ->select('shift_extenddetails.*', 'employees.emp_name_with_initial as employee_name')
        ->leftjoin('employees', 'employees.emp_id', 'shift_extenddetails.emp_id')
        ->where('shift_extenddetails.shift_extend_id', $recordID)
        ->where('shift_extenddetails.status', 1)
        ->get(); 

        $htmlTable = '';
        foreach ($data as $row) {
            $htmlTable .= '<tr>';
            $htmlTable .= '<td>' . $row->emp_id . '</td>'; 
            $htmlTable .= '<td>' . $row->employee_name . '</td>';
            $htmlTable .= '<td>' . $row->date . '</td>'; 
            $htmlTable .= '<td class="d-none">ExistingData</td>'; 
            $htmlTable .= '<td class="d-none">' . $row->id . '</td>'; 
            $htmlTable .= '<td class="text-right" id ="actionrow"><button type="button" id="'.$row->id.'" class="btnEditlist btn btn-primary btn-sm ">
                <i class="fas fa-pen"></i>
                </button>&nbsp;
                <button type="button" rowid="'.$row->id.'" id="btnDeleterow"  class="btnDeletelist btn btn-danger btn-sm " >
                <i class="fas fa-trash-alt"></i>
                </button></td>'; 
            $htmlTable .= '</tr>';
        }

        return $htmlTable;
    }
   public function editlist(Request $request){
        $id = Request('id');
        if (request()->ajax()){
        $data = DB::table('shift_extenddetails')
        ->select('shift_extenddetails.*')
        ->where('shift_extenddetails.id', $id)
        ->get(); 
        return response() ->json(['result'=> $data[0]]);
        }
   }

   public function deletelist(Request $request){

    $user = Auth::user();
    $permission = $user->can('employee-shift-extend-delete');
    if (!$permission) {
        return response()->json(['error' => 'UnAuthorized'], 401);
    }

        $id = Request('id');
        $current_date_time = Carbon::now()->toDateTimeString();
        $form_data = array(
            'status' =>  '3',
            'update_by' => Auth::id(),
            'updated_at' => $current_date_time,
        );
        Shiftextenddetail::findOrFail($id)
        ->update($form_data);

        return response()->json(['success' => 'Employee Shift extend is successfully Deleted']);

    }


    public function update(Request $request){
        $user = Auth::user();
        $permission = $user->can('employee-shift-extend-edit');
        if (!$permission) {
            return response()->json(['error' => 'UnAuthorized'], 401);
        }
       
        $current_date_time = Carbon::now()->toDateTimeString();
        $id = $request->hidden_id;
    
        // Update main allocation record
        $form_data = array(
            'date' => $request->date,
            'updated_by' => Auth::id(),
            'updated_at' => $current_date_time,
        );
    
        Shiftextend::findOrFail($id)->update($form_data);
    
        $tableData = $request->input('tableData');

        $existingDetailIds = Shiftextenddetail::where('shift_extend_id', $id)
            ->pluck('id')->toArray();
        $processedDetailIds = [];
    
        foreach ($tableData as $rowtabledata) {
            $emp_id = $rowtabledata['col_1'];
            $empname = $rowtabledata['col_2'];
            $date = $request->date;
            
            if(isset($rowtabledata['col_4']) && !empty($rowtabledata['col_4'])) {
                $detailID = $rowtabledata['col_4'];
                $Shiftextenddetail = Shiftextenddetail::find($detailID);
                if ($Shiftextenddetail) {
                    $Shiftextenddetail->emp_id = $emp_id;
                    $Shiftextenddetail->date = $date;
                    $Shiftextenddetail->updated_by = Auth::id();
                    $Shiftextenddetail->save();
                    
                    $processedDetailIds[] = $detailID;
                }
            } else {
                $Shiftextenddetail = new Shiftextenddetail();
                $Shiftextenddetail->emp_id = $emp_id;
                $Shiftextenddetail->date = $date;
                $Shiftextenddetail->shift_extend_id = $id;
                $Shiftextenddetail->status = '1';
                $Shiftextenddetail->created_by = Auth::id();
                $Shiftextenddetail->updated_by = '0';
                $Shiftextenddetail->save();
                
                $processedDetailIds[] = $Shiftextenddetail->id;
            }
        }
        
        return response()->json(['success' => 'Employee Shift extend is Successfully Updated']);
    }


    public function view(Request $request){


        $id = Request('id');
        if (request()->ajax()){
        $data = DB::table('shift_extend')
        ->select('shift_extend.*')
        ->where('shift_extend.id', $id)
        ->get(); 
        $requestlist = $this->view_reqestcountlist($id); 

        $responseData = array(
            'mainData' => $data[0],
            'requestdata' => $requestlist,
        );

        return response() ->json(['result'=>  $responseData]);
        }
    }
    private function view_reqestcountlist($id){

        $recordID =$id ;
        $data = DB::table('shift_extenddetails')
        ->select('shift_extenddetails.*' ,'employees.emp_name_with_initial as employee_name')
        ->where('shift_extenddetails.shift_extend_id', $recordID)
        ->leftjoin('employees','employees.emp_id','shift_extenddetails.emp_id')
        ->where('shift_extenddetails.status', 1)
        ->get(); 


        $htmlTable = '';
        foreach ($data as $row) {
            
            $htmlTable .= '<tr>';
            $htmlTable .= '<td>' . $row->emp_id . '</td>'; 
            $htmlTable .= '<td>' . $row->employee_name . '</td>'; 
            $htmlTable .= '<td class="d-none">ExistingData</td>'; 
            $htmlTable .= '<td name="detailsId" class="d-none">' . $row->id . '</td>'; 
            $htmlTable .= '</tr>';
        }

        return $htmlTable;

    }

    public function delete(Request $request){

        $user = Auth::user();
        $permission = $user->can('employee-shift-extend-delete');
        if (!$permission) {
            return response()->json(['error' => 'UnAuthorized'], 401);
        }
        
            $id = Request('id');
        $current_date_time = Carbon::now()->toDateTimeString();
        $form_data = array(
            'status' =>  '3',
            'update_by' => Auth::id(),
            'updated_at' => $current_date_time,
        );
        Shiftextend::findOrFail($id)
        ->update($form_data);

        return response()->json(['success' => 'Employee Shift extend is Successfully Deleted']);

    }

    public function status($id,$statusid){
       
        $user = Auth::user();
        $permission = $user->can('employee-shift-extend-status');
        if (!$permission) {
            return response()->json(['error' => 'UnAuthorized'], 401);
        } 

        if($statusid == 1){
            $form_data = array(
                'status' =>  '1',
                'update_by' => Auth::id(),
            );
            Shiftextend::findOrFail($id)
            ->update($form_data);
    
            return redirect()->route('empshiftextend');
        } else{
            $form_data = array(
                'status' =>  '2',
                'update_by' => Auth::id(),
            );
            Shiftextend::findOrFail($id)
            ->update($form_data);
    
            return redirect()->route('empshiftextend');
        }

    }

    public function employee_list_for_shift(Request $request)
    {
        if ($request->ajax()) {
            $page = $request->input('page', 1);
            $resultCount = 25;
            $offset = ($page - 1) * $resultCount;
            $date = $request->input('date');

            // If no date is selected, return empty results
            if (empty($date)) {
                return response()->json([
                    "results" => [],
                    "pagination" => ["more" => false]
                ]);
            }

            $query = DB::table('employees')
                ->select([
                    DB::raw('DISTINCT employees.emp_id as id'),
                    DB::raw('CONCAT(employees.emp_name_with_initial, " - ", employees.emp_id) as text')
                ])
                ->where('employees.emp_name_with_initial', 'LIKE', '%' . $request->input("term") . '%')
                ->where('employees.deleted', 0)
                // ->where('employees.status', 1)
                ->where('employees.is_resigned', 0);

            // Join with attendances table and filter by date
            $query->join('attendances', function($join) use ($date) {
                $join->on('employees.emp_id', '=', 'attendances.emp_id')
                    ->whereDate('attendances.date', $date);
            });

            $breeds = $query->orderBy('employees.emp_name_with_initial')
                ->skip($offset)
                ->take($resultCount)
                ->get();

            $count = DB::table('employees')
                ->join('attendances', function($join) use ($date) {
                    $join->on('employees.emp_id', '=', 'attendances.emp_id')
                        ->whereDate('attendances.date', $date);
                })
                ->where('employees.emp_name_with_initial', 'LIKE', '%' . $request->input("term") . '%')
                ->where('employees.deleted', 0)
                // ->where('employees.status', 1)
                ->where('employees.is_resigned', 0)
                ->count();

            $endCount = $offset + $resultCount;
            $morePages = $endCount < $count;

            $results = [
                "results" => $breeds,
                "pagination" => [
                    "more" => $morePages
                ]
            ];

            return response()->json($results);
        }
    }

    public function shift_extend_allocate_csv(Request $request)
    {
        $user = Auth::user();
        $permission = $user->can('employee-shift-extend-create');
        if (!$permission) {
            return response()->json(['error' => 'UnAuthorized'], 401);
        }

        $date = $request->input('date'); 
        $file = $request->file('csv_file_u');

        if (empty($date)) {
            return response()->json(['status' => false, 'errors' => ['Please select a date']], 422);
        }

        $fileContents = file($file->getPathname());
        array_shift($fileContents); 
        
        $errors = [];
        $successCount = 0;
        $lineNumber = 2; 

        foreach ($fileContents as $line) {
            if (trim($line) === '') {
                $lineNumber++;
                continue;
            }

            $data = str_getcsv($line);
            
            if (count($data) < 1) {
                $errors[] = "Line {$lineNumber}: Empty line or invalid format";
                $lineNumber++;
                continue;
            }

            $emp_id = trim(preg_replace('/^\xEF\xBB\xBF/', '', $data[0]));

            if (empty($emp_id)) {
                $errors[] = "Line {$lineNumber}: Missing employee ID";
                $lineNumber++;
                continue;
            }

            $emp = DB::table('employees')
                ->where('emp_id', $emp_id)
                ->where('deleted', 0)
                ->first();

            if (!$emp) {
                $errors[] = "Line {$lineNumber}: Employee ID {$emp_id} not found or inactive";
                $lineNumber++;
                continue;
            }

            // $attendanceExists = DB::table('attendances')
            //     ->where('emp_id', $emp_id)
            //     ->whereDate('date', $date)
            //     ->exists();

            // if (!$attendanceExists) {
            //     $errors[] = "Line {$lineNumber}: Employee {$emp->emp_name_with_initial} has no attendance on {$date}";
            //     $lineNumber++;
            //     continue;
            // }

            try {
                $Shiftextend = Shiftextend::firstOrCreate(
                    [
                        'date' => $date,
                    ],
                    [
                        'status' => '1',
                        'created_by' => Auth::id(),
                        'updated_by' => '0',
                    ]
                );

                $requestID = $Shiftextend->id;

                Shiftextenddetail::firstOrCreate(
                    [
                        'emp_id' => $emp_id,
                        'date' => $date,
                    ],
                    [
                        'shift_extend_id' => $requestID,
                        'status' => '1',
                        'created_by' => Auth::id(),
                        'updated_by' => '0',
                    ]
                );

                $successCount++;
            } catch (\Exception $e) {
                $errors[] = "Line {$lineNumber}: Processing error - " . $e->getMessage();
            }
            $lineNumber++;
        }

        $response = [
            'status' => true,
            'msg' => "Successfully processed {$successCount} employees."
        ];

        if (!empty($errors)) {
            $response['errors'] = $errors;
            if ($successCount === 0) {
                $response['status'] = false;
            }
        }

        return response()->json($response);
    }

}
