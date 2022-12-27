<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{

    public function getShifts()
    {
        $shifts = Shift::all();

        return response()->json([
            'shifts' => $shifts,
        ]);
    }

    public function getWorkers(){
        $workers = Shift::select('worker')->distinct()->get();

        return response()->json([
            'workers' => $workers,
        ]);
    }

    public function uploadCSV(Request $request){
        if($request->hasFile('csv')){
            $file = $request->file('csv');
        }
        $row = 1;
        if (($handle = fopen($file, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $row++;
                if($row>2){
                    $shift = new Shift();
                    $shift->date = $data[0];
                    $shift->worker = $data[1];
                    $shift->company = $data[2];
                    $shift->hours = intval($data[3]);
                    $shift->rate_per_hour = floatval(preg_replace('/[^0-9.]+/', '', $data[4]));
                    $shift->taxable = $data[5] == 'Yes' ? true : false;
                    $shift->status = $data[6];
                    $shift->shift_type = $data[7];
                    $shift->paid_at = $data[8];
                    $shift->save();
                }
            }
            fclose($handle);
            return response()->json([
                'status' => 'success',
                'message' => 'Shift records successfully uploaded.'
            ]);
        }
    }

    public function createShift(Request $request)
    {
        $shift = new Shift();
        $shift->date = $request->date;
        $shift->worker = $request->worker;
        $shift->company = $request->company;
        $shift->hours = $request->hours;
        $shift->rate_per_hour = $request->rate_per_hour;
        $shift->status = $request->status;
        $shift->taxable = $request->taxable;
        $shift->shift_type = $request->shift_type;
        $shift->paid_at = $request->paid_at;

        if($shift->save()){
            return response()->json([
                'status' => 'success',
                'message' => 'Successfully created new shift entry!',
                'shift' => $shift,
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => "Failed to create new shift entry.",
            ]);
        }
    }

    public function updateShift(Request $request)
    {
        $shift = Shift::findOrFail($request->id);
        $shift->date = $request->date;
        $shift->worker = $request->worker;
        $shift->company = $request->company;
        $shift->hours = $request->hours;
        $shift->rate_per_hour = $request->rate_per_hour;
        $shift->status = $request->status;
        $shift->taxable = $request->taxable;
        $shift->shift_type = $request->shift_type;
        $shift->paid_at = $request->paid_at;

        if($shift->save()){
            return response()->json([
                'status' => 'success',
                'message' => 'Successfully updated shift entry!',
                'shift' => $shift,
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => "Failed to update shift records.",
            ]);
        }
    }

    public function deleteShift(Request $request)
    {
        $shift = Shift::findOrFail($request->id);
        if($shift->delete()){
            return response()->json([
                'status' => 'success',
                'message' => "Successfully deleted shift.",
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => "Failed to delete shift.",
            ]);
        }
    }

    public function getEmployeeDetails(Request $request){
        $shifts = Shift::where('worker', $request->worker)->orderBy('paid_at', 'desc');
        $average_rate = $shifts->avg('rate_per_hour');
        $total_hours = $shifts->sum('hours');
        $last_five = $shifts->take(5)->get();
        return response()->json([
            'shifts' => $last_five,
            'average_rate' => $average_rate,
            'total_hours' => $total_hours
        ]);
    }
}
