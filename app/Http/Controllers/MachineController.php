<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Machine;
use Illuminate\Support\Facades\DB;

class MachineController extends Controller
{
    public function addMachine(Request $request){
        $machine = new Machine();
        $machine->machine_name = $request->set_name;
        $machine->latitude = $request->set_lat;
        $machine->longitude = $request->set_long;
        $machine->save();
        return back()->with('Machine_add','Machine record has been save');
    }

    public function showEdit($id){
        $sql = DB::select("SELECT * FROM machine_location WHERE machine_id = $id;");
        return view('editMachine',compact('sql'));
    }

    public function deleteMachine($id){
        $sql = DB::delete("DELETE FROM machine_location WHERE machine_id = $id;");
        return "Delete Complet";
    }

}
