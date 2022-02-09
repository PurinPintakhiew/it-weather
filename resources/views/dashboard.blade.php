<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard</title>
    <link rel="icon" href="{{url('/images/LOGO-IT.png')}}" type="image/gif" sizes="16x16">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@100&display=swap" rel="stylesheet">

    <!-- Boostrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Jquery -->
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>  

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@100&display=swap" rel="stylesheet">

    <!-- Styles -->
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
    <link rel="stylesheet" type="text/css" href="{{ url('/css/login.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('/css/admin.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('/css/fontello.css') }}" />

    <!-- Google Chart -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- Map -->
    <!-- <script type="text/javascript" src="https://api.longdo.com/map/?key=42eb94007e1a5d73e5ad3fcba45b5734"></script> -->

</head>
<body onload="init()">

<!-- bar -->
<nav class="navbar navbar-expand-md shadow-sm" style="background-color:#6165f8;">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">
            <img id="icon-weather" src="{{url('/images/it-weather2.png')}}" >
        </a>
        <div class="collapss">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active"  aria-current="page"  href="/register">เพิ่มผู้ดูแล</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="dropdown-list" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdown-list">
                        <a class="dropdown-item" href="{{ route('logout') }}">
                            {{ __('Logout') }}
                        </a>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- dashboard -->

<div class="container">

    <div class="row">
        <div class="col pm-box">
            <p>PM 2.5</p>
            <div class="pm-body d-flex justify-content-center">
                <h1 id="pm">0.00</h1>
                <span class="pm-symbol">µg/&#13221</span>
            </div>
        </div>
        <div class="col temp-box">
            <p>Temperature</p>
            <div class="temp-body d-flex justify-content-center">
                <h1 id="temp">0.00</h1>
                <span class="pm-symbol">&#8451</span>
            </div>
        </div>
        <div class="col hum-box">
            <p>Humidity</p>
            <div class="hum-body d-flex justify-content-center">
                <h1 id="hum">0.00</h1>
                <span class="pm-symbol">%</span>
            </div>
        </div>
    </div>

    <div id="box-control">
        <div class="row">
            <div class="status-machine col-lg-4">
                <div style="text-align:center">
                    <span>Status Machine</span>
                    <div id="light-status-machine" class="mb-2"></div>
                </div>
                <div style="border:1px solid #ccc;padding: 5px 20px 10px 20px;">
                    <div style="text-align:center">
                        <span class="mb-2 span-control">Control Panel</span>
                    </div >
                    <span class="mb-2 span-topic">Machine</span>
                    <div class="d-flex align-items-center mb-2">
                        <span>OFF</span>
                        <label class="switch">
                            <input type="checkbox" id="checkbox_onoff">
                            <span class="slider round"></span>
                        </label>
                        <span>ON</span>
                    </div>
                    <span class="mb-2 span-topic">Motor Mode</span>
                    <div class="d-flex align-items-center mb-2">
                        <span>Auto</span>
                        <label class="switch">
                            <input type="checkbox" id="checkbox_mode">
                            <span class="slider round"></span>
                        </label>
                        <span>Manual</span>
                        <div class="sub-manual">
                            <span>UP</span>
                            <label class="switch">
                                <input type="checkbox" id="checkbox_onoff">
                                <span class="slider round"></span>
                            </label>
                            <span>Down</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="machine col-lg-5">
                <label class="label-m">Machine Name</label>
                <select class="form-select" id="macid"  onchange="setAddress()">
                    @foreach($machines as $machine)
                    <option value="{{$machine->machine_id}}">{{$machine->machine_name}}</option>
                    @endforeach
                </select>
                <label class="label-m">Machine Address</label>
                <input type="text" class="form-control" id="address" disabled>
            </div>
            <div class="status-mqtt col-lg-3" style="text-align:center">
                <span>Status Server</span>
                <div id="light-status-mqtt"></div>
            </div>
        </div>
    </div>

    <div id="map-location">
        <div class="row">
            <div id="map-box" class="col-7">
                <div id="map"></div>
            </div>
            <div id="machine-box" class="col-5 card-machine">
                <div id="machine-list" class="card-machine-body">
                    <table class="table">
                        <thead class="table-h">
                            <tr>
                                <th>Machine Name</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-b">
                            @foreach($machines as $machine)
                            <tr>
                                <td class="table-d">{{$machine->machine_name}}</td>
                                <td  class="table-d">{{$machine->latitude}}</td>
                                <td  class="table-d">{{$machine->longitude}}</td>
                                <td style="">
                                    <i class="icon-pencil" onclick="goEdit('/edit/{{$machine->machine_id}}')"></i>
                                    <i class="icon-trash-empty" onclick="showDelete({{$machine->machine_id}})"></i>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-machine-footer">
                    <button id="showAdd" type="button" class="btn btn-success" onclick="showAdd()">Add Machine</button>
                </div>
            </div>
        </div>
    </div>

    <!-- chart -->
    <div id="graph-pm">
      <h3>Weather Graph</h3>
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a id="btnChart" class="nav-link active" style="color:#989be0" onclick="showChart()">Day</a>
        </li>
        <li class="nav-item">
          <a id="btnChart2" class="nav-link" onclick="showChart2()">Week</a>
        </li>
      </ul>
      <div id="chart-box1">
        <div class="row">
          <div id="chart" class=""></div>
        </div>
      </div>
      <div id="chart-box2" style="display:none">
      <div class="row">
          <div id="chart2" class=""></div>
        </div>
      </div>
    </div>

</div> 

<!-- <div class="container">
    <div class="card-control">
        <div class="status-p">
            <span id="status">Not Connect</span>
        </div>
        <div class="control-mode">
            <p>Auto Mode</p>
            <label class="switch">
                <input type="checkbox" id="checkbox_on" onclick="setCheckbox()">
                <span class="slider round"></span>
            </label>
        </div>
        <div class="machine row">
            <div class="col-6 mac">
                <label class="label-m">Machine ID</label>
                <select class="form-select" id="select-topic">
                    @foreach($machines as $machine)
                    <option value="{{$machine->machine_name}}">{{$machine->machine_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">

            <div class="col pm-box">
                <p>PM 2.5</p>
                <div class="pm-body d-flex justify-content-center">
                    <h1 id="pm">0.00</h1>
                    <span class="pm-symbol">µg/&#13221</span>
                </div>
            </div>
            <div class="col temp-box">
                <p>Temperature</p>
                <div class="temp-body d-flex justify-content-center">
                    <h1 id="temp">0.00</h1>
                    <span class="pm-symbol">&#8451</span>
                </div>
            </div>
            <div class="col hum-box ">
                <p>Humidity</p>
                <div class="hum-body d-flex justify-content-center">
                    <h1 id="hum">0.00</h1>
                    <span class="pm-symbol">%</span>
                </div>
            </div>

        </div>
    </div>

    <table class="table">
        <thead class="table-h">
            <tr>
                <th>Machine ID</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="table-b">
            @foreach($machines as $machine)
            <tr>
                <td class="table-d">{{$machine->machine_id}}</td>
                <td  class="table-d">{{$machine->latitude}}</td>
                <td  class="table-d">{{$machine->longitude}}</td>
                <td style="text-align:center">
                    <a class="btn btn-warning" href="/edit/{{$machine->machine_id}}">Edit</a>
                    <button class="btn btn-danger" onclick="showDelete({{$machine->machine_id}})">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="">
        <button id="showAdd" type="button" class="btn btn-success" onclick="showAdd()">Add Machine</button>
    </div>


<div id="dialog-delete">
    <div id="dialog-form" class="col-md-2 col-sm-5">
        <div class="card">
            <div class="card-header" style="text-align:center">
               <p>You confirm to delete</p>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-evenly">
                    <button type="submit" class="btn btn-primary" onclick="deleteMac()">Yes</button>
                    <button class="btn btn-danger" onclick="closs()">No</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="toru"></div>
</div> -->

<!-- dialog add -->
<div id="dialog-background">
    <div id="dialog-form" class="col-5">
        <div class="card">
            <div class="card-header">
                <h5 style="text-align:center">Add Machine Location</h5>
            </div>
            <div class="card-body">
                <form  action="{{route('saveMac')}}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Machine name</label>
                        <input type="text" class="form-control" name="set_name">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Latitude</label>
                        <input type="text" class="form-control" name="set_lat">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Longitude</label>
                        <input type="text" class="form-control" name="set_long">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Add</button>
                        <button type="button" class="btn btn-danger" onclick="closs()">Cancle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="{{ asset('js/paho-mqtt.js') }}"></script>
<script type="text/javascript">

const id = Math.random().toString(36).substring(2);
client = new Paho.MQTT.Client("10.30.164.12", Number(9001),id);
    if(!client){
        console.log("not connect");
    }
        
    client.onConnectionLost = onConnectionLost;
    client.onMessageArrived = onMessageArrived;

client.connect({onSuccess:onConnect});

function onConnect() {
    console.log("onConnect");
    document.getElementById("light-status-mqtt").style.backgroundColor = "rgb(132 255 59)";
    client.subscribe("it_bru/project/pm");
    client.subscribe("it_bru/project/temp");
    client.subscribe("it_bru/project/hum");
}

function onConnectionLost(responseObject) {
  if (responseObject.errorCode !== 0) {
    console.log("onConnectionLost:" + responseObject.errorMessage);
  } else {
    console.log("connect");
  }
}

function onMessageArrived(message) {
  if(message.destinationName == "it_bru/project/pm"){
    console.log("PM 2.5:" + message.payloadString);
    document.getElementById("pm").innerHTML = message.payloadString;
  } else if(message.destinationName == "it_bru/project/temp"){
    console.log("Temperature:" + message.payloadString);
    document.getElementById("temp").innerHTML = message.payloadString;
  } else if(message.destinationName == "it_bru/project/hum"){
    console.log("Humidity:" + message.payloadString);
    document.getElementById("hum").innerHTML = message.payloadString;
  }
}

// show dialog add
function showAdd(){
    document.getElementById("dialog-background").style.display = "block";
}

// closs dialog 
function closs(){
    document.getElementById("dialog-background").style.display = "none";
    document.getElementById("dialog-delete").style.display = "none";
}

// go edit
function goEdit(path){
    window.location = `${path}`;
}

// closs dialog delete
var delID;
function showDelete(id){
    delID = id;
    document.getElementById("dialog-delete").style.display = "block";
}

// delete location
function deleteMac(){
    $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
    $.ajax({
        type: "GET",
        url:`/delMachine/${delID}`,
        success:(response) => {
          if(response){
            console.log(response);
            document.getElementById("dialog-delete").style.display = "none";
          } else{
            console.log("Not have response");
          }
        }
    })
}

function setCheckbox(){
    var checkBox = document.getElementById("checkbox_on").checked;
    // var itMac = document.getElementById("select-topic").value;
    var itMac = "it_bru/project/motor";
    if(checkBox == true){
        document.getElementById("toru").innerHTML = "on" + itMac;
        msg = "1";
        message = new Paho.MQTT.Message(msg);
        message.destinationName = itMac;
        client.send(message);
    }else{
        document.getElementById("toru").innerHTML = "off" + itMac;
        msg = "2";
        message = new Paho.MQTT.Message(msg);
        message.destinationName = itMac;
        client.send(message);
    }
}

// set input address
var macid = document.getElementById("macid").value;
var machineList = <?php echo $machines ?>;
var chartDay = new Array();
var chartWeek = new Array();

setAddress();
function setAddress(){
    let address = document.getElementById("address");
    machineList.map((val,key) => {
        if(macid == val.machine_id){
            console.log("id: "+ macid + "," + val.machine_id);
            address.value = val.address;
        }
    })
    if(document.getElementById("chart-box2").style.display == "none"){
        getChart(macid);
    }else if(document.getElementById("chart-box1").style.display == "none"){
        getChartWeek(macid);
    }
}

// get chart
function getChart(macid){
    $.ajax({
        type: "POST",
        url: "/getChart",
        data: {id: macid},
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: (response) => {
        if(response){
            chartDay = JSON.parse(response);
            if(chartDay.length > 0){
                Graph(chartDay);
                console.log(chartDay);
            }else{
            console.log("not data")
            }
        }
        } 
    });
}

function getChartWeek(macid){
    $.ajax({
        type: "POST",
        url: "/getChartWeek",
        data: {id: macid},
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: (response) => {
        if(response){
            chartWeek = JSON.parse(response);
            if(chartWeek.length > 0){
                Graph2(chartWeek);
                console.log(chartWeek);
            }else{
            console.log("not data")
            }
        }
        } 
    });
}

// map
function init() {

var locationList = <?php echo json_encode($map) ?>;

//   var map = new longdo.Map({
//       placeholder: document.getElementById('map')
//   });
//   for (var i = 0; i < locationList.length; ++i) {
//     let pm25 = parseFloat(locationList[i].macpm).toFixed(0);
//     var color;
//     if(pm25 >= 91){
//       color = "rgb(240, 70, 70)";
//     } else if (pm25 >= 51 ){
//       color = "rgb(255, 162, 0)";
//     } else if(pm25 >= 38){
//       color = "rgb(255, 255, 0)";
//     } else if(pm25 >= 26){
//       color = "rgb(146, 208, 80)";
//     } else if(pm25 >= 0){
//       color = "rgb(59, 204, 255)";
//     } else{
//       color = "black";
//     }
//     map.Overlays.add(new longdo.Marker({lon: locationList[i].longitude, lat: locationList[i].latitude },
//         {
//           title: 'Custom Marker',
//           icon: {
//             html:  `<div class="icon-map-box">
//                       <div id="iconmap" style="background-color:${color};"></div>
//                       <strong class="mappm">${pm25}</strong>
//                   </div>`,
//             offset: { x: 18, y: 21 }
//             },
//           popup: {
//             html: '<div style="background: #eeeeff;">popup</div>'
//             }
//     }));
//   }
}

// show graph
function showChart(){
  document.getElementById("chart-box2").style.display = "none";
  document.getElementById("btnChart2").classList.remove("active");
  document.getElementById("btnChart2").style.color = "#000000";
  document.getElementById("chart-box1").style.display = "block";
  document.getElementById("btnChart").classList.add("active");
  document.getElementById("btnChart").style.color = "#989be0";
  if(chartDay.length > 0){
    Graph(chartDay);
  }else{
      getChart(macid);
  }
}
function showChart2(){
  document.getElementById("chart-box1").style.display = "none";
  document.getElementById("btnChart").classList.remove("active");
  document.getElementById("btnChart").style.color = "#000000";
  document.getElementById("chart-box2").style.display = "block";
  document.getElementById("btnChart2").classList.add("active");
  document.getElementById("btnChart2").style.color = "#989be0";
  if(chartWeek.length > 0){
    Graph2(chartWeek);
  }else{
    getChartWeek(macid);
  }
}

// chart
function Graph(chartDay) {
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    
    function drawChart(){
      var data = google.visualization.arrayToDataTable(chartDay);
      var options = {
        chartArea: {
          left: 80,
          top:40,
          // bottom:50,
          width: '100%'
        },
        legend: {
          position: 'top'
        },
        width: '100%',
        pointSize: 5
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
          left: 40,
          top:40,
          width: '100%'
        },
        legend: {
          position: 'top'
        },
        width: '100%',
        pointSize: 5
      };
      var chart = new google.visualization.LineChart(document.getElementById('chart2'));
      chart.draw(data, options);
    }
  }

  $(window).resize(function(){
    if(document.getElementById("chart-box2").style.display == "none"){
      Graph();
    }else if(document.getElementById("chart-box1").style.display == "none"){
      Graph2();
    }
  });

</script>
</body>
</html>