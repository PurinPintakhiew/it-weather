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
  
<script type="text/javascript">
  // get data from Mqtt
client = new Paho.MQTT.Client("10.133.1.0", Number(9001),"c");
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
// end
// Chart
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable(<?php echo $dataDay ?>);

        var options = {
          title: 'ค่าเฉลี่ย PM 2.5 ราย 24 ชั่วโมง ',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart'));

        chart.draw(data, options);
      }

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
    <a href="/chartPm">สถิตค่าฝุ่นละอองรายวัน</a>
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

  <div class="col-md-12 pmDay" id="pm1">
      <h1>ค่าสถิติ PM 2.5 รายวัน</h1>
        <div id="chart" style="width: 1200px; height: 600px;"></div>
        <p><?php?>
        </p>
    </div>

</body>
</html>