<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\phpMQTT;
use App\Models\Weather;
use Illuminate\Support\Facades\Storage;

class GetdataController extends Controller
{
    public function connectMqtt(){
        $server  = "10.133.0.179"; 
        $port  = 1883;
        $username = "e";
        $password = "e";  
        $client_id = "Client-".rand();

        $mqtt = new phpMQTT($server, $port, $client_id);
        if( !$mqtt->connect(true, NULL, $username, $password) ) {
            exit(1);
        }
        return $mqtt;
    }

    public function getTemp(){
        $mqtt = $this->connectMqtt();
        $temp = $mqtt->subscribeAndWaitForMessage('TEST/MQTT', 0);
        return $temp;
    }

    public function getHum(){
        $mqtt = $this->connectMqtt();
        $hum = $mqtt->subscribeAndWaitForMessage('TEST/HUM', 0);
        return $hum;
    }
    
    public function getPm(){
        $mqtt = $this->connectMqtt();
        $pm = $mqtt->subscribeAndWaitForMessage('TEST/PM', 0);
        return $pm;
    }

    public function writeData(){
        date_default_timezone_set('Asia/Bangkok');
        $date = date('d/m/Y');
        $time = date('H:i');
        $temp = $this->getTemp();
        $hum = $this->getHum();
        $pm = $this->getPm();
        $data = $date.','.$time.','.$temp.",".$hum.",".$pm;
        Storage::prepend('data/data.txt', $data);
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
    
}
