<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\LocationOt;
use Auth;
use Carbon\Carbon;
use Datatables;

class LocationOtController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        $permission = $user->can('Location-OT-list');

        if(!$permission) {
            abort(403);
        }

        $locationot = LocationOt::orderBy('id', 'asc')->get();
        $branches=DB::table('branches')->select('*')->get();
        $job_titles=DB::table('job_titles')->select('*')->get();
        return view('Organization.location_ot', compact('locationot','branches','job_titles'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $permission = $user->can('Location-OT-create');


        $locationot = new LocationOt;
        $locationot->location_id = $request->input('location');
        $locationot->job_id = $request->input('job_title');
        $locationot->max_ot_hours = $request->input('max_ot_hours');
        $locationot->working_days = $request->input('working_days');
        $locationot->created_at = Carbon::now()->toDateTimeString();

        $locationot->save();

        return response()->json(['success' => 'Location OT Added successfully.']);
    }

    public function letterlist ()
    {
        $letters = DB::table('location_ot_hours')
        ->leftjoin('job_titles', 'location_ot_hours.job_id', '=', 'job_titles.id')
        ->leftjoin('branches', 'location_ot_hours.location_id', '=', 'branches.id')
        ->select('location_ot_hours.*','job_titles.title As job_title','branches.location As location')
        ->get();
        return Datatables::of($letters)
        ->addIndexColumn()
        ->addColumn('action', function ($row) {
            $btn = '';
                    if(Auth::user()->can('Location-OT-edit')){
                        $btn .= ' <button name="edit" id="'.$row->id.'" class="edit btn btn-outline-primary btn-sm" type="submit"><i class="fas fa-pencil-alt"></i></button>'; 
                    }
                    
                    if(Auth::user()->can('Location-OT-delete')){
                        $btn .= ' <button name="delete" id="'.$row->id.'" class="delete btn btn-outline-danger btn-sm"><i class="far fa-trash-alt"></i></button>';
                    }
            return $btn;
        })
       
        ->rawColumns(['action'])
        ->make(true);
    }

    public function edit($id)
    {
        $user = auth()->user();
        $permission = $user->can('Location-OT-edit');

        if(!$permission) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if (request()->ajax()) {
            $data = LocationOt::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request, LocationOt $locationot)
    {
        $user = auth()->user();
        $permission = $user->can('Location-OT-edit');

        $form_data = array(
            'location_id' => $request->location,
            'job_id' => $request->job_title,
            'max_ot_hours' => $request->max_ot_hours,
            'working_days' => $request->working_days,
            'updated_at' => Carbon::now()->toDateTimeString(),
        );

        LocationOt::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Location OT is successfully updated']);
    }

    public function destroy($id)
    {
        $user = auth()->user();
        $permission = $user->can('Location-OT-delete');

        $data = LocationOt::findOrFail($id);
        $data->delete();
    }
}
