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
    <link rel="icon" href="{{url('/images/LOGO-IT.png')}}" type="image/gif" sizes="16x16">
</head>
<body>

<div class="container-fluid">

  <div id="moblie-menu" style="display:none">
    <div id="menuToggle">
      <input id="check-show" type="checkbox" onclick="showMenu()"/>
      <span class="s1"></span>
      <span class="s2"></span>
      <span class="s3"></span>
    </div>
  </div>
  
  <div id="list-menu" style="display:none">
    <ul>
      <li style="text-align:center" onclick="goPath('')"><img src="{{url('/images/it-weather2.png')}}" ></li>
      <li onclick="goPath('')"><i class="icon-home"></i>Home</a></li>
    </ul>
  </div>

<div class="row">
<!-- bar -->
  <div class="col-2 it-bar it-bar-height" id="chart-bar" style="background-color:#6165f8;">
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
    <div class="insert-box">
      <h1>ข้อมูลย้อนหลัง</h1>
      <label for=""  class="form-label" >สถานที่</label>
      <select id="machine-pm"  class="form-select mb-2">
        @foreach($machines as $machine)
          <option value="{{$machine->machine_id}}">{{$machine->address}}</option>
         @endforeach
      </select>
      <div class="row">
        <div class="col-md-4 part1">
          <label for=""  class="form-label" >วันที่เริ่มต้น</label>
          <div class="d-flex">
            <input  type="date" class="form-control" id="date1">
            <select  class="form-select" id="time1">
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
            <input type="date" class="form-control" id="date2">
            <select  class="form-select" id="time2">
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
          <button  class="btn btn-primary col" onclick="showChart()">ตรวจสอบ</button>
        </div>
      </div>
    </div>
    
    <div id="chart-pm">
        <p id="no-data">ไม่พบข้อมูล</p>
    </div>

    <div id="detail-table" class="container" style="display:none">
        <h3>Summery</h3>
        <table class="table table-bordered text-center border-dark">
          <tbody>
            <tr>
              <th scope="row">ค่าสูงสุด</th>
              <td id="pm-max">0</td>
            </tr>
            <tr>
              <th scope="row">ค่าน้อยสุด</th>
              <td id="pm-min">0</td>
            </tr>
            <tr>
              <th scope="row">ค่าเฉลี่ย</th>
              <td id="pm-avg">0</td>
            </tr>
            <tr>
              <th scope="row">จำนวนที่เก็บค่าได้</th>
              <td id="pm-amount">0</td>
            </tr>
          </tbody>
        </table>
    </div>

  </div>
  <!-- end -->
</div> 
</div>


<script>
// Array chart
var pmArr = new Array();

$(window).resize(function(){
  let table = document.getElementById("detail-table");
    if(table.style.display == "block"){
      Graph(pmArr);
      console.log("true")
    }
});

const showChart = () => {
  var macid = document.getElementById("machine-pm").value;
  var date1 = document.getElementById("date1").value;
  var date2 = document.getElementById("date2").value;
  var time1 = document.getElementById("time1").value;
  var time2 = document.getElementById("time2").value;

  if(date1 != ""  && date2 != ""){
    date1 = date1 + " " + time1;
    date2 = date2 + " " + time2;
    dateAll = {macid: macid ,date1: date1 ,date2: date2};

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
        pmArr = JSON.parse(response);
        if(pmArr.length > 1){
          Graph(pmArr);
          detail(response)
        }else{
          noData();
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
          rigth: 0,
          top:40,
          bottom:80,
          // width: '80%'
        },
        legend: {
          position: 'top'
        },
        width: '100%',
        pointSize: 5,
        hAxis : { 
          textStyle:{
            fontSize: 12 
          }
        }
      };
      var chart = new google.visualization.LineChart(document.getElementById('chart-pm'));
      chart.draw(data, options);
    }
  }

// detail table 
function detail(pmArr){
  var arr = JSON.parse(pmArr);
  var arr2 = new Array();
  var sum = 0;
  var i = 0;
  arr.splice(0, 1);
  arr.map((a1) =>{
    a1.map((a2) =>{
        if(typeof(a2) == "number"){
            arr2.push(a2)
        }
    })
})
  arr2.map((val,key) => {
    sum = sum + val;
    i = i + 1;
})
const avg = sum / i;
const max =  Math.max(...arr2);
const min = Math.min(...arr2);
let table = document.getElementById("detail-table");
let bar = document.getElementById("chart-bar");
let avgt = document.getElementById("pm-avg");
let maxt = document.getElementById("pm-max");
let mint = document.getElementById("pm-min");
let amount = document.getElementById("pm-amount");

table.style.display = "block";
bar.classList.remove("it-bar-height");
avgt.innerHTML = avg.toFixed(3);
maxt.innerHTML = max;
mint.innerHTML = min;
amount.innerHTML = i;

}

// no data
function noData(){
  var chart = document.getElementById("chart-pm");
  let table = document.getElementById("detail-table");
  let bar = document.getElementById("chart-bar");

  chart.innerHTML = "";
  let item = document.createElement('p');
  item.textContent = "ไม่พบข้อมูล";
  item.classList.add('no-data');
  chart.appendChild(item);
  table.style.display =  "none";
  bar.classList.add("it-bar-height");
}

// path click
function goPath(path){
  window.location = `/${path}`;
}

// show moblie menu
function showMenu(){
  let checkBox = document.getElementById("check-show").checked;
  let list = document.getElementById("list-menu");
  if(checkBox == true ){
    list.style.display = "block";
  }else{
    list.style.display = "none";
  }
}

</script>
</body>
</html>
