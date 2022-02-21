<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@100&display=swap" rel="stylesheet">
  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <!-- Bootstrap 4 css -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <!-- css -->
  <link rel="stylesheet" type="text/css" href="{{ url('/css/styles.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ url('/css/fontello.css') }}" />
  <!-- My Js -->
  <script type="text/javascript" src="{{ asset('js/paho-mqtt.js') }}"></script>
  <!-- Jquery -->
  <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <!-- Google Chart -->
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <!-- Map -->
  <!-- <script type="text/javascript" src="https://api.longdo.com/map/?key=42eb94007e1a5d73e5ad3fcba45b5734"></script> -->
  
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>IT Weather</title>
  <link rel="icon" href="{{url('/images/LOGO-IT.png')}}" type="image/gif" sizes="16x16">

</head>

<body onload="init();">

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
            <li onclick="clickScroll('avg-pm')"><i class="icon-pm"></i>Average PM 2.5</li>
            <li onclick="clickScroll('graph-pm')"><i class="icon-chart-area"></i>Graph</li>
            <li onclick="clickScroll('map-pm')"><i class="icon-map"></i>Map</li>
            <li onclick="goPath('chartData')"><i class="icon-hourglass-3"></i>Historical Data</a></li>
          </ul>
        </div>
    <div class="row">

      <div class="col-2 it-bar" style="background-color:#6165f8;">
        <div class="">
          <div class="it-left-top">
            <div class="logo-home">
                <a href="/">
                  <img src="{{url('/images/it-weather2.png')}}" >
                </a>
            </div>
            <div class="it-list-box">
                  <ul>
                    <li onclick="clickScroll('avg-pm')"><i class="icon-pm"></i>Average PM 2.5</li>
                    <li onclick="clickScroll('graph-pm')"><i class="icon-chart-area"></i>Graph</li>
                    <li onclick="clickScroll('map-pm')"><i class="icon-map-1"></i>Map</li>
                    <li onclick="goPath('chartData')"><i class="icon-hourglass-3"></i>Historical Data</a></li>
                  </ul>
            </div>
          </div>
          <div class="it-session">

          </div>
        </div>
      </div>

      <div class="col-10 it-weather">
          <div class="">

<!-- display data from sensor -->
      <div id="sesor-realtime" class="d-flex justify-content-between">
          <div class="left-pm d-flex">
            <div class="local-time d-flex flex-column">
              <div class="location-pm">
                <select id="local_mac" onchange="setAddress()">
                  @foreach($machine as $local)
                    <option id="option_mac" value="{{$local->machine_id}}">{{$local->address}}</option>
                  @endforeach
                </select>
              </div>
              <div class="date-pm">
                  <?php echo $dateNow ?>
              </div>
            </div>
            <div class="pm-realtime">
                <h5 class="">PM 2.5</h5>
                <div class="d-flex flex-row justify-content-center">
                    <p id="pm">0.00</p>
                    <span class="pm-symbol">µg/&#13221</span>
                </div>
            </div>
          </div>
          <div class="rigth-pm d-flex flex-column text-center">
            <div class="temp-hum">
              <div class="temp-pm"> 
                  <h5>Temperature</h5>
                  <div class="d-flex flex-row justify-content-center">
                    <img class="temp-img" src="{{url('/images/temperatures.png')}}">
                    <p id="temp">0.00</p>
                    <span class="temp-symbol">&#8451</span>
                  </div>
                </div>
                <div class="hum-pm">
                  <h5>Humidity</h5>
                  <div class="d-flex flex-row justify-content-center">
                    <img class="hum-img" src="{{url('/images/humidity2.png')}}">
                    <p id="hum">0.00</p>
                    <span class="hum-symbol">%</span>
                  </div>
                </div>
            </div>
          </div>
      </div>

<!-- pm24 -->
<div id="avg-pm">
  <h3 style="font-weight:600;">ค่าเฉลี่ยปริมาณฝุ่นละอองขนาดไม่เกิน 2.5 ไมครอน ราย 24 ชั่วโมง</h3>
    <div class="card-pm24 container-fluid">
      <div class="row">
        <div class="col-md-12 col-lg-4" id="pm24-avg-part">
            <h4>ค่าเฉลี่ย</h4>
            <div class="d-flex justify-content-center">
              <div id="value-pm24">0</div>
              <span class="pm24-symbol">µg/&#13221</span>
            </div>
        </div>
        <div class="col-sm-4 col-md-4 col-lg-4" id="pm24-level-part">
          <h4>ระดับคุณภาพอากาศ</h4>
          <div class="d-flex justify-content-center align-items-center">
            <div id="color-level-pm24"></div>
            <div id="level-pm24"></div>
          </div>
        </div>
        <div class="col-sm-8 col-md-8 col-lg-4" id="pm24-detail-part">
          <h4>รายละเอียด</h4>
          <div class="d-flex justify-content-center">
            <div id="details-pm24"></div>
          </div>
        </div>
      </div>
    </div>
    <div id="arrowAnim" onclick="showTable()">
      <p>รายละเอียด</p>
      <div class="arrow"></div>
    </div>
  </div>

<!-- Table index PM -->
  <div class="container">
      <div id = "details-level" style="display:none;overflow-x:auto;">
        <div class="head-d-level">
          <strong>เกณฑ์ค่าความเข้มข้นของฝุ่นละอองขนาดไม่เกิน 2.5 ไมครอน ของประเทศไทย</strong>
        </div>
        <table class="table table-bordered t-1">
          <thead>
            <tr>
              <th scope="col" style="vertical-align: middle;width: 12%;">PM2.5 <br> (มคก./ลบ.ม.) </th>
              <th scope="col" style="vertical-align: middle;width: 6%;">สีที่ใช้</th>
              <th scope="col" style="vertical-align: middle">ความหมาย</th>
              <th scope="col" style="vertical-align: middle">คำอธิบาย</th>
            </tr>
          </thead>
          <tbody style="font-weight: 600;">
            <tr>
              <th>0 - 25</th>
              <td><div class="circle_table" style="background: rgb(59, 204, 255);"></div></td>
              <td>คุณภาพอากาศดีมาก</td>
              <td style="text-align: left;">คุณภาพอากาศดีมาก เหมาะสำหรับกิจกรรมกลางแจ้งและการท่องเที่ยว</td>
            </tr>
            <tr>
              <th>26 - 37</th>
              <td><div class="circle_table" style="background: rgb(146, 208, 80);"></div></td>
              <td>คุณภาพอากาศดี</td>
              <td style="text-align: left;">คุณภาพอากาศดี สามารถทำกิจกรรมกลางแจ้งและการท่องเที่ยวได้ตามปกติ</td>
            </tr>
            <tr>
              <th>38 - 50</th>
              <td><div class="circle_table" style="background: rgb(255, 255, 0);"></div></td>
              <td>ปานกลาง</td>
              <td style="text-align: left;">
                <strong>ประชาชนทั่วไป</strong>
                : สามารถทำกิจกรรมกลางแจ้งได้ตามปกติ  <br>
                <strong>ผู้ที่ต้องดูแลสุขภาพเป็นพิเศษ</strong>
                : หากมีอาการเบื้องต้น เช่น ไอ หายใจลำบาก ระคายเคืองตา ควรลดระยะเวลาการทำกิจกรรมกลางแจ้ง
              </td>
            </tr>
            <tr>
              <th>51 - 90</th>
              <td><div class="circle_table" style="background: rgb(255, 162, 0);"></td>
              <td>เริ่มมีผลกระทบต่อสุขภาพ</td>
              <td style="text-align: left;">
                <strong>ประชาชนทั่วไป</strong>
                : ควรเฝ้าระวังสุขภาพ ถ้ามีอาการเบื้องต้น เช่น ไอ หายใจลำบาก ระคายเคืองตา ควรลดระยะเวลาการทำกิจกรรมกลางแจ้ง 
                หรือใช้อุปกรณ์ป้องกันตนเองหากมีความจำเป็น  <br>
                <strong>ผู้ที่ต้องดูแลสุขภาพเป็นพิเศษ</strong>
                : ควรลดระยะเวลาการทำกิจกรรมกลางแจ้ง หรือใช้อุปกรณ์ป้องกันตนเองหากมีความจำเป็น ถ้ามีอาการทางสุขภาพ เช่น ไอ 
                หายใจลำบาก ตาอักเสบ แน่นหน้าอก ปวดศีรษะ หัวใจเต้นไม่เป็นปกติ คลื่นไส้ อ่อนเพลีย ควรปรึกษาแพทย์
              </td>
            </tr>
            <tr>
              <th>91 ขึ้นไป</th>
              <td><div class="circle_table" style="background: rgb(240, 70, 70);"></td>
              <td>มีผลกระทบต่อสุขภาพ</td>
              <td style="text-align: left;">
                ทุกคนควรหลีกเลี่ยงกิจกรรมกลางแจ้งหลีกเลี่ยงพื้นที่ที่มีมลพิษทางอากาศสูง หรือใช้อุปกรณ์ป้องกันตนเองหากมีความจำเป็น 
                หากมีอาการทางสุขภาพควรปรึกษาแพทย์
              </td>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

<!-- chart -->
    <div id="graph-pm">
      <h3 style="font-weight:600;">แผนภูมิค่าเฉลี่ยข้อมูลฝุ่นละอองขนาดไม่เกิน 2.5 ไมครอน</h3>
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a id="btnChart" class="nav-link active" style="color:#989be0" onclick="showChart()">รายวัน</a>
        </li>
        <li class="nav-item">
          <a id="btnChart2" class="nav-link" onclick="showChart2()">รายสัปดาห์</a>
        </li>
      </ul>
      <div id="chart-box1">
        <div class="row">
          <div id="chart" class="col-11"></div>
          <div class="chart-temp col-1">
              <div class="d-flex flex-row justify-content-center align-items-end" style="margin-bottom:10px">
                <img class="chart-icon-temp" src="{{url('/images/temperature_chart.png')}}">
                <div class="value-chart" id="value-temp">0&#8451</div>
              </div>
              <div class="d-flex flex-row justify-content-center align-items-end" style="margin-bottom:10px">
                <img class="chart-icon-temp" src="{{url('/images/humidity_chart.png')}}">
                <div class="value-chart" id="value-hum">0%</div>
              </div>
          </div>
        </div>
      </div>
      <div id="chart-box2" style="display:none">
      <div class="row">
          <div id="chart2" class="col-11"></div>
          <div class="chart-temp col-1">
              <div class="d-flex flex-row justify-content-center align-items-end" style="margin-bottom:10px">
                <img class="chart-icon-temp" src="{{url('/images/temperature_chart.png')}}">
                <div class="value-chart" id="value-temp2">0&#8451</div>
              </div>
              <div class="d-flex flex-row justify-content-center align-items-end" style="margin-bottom:10px">
                <img class="chart-icon-temp" src="{{url('/images/humidity_chart.png')}}">
                <div class="value-chart" id="value-hum2">0%</div>
              </div>
          </div>
        </div>
      </div>
    </div>

<!-- map -->
  <div id="map-pm">
    <div class="card" id="Machinlocat">
      <h3 style="font-weight:600;" class="card-header">แผนที่แสดงพิกัดชุดตรวจวัดฝุ่นละอองในอากาศ</h3>
      <div class="">
        <div id="map"></div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="map-level-pm">
        <div class="row">
          <div class="col">ดีมาก</div>
          <div class="col">ดี</div>
          <div class="col">ปานกลาง</div>
          <div class="col">เริ่มมีผลกระทบต่อสุขภาพ</div>
          <div class="col">มีผลกระทบต่อสุขภาพ</div>
        </div>
        <div class="row tab-color">
          <div class="col" style="background-color:rgb(59, 204, 255)"></div>
          <div class="col" style="background-color:rgb(146, 208, 80)"></div>
          <div class="col" style="background-color:rgb(255, 255, 0)"></div>
          <div class="col" style="background-color:rgb(255, 162, 0)"></div>
          <div class="col" style="background-color:rgb(240, 70, 70)"></div>
        </div>
      </div>
    </div>
  </div>

<!-- dialog allow -->
<div id="display-allow">
    <div id="body-allow" class="card">
        <div class="card-body" stu>
          <p style="text-align:center;font-weight: 600;">กดอนุญาตเพื่อให้แจ้งเตือนค่าฝุ่นละอองในอากาศ PM 2.5</p>
            <div style="display:flex;justify-content: space-evenly;">
              <button class="btn btn-primary" onclick="notiAllow()">อนุญาติ</button>
              <button class="btn btn-danger"  onclick="clossAllow()">ไม่อนุญาติ</button>
            </div>
        </div>
    </div>
</div>

          </div>
      </div>
    </div>
</div>


<script type="text/javascript">

let topic_status;
let topic_pm;
let topic_temp;
let topic_hum;
let pm;
let machineList = <?php echo $machine ?>;
let div_pm = document.getElementById("pm");
let div_temp = document.getElementById("temp");
let div_hum = document.getElementById("hum");
let chartBox1 = document.getElementById("chart-box1");
let chartBox2 = document.getElementById("chart-box2");
let chart1 = document.getElementById("chart");
let chart2 = document.getElementById("chart2");
let temp_value = document.getElementById("value-temp");
let hum_value = document.getElementById("value-hum");
let temp_value2 = document.getElementById("value-temp2");
let hum_value2 = document.getElementById("value-hum2");
let color_level = document.getElementById("color-level-pm24");
let level_pm24 = document.getElementById("level-pm24");
let details_pm24 = document.getElementById("details-pm24");
let value_pm24 = document.getElementById("value-pm24");
let pm_level = 0;

function setAddress(){
    let macid = document.getElementById("local_mac").value;
    if(macid != ""){
        machineList.map((val,key) => {
            if(macid == val.machine_id){
                clearDiv();
                console.log("id: "+ macid + "," + val.machine_id);
                topic_status = val.topic_status;
                topic_pm = val.topic_pm;
                topic_temp = val.topic_temp;
                topic_hum = val.topic_hum;
                Mqtt();
                getPm(macid);
                pmRealtime(macid)
                if(chartBox2.style.display == "none"){
                  getChart(macid);
                } else if(chartBox1.style.display == "none"){
                  getChartWeek(macid);
                }
            }
        });
    } else {
        console.log("data machine is null");
    }
} setAddress();

// clear
function clearDiv(){
    div_pm.innerHTML = "0.00";
    div_temp.innerHTML = "0.00";
    div_hum.innerHTML = "0.00";
    chart1.innerHTML = "";
    chart2.innerHTML = "";
    temp_value.innerHTML = "0&#8451";
    hum_value.innerHTML = "0%";
    temp_value2.innerHTML = "0&#8451";
    hum_value2.innerHTML = "0%";
    pm_level = 0;
    value_pm24.innerHTML = "0";
    color_level.style.backgroundColor = "#ccc";
    level_pm24.innerHTML = "กรุณารอสักครู่...";
    details_pm24.innerHTML = "กรุณารอสักครู่...";
    pm = 0;
}

// get data from Mqtt
function Mqtt(){
    const id = Math.random().toString(36).substring(2);
    client = new Paho.MQTT.Client("10.133.0.121", Number(9001),id);
    if(!client){
        console.log("not connect");
    }
        
    client.onConnectionLost = onConnectionLost;
    client.onMessageArrived = onMessageArrived;

    client.connect({onSuccess:onConnect});

    function onConnect() {
        console.log("onConnect");
        client.subscribe(topic_status);
        client.subscribe(topic_pm);
        client.subscribe(topic_temp);
        client.subscribe(topic_hum);
    }

    function onConnectionLost(responseObject) {
        if (responseObject.errorCode !== 0) {
            console.log("onConnectionLost:" + responseObject.errorMessage);
            // alert("There was an error with the server, please check")
        } else {
            console.log("connect");
        }
    }

    function onMessageArrived(message) {
        if(message.destinationName == topic_status){
            console.log("status machine :" + message.payloadString);
            status_machine = message.payloadString;
            if(status_machine == "on"){
              console.log("machine on");
            } else {
              console.log("machine off");
            }
        } else if(message.destinationName == topic_pm){
            console.log("PM 2.5:" + message.payloadString);
            div_pm.innerHTML = message.payloadString;
        } else if(message.destinationName == topic_temp){
            console.log("Temperature:" + message.payloadString);
            div_temp.innerHTML = message.payloadString;
        } else if(message.destinationName == topic_hum){
            console.log("Humidity:" + message.payloadString);
            div_hum.innerHTML = message.payloadString;
        } else {
            console.log("Don't know this topic " + message.destinationName);
        }
    }
}

// get chart
function getChart(macid){
    $.ajax({
        type: "POST",
        url: "/weather-chart",
        data: {id: macid},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: (response) => {
        if(response){
            chartDay = JSON.parse(response);
            if(chartDay.length > 1){
                Graph(chartDay);
                getAvg(macid);
            }else{
                noData();
                console.log("not data")
            }
        }
        } 
    });
}

function getChartWeek(macid){
    $.ajax({
        type: "POST",
        url: "/weather-chartWeek",
        data: {id: macid},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: (response) => {
        if(response){
            chartWeek = JSON.parse(response);
            if(chartWeek.length > 1){
                Graph2(chartWeek);
                getweekAvg(macid);
            }else{
                noData();
                console.log("not data")
            }
        }
        } 
    });
}

// no data
function noData(){
    let item = document.createElement('h1');
    item.textContent = "ไม่พบข้อมูล";
    item.classList.add('no-data');
    if(chartBox2.style.display == "none"){
        chart1.innerHTML = "";
        chart1.appendChild(item);
    } else if(chartBox1.style.display == "none"){
        chart2.innerHTML = "";
        chart2.appendChild(item);
    }
}


// Chart
function Graph(chartDay) {
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    
    function drawChart(){
      var data = google.visualization.arrayToDataTable(chartDay);
      var options = {
        chartArea: {
          left: '12%',
          top:40,
          right:'5%',
          width: '100%'
        },
        legend: {
          position: 'top'
        },
        width: '100%',
        pointSize: 5,
        hAxis : { 
          // textPosition: 'none',
          textStyle:{
            fontSize: 12 
          }
        }
      };
      var chart = new google.visualization.LineChart(document.getElementById('chart'));
      chart.draw(data, options);
    }
}
  function Graph2(chartWeek){
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable(chartWeek);
      var options = {
        chartArea: {
          left: '10%',
          top:40,
          right:'5%',
          width: '100%'
        },
        legend: {
          position: 'top'
        },
        width: '100%',
        pointSize: 5,
        vAxis: {minValue: 0}
      };
      var chart = new google.visualization.LineChart(document.getElementById('chart2'));
      chart.draw(data, options);
    }
  }

$(window).resize(function(){
  let macid = document.getElementById("local_mac").value;
  if(chartBox2.style.display == "none"){
      getChart(macid);
  } else if(chartBox1.style.display == "none"){
      getChartWeek(macid);
  }
});

// let dataRequest;
function getPm(macid){
  $.ajax({
        type: "POST",
        url: "/weather-pm24",
        data: {id: macid},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: (response) => {
        if(response){
          arr = response;
            if(arr.length > 0){
              pmAvg(arr);
            }else{
              console.log("not data")
            }
          }else{
              console.log("not response")
          }
        } 
    });
}

function pmRealtime(macid){
  setInterval(() => {
    getPm(macid);
  }, 60 * 1000);
}

function pmAvg(arr){
  // let pm;
  arr.map((val,key) => {
      pm = val.pmavg;
  })

  if(!pm){
    // alert("กรุณาเปลี่ยนสถานที่ใหม่ ขออภัยในความไม่สะดวก");
    pm = 0;
  }else{
    pm = parseFloat(pm).toFixed(0);
    if(pm != pm_level){
      pm_level = pm;
      setDataPM(pm);
      console.log("New: " + pm + "," + pm_level);
    }else if(pm == pm_level){
      console.log("Not update: " + pm + "," + pm_level);
    }
  }
}

//  get temp-hum
function getAvg(macid){
  $.ajax({
        type: "POST",
        url: "/weather-data24",
        data: {id: macid},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: (response) => {
        if(response){
          arr = response;
            if(arr.length > 0){
              setAvg(arr);
            }else{
              console.log("not data")
            }
          }else{
              console.log("not response")
          }
        } 
    });
}

function getweekAvg(macid){
  $.ajax({
        type: "POST",
        url: "/weather-data7",
        data: {id: macid},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: (response) => {
        if(response){
          arr = response;
            if(arr.length > 0){
              setWAvg(arr);
            }else{
              console.log("not data")
            }
          }else{
              console.log("not response")
          }
        } 
    });
}

function setWAvg(arr){
  let temp;
  let hum;
  let temp_value2 = document.getElementById("value-temp2");
  let hum_value2 = document.getElementById("value-hum2");
  arr.map((val,key) => {
      temp = val.tempavg;
      hum = val.humavg;
  })
  temp = parseFloat(temp).toFixed(0);
  hum = parseFloat(hum).toFixed(0);
  temp_value2.innerHTML = `${temp + "&#8451"}`;
  hum_value2.innerHTML = `${hum + "%"}`;
}

function setAvg(arr){
  let temp;
  let hum;
  let temp_value = document.getElementById("value-temp");
  let hum_value = document.getElementById("value-hum");
  arr.map((val,key) => {
      temp = val.tempavg;
      hum = val.humavg;
  })
  temp = parseFloat(temp).toFixed(0);
  hum = parseFloat(hum).toFixed(0);
  temp_value.innerHTML = `${temp + "&#8451"}`;
  hum_value.innerHTML = `${hum + "%"}`;
}

function init() {

  var locationList = <?php echo json_encode($location) ?> ;
    // var map = new longdo.Map({
    //     placeholder: document.getElementById('map')
    // });
    // map.location({ lon:103.1011 , lat:14.9904},true);
    // map.Ui.DPad.visible(false);
    // map.Ui.Zoombar.visible(false);
    // map.Ui.Geolocation.visible(false);
    // map.Ui.Toolbar.visible(false);
    // map.Ui.Fullscreen.visible(false);
    // map.Ui.Crosshair.visible(false);
    // map.zoom(14, true);
    // for (var i = 0; i < locationList.length; ++i) {
    //   // let pm25 = locationList[i].macpm;
    //   var color;
    //   let pm25 = parseFloat(locationList[i].macpm).toFixed(0);

    //   if(pm25 >= 91){
    //     color = "rgb(240, 70, 70)";
    //   } else if (pm25 >= 51 ){
    //     color = "rgb(255, 162, 0)";
    //   } else if(pm25 >= 38){
    //     color = "rgb(255, 255, 0)";
    //   } else if(pm25 >= 26){
    //     color = "rgb(146, 208, 80)";
    //   } else if(pm25 >= 0){
    //     color = "rgb(59, 204, 255)";
    //   } else{
    //     color = "black";
    //   }
    //   map.Overlays.add(new longdo.Marker({lon: locationList[i].longitude, lat: locationList[i].latitude },
    //       {
    //         title: locationList[i].machine_name,
    //         icon: {
    //           html:  `<div class="icon-map-box">
    //                     <div id="iconmap" style="background-color:${color};"></div>
    //                     <strong class="mappm">${pm25}</strong>
    //                 </div>`,
    //           offset: { x: 18, y: 21 }
    //           },
    //         detail: `${locationList[i].longitude},${locationList[i].latitude}`,
    //         draggable: true,
    //         weight: longdo.OverlayWeight.Top
    //   }));
    // }
    
  }



  function setDataPM(req){
  if(req){
    console.log(req);
    document.getElementById("value-pm24").innerHTML = req;
    if(req >= 91){
      showNotification("ควรหลีกเลี่ยงการทำกิจกรรมในพื้นที่ เนื่องจากในพื้นที่มีมลพิษสูง");
      document.getElementById("color-level-pm24").style.backgroundColor = "rgb(240, 70, 70)";
      document.getElementById("level-pm24").innerHTML = "มีผลกระทบต่อสุขภาพ";
      document.getElementById("details-pm24").innerHTML = "ทุกคนควรหลีกเลี่ยงกิจกรรมกลางแจ้งหลีกเลี่ยงพื้นที่ที่มีมลพิษทางอากาศสูง หรือใช้อุปกรณ์ป้องกันตนเองหากมีความจำเป็น หากมีอาการทางสุขภาพควรปรึกษาแพทย์";
    } else if(req >= 51){
      showNotification("ควรลดระยะเวลาการทำกิจกรรมกลางแจ้ง");
      document.getElementById("color-level-pm24").style.backgroundColor = "rgb(255, 162, 0)";
      document.getElementById("level-pm24").innerHTML = "เริ่มมีผลกระทบต่อสุขภาพ";
      document.getElementById("details-pm24").innerHTML = "ควรเฝ้าระวังสุขภาพ ถ้ามีอาการเบื้องต้น เช่น ไอ หายใจลำบาก ระคายเคืองตา ควรลดระยะเวลาการทำกิจกรรมกลางแจ้ง หรือใช้อุปกรณ์ป้องกันตนเองหากมีความจำเป็น";
    } else if(req >= 38){
      document.getElementById("color-level-pm24").style.backgroundColor = "rgb(255, 255, 0)";
      document.getElementById("level-pm24").innerHTML = "ปานกลาง";
      document.getElementById("details-pm24").innerHTML = "สามารถทำกิจกรรมกลางแจ้งได้ตามปกติ";
    } else if(req >= 26){
      document.getElementById("color-level-pm24").style.backgroundColor = "rgb(146, 208, 80)";
      document.getElementById("level-pm24").innerHTML = "คุณภาพอากาศดี";
      document.getElementById("details-pm24").innerHTML = "คุณภาพอากาศดี สามารถทำกิจกรรมกลางแจ้งและการท่องเที่ยวได้ตามปกติ";
    } else if(req >= 0) {
      document.getElementById("color-level-pm24").style.backgroundColor = "rgb(59, 204, 255)";
      document.getElementById("level-pm24").innerHTML = "คุณภาพอากาศดีมาก";
      document.getElementById("details-pm24").innerHTML = "คุณภาพอากาศดีมาก เหมาะสำหรับกิจกรรมกลางแจ้งและการท่องเที่ยว";
    }
  } else {
    console.log("No response or error may occur.");
  }
}

// notify
const showNotification = (res) => {
  const notification = new Notification('New messege from IT Weather', {
    body: res,
    icon: '/images/LogoHead-1.png'
  });

  setTimeout(() => {
    notification.close();
  }, 60 * 1000);

    notification.addEventListener('click', () => {
    window.open('/');
  });
}

var granted = false;
if(Notification.permission === 'granted'){
  document.getElementById("display-allow").style.display = "none";
}
const checkAllow = setInterval(() => {
  if(Notification.permission === 'granted'){
    document.getElementById("display-allow").style.display = "none";
    // console.log(granted);
    clearInterval(checkAllow);
  }
}, 1000);

const notiAllow = () => {
  if (Notification.permission === 'granted') {
    granted = true;
  } else if (Notification.permission !== 'denied') {
    let permission = Notification.requestPermission();
    granted = permission === 'granted' ? true : false;
  }
}

const clossAllow = () => {
  document.getElementById("display-allow").style.display = "none";
}

// show-table
function showTable(){
  var x = document.getElementById("details-level");
  var arrow = document.getElementsByClassName("arrow")[0];
  if (x.style.display === "none") {
    x.style.display = "block";
    arrow.classList.add("arrow-rotate");
  } else {
    x.style.display = "none";
    arrow.classList.remove("arrow-rotate");
  }
}
// show graph
function showChart(){
    let macid = document.getElementById("local_mac").value;
    chartBox2.style.display = "none";
    document.getElementById("btnChart2").classList.remove("active");
    document.getElementById("btnChart2").style.color = "#000000";
    chartBox1.style.display = "block";
    document.getElementById("btnChart").classList.add("active");
    document.getElementById("btnChart").style.color = "#989be0";
    if(macid != ""){
        getChart(macid);
    }else{
        console.log("data machine is null")
    }
}
function showChart2(){
    let macid = document.getElementById("local_mac").value;
    chartBox1.style.display = "none";
    document.getElementById("btnChart").classList.remove("active");
    document.getElementById("btnChart").style.color = "#000000";
    chartBox2.style.display = "block";
    document.getElementById("btnChart2").classList.add("active");
    document.getElementById("btnChart2").style.color = "#989be0";
    if(macid != ""){
        getChartWeek(macid);
    }else{
        console.log("data machine is null")
    }
}


// Change image
changeImage()
function changeImage(){
  let time = new Date().getHours();
  let image = document.getElementById("sesor-realtime");
  let select = document.getElementById("local_mac");
  if(time >= 6 && time <  9){
    image.style.backgroundImage = "url('/images/morning.jpg')"
    image.style.color = "white";
    select.style.color = "white";
  } else if(time >= 9 && time < 16 ){
    image.style.backgroundImage = "url('/images/day.jpg')"
    image.style.color = "black";
    select.style.color = "black";
  } else if(time >= 16 && time < 19){
    image.style.backgroundImage = "url('/images/evening.jpg')"
    image.style.color = "#a5a5a5";
    select.style.color = "#a5a5a5";
  } else if(time >= 19 || time < 6){
    image.style.backgroundImage = "url('/images/nigth.jpg')"
    image.style.color = "white";
    select.style.color = "white";
  }
}

// scroll click
function clickScroll(id){
  document.getElementById(`${id}`).scrollIntoView({
    behavior: 'smooth'
  });
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