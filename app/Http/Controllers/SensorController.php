<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Weather;
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

    public function chart(){
        
        $sql = DB::select("SELECT datetime,pm2_5 FROM datapm WHERE datetime > NOW() - INTERVAL 24 HOUR  ");
        $dataDay[] = ['Time','Average'];
        foreach($sql as $key => $value){
            $dataDay[++$key] = [$value->datetime,$value->pm2_5];
        }
        $dataDay = json_encode($dataDay);
        return $dataDay;
      }

    public function show(){
        $dataDay = $this->chart();
        return view('weather',compact('dataDay'));
    }


}
