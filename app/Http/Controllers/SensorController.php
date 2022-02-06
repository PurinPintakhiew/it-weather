<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Weather;
use App\Models\Machine;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class SensorController extends Controller
{

    public function writeData(Request $request){
        date_default_timezone_set('Asia/Bangkok');
        $date = date('d/m/Y');
        $time = date('H:i');
        $data = $date.','.$time.','.$request->temp.','.$request->hum.','.$request->pm;
        Storage::prepend('data/data.txt', $data);
        return $data;
    }

    public function saveData(){

        $sumTemp = 0;
        $sumHum = 0;
        $sumPM = 0;
        $i = 0;
        $lines = file(Storage::path('data/data.txt'));
        date_default_timezone_set('Asia/Bangkok');
        $dateNow = date("d/m/Y");
        $timeNow = date("H:i");
        $dateNow = strtotime($dateNow);
        $timeNow = strtotime($timeNow) - (60*60);

        foreach($lines as $value){
          $var = explode(",",$value);
          list($date,$time,$temp,$hum,$pm) = $var;
          if(($dateNow == strtotime($date)) && (strtotime($time) >= $timeNow)){
            $i++;
            $sumTemp = $sumTemp + $temp;
            $sumHum = $sumHum + $hum;
            $sumPM = $sumPM + $pm;
            }
        }

        if($i != 0){
            $avgtemp = $sumTemp/$i;
            $avghum = $sumHum/$i;
            $avgpm = $sumPM/$i;
            $avgtemp = round($avgtemp,3);  
            $avghum = round($avghum,3);  
            $avgpm = round($avgpm,3);  
            
            $weather = new Weather();
            $weather->datetime = date('Y/m/d H:i');
            $weather->temperature = $avgtemp;
            $weather->humidity = $avghum;
            $weather->pm2_5 = $avgpm;
            $weather->save();
        }

        return 'Comple';
    }

    public function DateThai($date){
        // date_default_timezone_set('Asia/Bangkok');
        $year = (date("Y",strtotime($date)) + 543);
        $month = (date("m",strtotime($date)) + 0);
        $day = date("d",strtotime($date));
        $monthArray =  array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กฎกราคม",
                            "สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
        $monthThai = $monthArray[$month] ?? null;
        return "$day $monthThai $year";
    }

    public function chart(){
        $sql = DB::select("SELECT datetime,pm2_5 FROM datapm WHERE datetime BETWEEN NOW() - INTERVAL 24 HOUR AND NOW();");
        $dataDay[] = ['Time','Average PM 2.5'];
        foreach($sql as $key => $value){
            $time = date("d-m-Y H:i", strtotime($value->datetime));
            $dataDay[++$key] = [$time,$value->pm2_5];
        }
        // $dataDay = json_encode($dataDay);
        return $dataDay;
      }

    public function chartWeek(){
        $sql = DB::select("SELECT DATE(datetime) as DateOnly,AVG(pm2_5) AS avg FROM `datapm`
            WHERE datetime BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW() GROUP BY DateOnly ORDER BY DateOnly;");
    
        $dataWeek[] = ['Time','Average PM 2.5'];
        foreach($sql as $key => $value){
            $date = $value->DateOnly;
            $time = $this->DateThai($date);
            $dataWeek[++$key] = [$time,$value->avg];
        }
        // $dataWeek = json_encode($dataWeek);
    
        return $dataWeek;
    }

    public function pmAvg(){  
        $sql = DB::select("SELECT AVG(pm2_5) as pmavg FROM datapm WHERE datetime > NOW() - INTERVAL 24 HOUR;");
        foreach($sql as $value){
            $pmavg = $value->pmavg;
        }
        $pmavg = round($pmavg);
        return $pmavg;
    }

    public function tempDay(){
        $sql = DB::select("SELECT AVG(temperature) as tempavg FROM datapm WHERE datetime > NOW() - INTERVAL 24 HOUR;");
        $result = count($sql);
        if($result > 0){
            foreach($sql as $value){
                $tempDay = $value->tempavg;
            }
            $tempDay = round($tempDay);
            return $tempDay;
        }else{
            return 0;
        }
    }

    public function humDay(){
        $sql = DB::select("SELECT AVG(humidity) as humavg FROM datapm WHERE datetime > NOW() - INTERVAL 24 HOUR;");
        $result = count($sql);
        if($result > 0){
            foreach($sql as $value){
                $humDay = $value->humavg;
            }
            $humDay = round($humDay);
            return $humDay;
        }else{
            return 0;
        }
    }

    public function tempWeek(){
        $sql = DB::select("SELECT AVG(temperature) as tempavg FROM datapm WHERE datetime BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW()");
        $result = count($sql);
        if($result > 0){
            foreach($sql as $value){
                $tempWeek = $value->tempavg;
            }
            $tempWeek = round($tempWeek);
            return $tempWeek;
        }else{
            return 0;
        }
    }

    public function humWeek(){
        $sql = DB::select("SELECT AVG(humidity) as humavg FROM datapm WHERE datetime BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW()");
        $result = count($sql);
        if($result > 0){
            foreach($sql as $value){
                $humWeek = $value->humavg;
            }
            $humWeek = round($humWeek);
            return $humWeek;
        }else{
            return 0;
        }
    }

    public function machineLocation(){
        $sql = DB::select("SELECT AVG(datapm.pm2_5) as macpm,datapm.machine_id,machine_location.machine_name,machine_location.latitude,machine_location.longitude,machine_location.address FROM datapm INNER JOIN machine_location ON datapm.machine_id=machine_location.machine_id GROUP BY datapm.machine_id;");
        $result = count($sql);
        if($result > 0){
            return $sql;
        }else{
            return 0;
        }
    }

    public function show(){
        $dataDay = $this->chart();
        $dataWeek = $this->chartWeek();
        $pmavg = $this->pmAvg();
        $location = $this->machineLocation();
        $dateNow = $this->DateThai(date("Y-m-d"));
        $tempDay = $this->tempDay();
        $humDay = $this->humDay();
        $tempWeek = $this->tempWeek();
        $humWeek = $this->humWeek();
        return view('weather',compact('dataDay','pmavg','location','dataWeek','dateNow','tempDay','humDay','tempWeek','humWeek'));
    }


}
