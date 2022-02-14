<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Machine;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MachineController extends Controller
{
    public function addMachine(Request $request){
        $machine = new Machine();
        $machine->machine_name = $request->set_name;
        $machine->latitude = $request->set_lat;
        $machine->longitude = $request->set_long;
        $machine->address = $request->set_address;
        $machine->topic_status = $request->topic_status;
        $machine->topic_mode = $request->topic_mode;
        $machine->topic_pm = $request->topic_pm;
        $machine->topic_temp = $request->topic_temp;
        $machine->topic_hum = $request->topic_hum;
        $machine->save();
        return back()->with('Machine_add','Machine record has been save');
    }

    public function updateMachine(Request $request){

        $machine = Machine::find($request->id);
        $machine->machine_name = $request->set_name;
        $machine->latitude = $request->set_lat;
        $machine->longitude = $request->set_long;
        $machine->address = $request->set_address;
        $machine->topic_status = $request->topic_status;
        $machine->topic_mode = $request->topic_mode;
        $machine->topic_pm = $request->topic_pm;
        $machine->topic_temp = $request->topic_temp;
        $machine->topic_hum = $request->topic_hum;
        $machine->save();

        return back()->with('Machine_up','Machine record has been update');
    }

    public function showEdit($id){
        // $data = Machine::find($id);
        // return view('editMachines',compact('data',$data));
        $sql = DB::select("SELECT * FROM machine_location WHERE machine_id = $id;");
        return view('editMachine',compact('sql',$sql));
    }

    public function deleteMachine($id){
        $sql = DB::delete("DELETE FROM machine_location WHERE machine_id = $id;");
        return "Delete Complet";
    }

}
