<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Weather;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function chartData(){
        date_default_timezone_set('Asia/Bangkok');
        $date1 = date('Y-m-d 00:00:01');
        $date2 = date('Y-m-d 23:59:59');
        $sql = DB::select("select datetime,pm2_5 from test where datetime between '$date1' and '$date2'  ");
        $data[] = ['Time','Average'];
        foreach($sql as $key => $value){
            $date = $value->datetime;
            $time = date("H:i", strtotime($date));
            $data[++$key] = [$time,$value->pm2_5];
        }
        $data = json_encode($data);
        $avgStar = Weather::avg('pm2_5');
        $date = $this->DateThai($date);
        return view('chartPM',compact('data','avgStar','date'));
    }

    public function DateThai($date){
        $year = date("Y",strtotime($date))+543;
        $month = date("m",strtotime($date));
        $day = date("d",strtotime($date));
        $monthArray =  array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กฎกราคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
        $monthThai = $monthArray[$month];
        return "$day $monthThai $year";
      }


}
