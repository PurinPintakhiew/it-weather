<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Machine;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sqls=$this->machine();
        return view('home',compact('sqls'));
    }

    public function machine(){
        $sql = DB::table('machine_location')->get();
        return $sql;
    }

    public function map(){
        $sql = DB::select("SELECT AVG(datapm.pm2_5) as macpm,datapm.machine_id,machine_location.machine_name,machine_location.latitude,machine_location.longitude,machine_location.address FROM datapm INNER JOIN machine_location ON datapm.machine_id=machine_location.machine_id GROUP BY datapm.machine_id;");
        $result = count($sql);
        if($result > 0){
            return $sql;
        }else{
            return 0;
        }
    }

    public function chart(Request $request){
        $id = $request->id;
        $sql = DB::select("SELECT datetime,pm2_5,pm10,temperature,humidity,machine_id FROM datapm WHERE machine_id = $id AND datetime BETWEEN NOW() - INTERVAL 24 HOUR AND NOW();");
        $dataDay[] = ['Time','Average PM 2.5','PM 10','Temperature','Humidity'];
        foreach($sql as $key => $value){
            $time = date("D H:i", strtotime($value->datetime));
            $dataDay[++$key] = [$time,$value->pm2_5,$value->pm10,$value->temperature,$value->humidity];
        }
        $dataDay = json_encode($dataDay);
        return $dataDay;
    }

    public function chartWeek(Request $request){
        $id = $request->id;
        $sql = DB::select("SELECT DATE(datetime) as DateOnly,AVG(pm2_5) as pm25,AVG(pm10) as pm10,AVG(temperature) as temp,AVG(humidity) as hum FROM `datapm`
            WHERE machine_id = $id AND datetime BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW() GROUP BY DateOnly ORDER BY DateOnly;");
    
        $dataWeek[] = ['Time','Average PM 2.5','PM 10','Temperature','Humidity'];
        foreach($sql as $key => $value){
            $date = date("d/m/Y", strtotime($value->DateOnly));
            $dataWeek[++$key] = [$date,$value->pm25,$value->pm10,$value->temp,$value->hum];
        }
        $dataWeek = json_encode($dataWeek);
        return $dataWeek;
    }

    public function dashboard()
    {
        $map = $this->map();
        $machines=$this->machine();
        // $chartDay = $this->chart();
        return view('dashboard',compact('machines','map'));
    }

}
