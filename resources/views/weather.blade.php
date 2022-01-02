<!DOCTYPE html>
<html>
<head>
  <!-- Bootstrap 4 css -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <!-- css -->
  <link rel="stylesheet" type="text/css" href="{{ url('/css/styles.css') }}" />
  <!-- My Js -->
  <script type="text/javascript" src="{{ asset('js/paho-mqtt.js') }}"></script>
  <!-- Jquery -->
  <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <!-- Google Chart -->
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>IT Weather</title>

<script type="text/javascript">
  // get data from Mqtt
client = new Paho.MQTT.Client("192.168.1.29", Number(9001),"");
if(!client){
  console.log("not connect");
}
client.onConnectionLost = onConnectionLost;
client.onMessageArrived = onMessageArrived;

client.connect({onSuccess:onConnect});

function onConnect() {
  console.log("onConnect");
  document.getElementById("display-connect").innerHTML = "Connected";
  client.subscribe("TEST/MQTT");
  client.subscribe("TEST/PM");
  client.subscribe("TEST/HUM");
}

function onConnectionLost(responseObject) {
  if (responseObject.errorCode !== 0) {
    console.log("onConnectionLost:"+responseObject.errorMessage);
  } else {
    console.log("connect");
  }
}

function onMessageArrived(message) {
  if(message.destinationName == "TEST/MQTT"){
    console.log("Temp:" + message.payloadString);
    document.getElementById("tamp").innerHTML = message.payloadString;

  } else if(message.destinationName == "TEST/PM"){
    console.log("PM:" + message.payloadString);
    document.getElementById("pm").innerHTML = message.payloadString;

  } else if(message.destinationName == "TEST/HUM"){
    console.log("Humidity:" + message.payloadString);
    document.getElementById("hum").innerHTML = message.payloadString;

  }
}
// Chart
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable(<?php echo $dataDay ?>);

        var options = {
          title: 'ค่า PM 2.5 ราย 24 ชั่วโมง ',
          curveType: 'function',
          legend: { position: 'bottom' },
          pointSize: 5,
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart'));

        chart.draw(data, options);
      }
// ajax 
$(document).ready(()=>{
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    type: "GET",
    url: "/weather-pm24",
    success: (response) => {
      if(response){
        setDataPM(response);
      }
    } 
  });
  setInterval(() => {
    $.ajax({
        type: "GET",
        url: "/weather-pm24",
        success: (response) => {
          if(response){
            setDataPM(response);
          } else {
            console.log("Not havel response");
          }
        }
    });
  }, 60 * 1000);
});

  </script>
</head>

<body >

<!-- Image and text -->
<nav class="navbar navbar-light bar-1">
  <a class="navbar-brand">
    <img src="{{url('/images/bru.png')}}" class="bru-img" >
    <img src="{{url('/images/LogoHead-1.png')}}" class="it-img" >
  </a>
  <a class="navbar-brand">
    <a href="/chartPm">ข้อมูลย้อนหลัง</a>
  </a>
</nav>

  <!-- display data from sensor -->
  <div class="container">
    <h1>IT Weather</h1>
    <div class="weather row">
      <div class="PM col-6">
        <h1 class="">PM 2.5</h1>
        <div class="d-flex flex-row justify-content-center">
          <img class="pm-img" src="{{url('/images/pm25.png')}}">
          <p id="pm">0.00</p>
          <span class="pm-symbol">µg/m</span>
        </div>
      </div>

      <div class="t-h col-6">
        <div class="Temperature col-4">
          <h1>Temperature</h1>
          <div class="d-flex flex-row justify-content-center">
            <img class="temp-img" src="{{url('/images/temperatures.png')}}">
            <p id="tamp">0.00</p>
            <span class="temp-symbol">&#8451;</span>
          </div>
        </div>
        <div class="Humidity col-4">
            <h1>Humidity</h1>
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
  <div class="container">
    <div class="card-pm24">
      <div class="head-pm24">
        <h4>ค่าเฉลี่ยฝุ่นละออง PM 2.5 ราย 24 ชั่วโมง</h4>
      </div>
      <div class="body-pm24 row">
        <div class="col-4">
          <div id="value-pm24"><?php echo $pmavg ?></div>
        </div>
        <div class="col-8">
          <div>
            <div id="color-level-pm24"></div>
            <div id="level-pm24"></div>
            <div id="details-pm24"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- details level pm -->
  <div class="container">
    <div class="details-level">
      <div class="head-d-level">
        <strong>เกณฑ์ค่าความเข้มข้นของ PM 2.5 ของประเทศไทย</strong>
      </div>
      <table class="table table-bordered t-1">
        <thead>
          <tr>
            <th scope="col">PM 2.5 (µg/m³)</th>
            <th scope="col">สีที่ใช้</th>
            <th scope="col">ความหมาย</th>
            <th scope="col">คำอธิบาย</th>
          </tr>
        </thead>
        <tbody>
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

  <div class="col-md-12 pmDay" id="pm1">
      <h1>คุณภาพอากาศ 24 ชั่วโมง</h1>
        <div id="chart" style="width: 1200px; height: 600px;"></div>
    </div>
    <?php echo $dataDay ?>
</body>

<script>
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
      document.getElementById("level-pm24").innerHTML = "คุณภาพอากาศ";
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
function showNotification(req){
  console.log(Notification.permission);
    if(Notification.permission === "granted"){
      const notification = new Notification("New messege from IT Weather",{
            body:`${req}`
        });
    }else if(Notification.permission !== "denied"){
        Notification.requestPermission().then(permissoin => {
            if(permission === "granted"){
                const notification = new Notification("New messege from IT Weather",{
                  body:`${req}`
                });
            }
        });
    }
}

</script>

</html>