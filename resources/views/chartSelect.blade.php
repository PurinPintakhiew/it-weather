<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootsrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Jquery -->
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>  
      <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@100&display=swap" rel="stylesheet">
    <!-- css -->
    <link rel="stylesheet" type="text/css" href="{{ url('/css/chart.css') }}" /> 
    <link rel="stylesheet" type="text/css" href="{{ url('/css/styles.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('/css/fontello.css') }}" />
     <!-- Google Chart -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ข้อมูลย้อนหลัง</title>
</head>
<body>

<div class="container-fluid">

<div class="row">
<!-- bar -->
  <div class="col-2 it-bar" style="background-color:#6165f8;height: 100vh;">
    <div class="it-left-top">
      <div class="logo-home">
        <a href="/"><img src="{{url('/images/it-weather2.png')}}" ></a>
      </div>
      <div class="it-list-box">
        <ul>
          <li onclick="goPath('')"><i class="icon-home"></i>Home</a></li>
        </ul>
      </div>
    </div>
  </div>
<!-- content -->
  <div class="chart-rigth col-10">
    <div class="container-fluid">
      <div class="insert-box">
        <h1>ข้อมูลย้อนหลัง</h1>
        <div class="row">
          <div class="col-md-4 part1">
            <label for=""  class="form-label" >วันที่เริ่มต้น</label>
            <div class="d-flex">
              <input  type="date" class="form-control col" id="date1">
                <select  class="form-select col" id="time1">
                  <option value="00:00">00:00</option>
                  <option value="01:00">01:00</option>
                  <option value="02:00">02:00</option>
                  <option value="03:00">03:00</option>
                  <option value="04:00">04:00</option>
                  <option value="05:00">05:00</option>
                  <option value="06:00">06:00</option>
                  <option value="07:00">07:00</option>
                  <option value="08:00">08:00</option>
                  <option value="09:00">09:00</option>
                  <option value="10:00">10:00</option>
                  <option value="11:00">11:00</option>
                  <option value="12:00">12:00</option>
                  <option value="13:00">13:00</option>
                  <option value="14:00">14:00</option>
                  <option value="15:00">15:00</option>
                  <option value="16:00">16:00</option>
                  <option value="17:00">17:00</option>
                  <option value="18:00">18:00</option>
                  <option value="19:00">19:00</option>
                  <option value="20:00">20:00</option>
                  <option value="21:00">21:00</option>
                  <option value="22:00">22:00</option>
                  <option value="23:00">23:00</option>
                </select>
              </div>
            </div>
          <div class="col-md-1 part2">
              <p>to</p>
          </div>
          <div class="col-md-4 part3">
            <label for=""  class="form-label" >วันที่สิ้นสุด</label>
            <div class="d-flex">
              <input type="date" class="form-control col" id="date2">
              <select  class="form-select col" id="time2">
                <option value="00:00">00:00</option>
                <option value="01:00">01:00</option>
                <option value="02:00">02:00</option>
                <option value="03:00">03:00</option>
                <option value="04:00">04:00</option>
                <option value="05:00">05:00</option>
                <option value="06:00">06:00</option>
                <option value="07:00">07:00</option>
                <option value="08:00">08:00</option>
                <option value="09:00">09:00</option>
                <option value="10:00">10:00</option>
                <option value="11:00">11:00</option>
                <option value="12:00">12:00</option>
                <option value="13:00">13:00</option>
                <option value="14:00">14:00</option>
                <option value="15:00">15:00</option>
                <option value="16:00">16:00</option>
                <option value="17:00">17:00</option>
                <option value="18:00">18:00</option>
                <option value="19:00">19:00</option>
                <option value="20:00">20:00</option>
                <option value="21:00">21:00</option>
                <option value="22:00">22:00</option>
                <option value="23:00">23:00</option>
              </select>
            </div>
          </div>
          <div class="col-md-3 part4">
            <button  class="btn btn-primary" onclick="showChart()">ตรวจสอบ</button>
          </div>
        </div>
      </div>
      <div id="chart" style="margin: 0 auto">
          <!-- <h3>ไม่พบข้อมูล</h3> -->
      </div>
    </div>
  </div>
</div>
</div>


<script>

const showChart = () => {
  var date1 = document.getElementById("date1").value;
  var date2 = document.getElementById("date2").value;
  var time1 = document.getElementById("time1").value;
  var time2 = document.getElementById("time2").value;

  if(date1 != ""  && date2 != ""){
    date1 = date1 + " " + time1;
    date2 = date2 + " " + time2;
    console.log(date1);
    console.log(date2);

    dateAll = {date1: date1 ,date2: date2};

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $.ajax({
    type: "post",
    url: "/dataSelect",
    data: dateAll,
    success: (response) => {
      if(response){
        console.log(response);
        var pmArr = JSON.parse(response);
        if(pmArr.length > 1){
          Graph(pmArr);
        }else{
          console.log(pmArr.length);
          document.getElementById("chart").innerHTML = "NO";
        }
      }
    } 
  });

  }else{
    alert("กรุณาเลือกวัน");
  }

}

function Graph(pmArr) {
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart(){
      var data = google.visualization.arrayToDataTable(pmArr);
      var options = {
        chartArea: {
          // left: 40,
          // top:40,
          width: '85%'
        },
        legend: {
          position: 'top'
        },
        width: '100%',
        pointSize: 5,
        hAxis : { 
          textStyle:{
            fontSize: 12 
          },
          slantedText: true
        }
      };
      var chart = new google.visualization.LineChart(document.getElementById('chart'));
      chart.draw(data, options);
    }
  }

// path click
function goPath(path){
  window.location = `/${path}`;
}

</script>
</body>
</html>
<?php
?>