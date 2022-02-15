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
            <ul class="link-bar">
                <li class="nav-item">
                    <a class="nav-link active"  aria-current="page"  href="/register">เพิ่มผู้ดูแล</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="dropdown-list" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdown-list">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                        </form>
                    </ul>
                </li>
            </ul>
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
            <div class="status-machine col-lg-5">
                <div class="row mb-2">
                    <div class="status-mqtt col" style="text-align:center">
                        <span>Status Server</span>
                        <div id="light-status-mqtt"></div>
                    </div>
                    <div class="col" style="text-align:center">
                        <span>Status Machine</span>
                        <div id="light-status-machine"></div>
                    </div>
                </div>
                <div style="border:1px solid #ccc;padding: 5px 20px 10px 20px;">
                    <div style="text-align:center">
                        <span class="mb-2 span-control">Control Panel</span>
                    </div >
                    <span class="mb-2 span-topic">Machine</span>
                    <div class="d-flex align-items-center mb-2">
                        <span>OFF</span>
                        <label class="switch">
                            <input type="checkbox" id="checkbox_mac" onclick="controlMachine()">
                            <span class="slider round"></span>
                        </label>
                        <span>ON</span>
                    </div>
                    <span class="mb-2 span-topic">Motor Mode</span>
                    <div class="d-flex align-items-center mb-2">
                        <span>Auto</span>
                        <label class="switch">
                            <input type="checkbox" id="checkbox_mode" onclick="changeMode()">
                            <span class="slider round"></span>
                        </label>
                        <span>Manual</span>
                        <div class="sub-manual">
                            <span>UP</span>
                            <label class="switch">
                                <input type="checkbox" id="checkbox_updown" onclick="changeMode()" disabled>
                                <span class="slider round"></span>
                            </label>
                            <span>Down</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="machine col-lg-7">
                <label class="label-m">Machine Name</label>
                <select class="form-select mb-3" id="macid"  onchange="setAddress()">
                    @foreach($machines as $machine)
                    <option value="{{$machine->machine_id}}">{{$machine->machine_name}}</option>
                    @endforeach
                </select>
                <label class="label-m">Machine Address</label>
                <input type="text" class="form-control" id="address" disabled>
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
                                    <i class="icon-trash-empty" onclick="showDelete('{{$machine->machine_id}}')"></i>
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
        <li  class="nav-item">
            <a class="nav-link" href="/chartData">ข้อมูลย้อนหลัง</a>
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

        <div id="toru"></div>
</div> 

<!-- dialog add -->
<div id="dialog-background">
    <div id="dialog-form" class="col-5">
        <div class="card" style="font-weight: 600;">
            <div class="card-header">
                <h5 style="text-align:center;font-weight: 600;">Add Machine Location</h5>
            </div>
            <div class="card-body">
                <form  action="{{route('saveMac')}}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Machine name</label>
                        <input type="text" class="form-control" name="set_name">
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="" class="form-label">Latitude</label>
                            <input type="text" class="form-control" name="set_lat">
                        </div>
                        <div class="col mb-3">
                            <label for="" class="form-label">Longitude</label>
                            <input type="text" class="form-control" name="set_long">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Address</label>
                        <input type="text" class="form-control" name="set_address">
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="" class="form-label">Topic Status Machine</label>
                            <input type="text" class="form-control" name="topic_status">
                        </div>
                        <div class="col mb-3">
                            <label for="" class="form-label">Topic Moter Mode</label>
                            <input type="text" class="form-control" name="topic_mode">
                        </div>
                    </div>
                    <div class="row">
                    <div class="col mb-3">
                            <label for="" class="form-label">Topic PM</label>
                            <input type="text" class="form-control" name="topic_pm">
                        </div>
                        <div class="col mb-3">
                            <label for="" class="form-label">Topic Temperature</label>
                            <input type="text" class="form-control" name="topic_temp">
                        </div>
                        <div class="col mb-3">
                            <label for="" class="form-label">Topic Humidity</label>
                            <input type="text" class="form-control" name="topic_hum">
                        </div>
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

<!-- dialog delete -->
<div id="dialog-delete">
    <div id="dialog-form" class="col-md-2 col-sm-5">
        <div class="card"  style="font-weight: 600;">
            <div class="card-header" style="text-align:center">
               <p style="margin: 0;">You confirm to delete</p>
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


<script type="text/javascript" src="{{ asset('js/paho-mqtt.js') }}"></script>
<script type="text/javascript">

let topic_status;
let topic_pm;
let topic_temp;
let topic_hum;
let topic_mode;
let machineList = <?php echo $machines ?>;
let light_mac = document.getElementById("light-status-machine");
let light_server = document.getElementById("light-status-mqtt");
let div_pm = document.getElementById("pm");
let div_temp = document.getElementById("temp");
let div_hum = document.getElementById("hum");
let chartBox1 = document.getElementById("chart-box1");
let chartBox2 = document.getElementById("chart-box2");
let chart1 = document.getElementById("chart");
let chart2 = document.getElementById("chart2");

// set input address
function setAddress(){
    let macid = document.getElementById("macid").value;
    let address = document.getElementById("address");
    // light = 
    if(macid != ""){
        machineList.map((val,key) => {
            if(macid == val.machine_id){
                clean()
                console.log("id: "+ macid + "," + val.machine_id);
                address.value = val.address;
                topic_status = val.topic_status;
                topic_pm = val.topic_pm;
                topic_temp = val.topic_temp;
                topic_hum = val.topic_hum;
                topic_mode = val.topic_mode;
                Mqtt();
                if(chartBox2.style.display == "none"){
                    console.log("c1");
                    getChart(macid);
                } else if(chartBox1.style.display == "none"){
                    console.log("c2");
                    getChartWeek(macid);
                }
            }
        });
    } else {
        console.log("data machine is null");
    }
} setAddress();


function Mqtt(){
    const id = Math.random().toString(36).substring(2);
    client = new Paho.MQTT.Client("192.168.1.29", Number(9001),id);
    if(!client){
        console.log("not connect");
    }
        
    client.onConnectionLost = onConnectionLost;
    client.onMessageArrived = onMessageArrived;

    client.connect({onSuccess:onConnect});

    function onConnect() {
        console.log("onConnect");
        light_server.style.backgroundColor = "rgb(132 255 59)";
        client.subscribe(topic_status);
        client.subscribe(topic_pm);
        client.subscribe(topic_temp);
        client.subscribe(topic_hum);
    }

    function onConnectionLost(responseObject) {
        if (responseObject.errorCode !== 0) {
            console.log("onConnectionLost:" + responseObject.errorMessage);
            light_server.style.backgroundColor = "#ccc";
            // alert("There was an error with the server, please check")
        } else {
            console.log("connect");
        }
    }

    function onMessageArrived(message) {
        if(message.destinationName == topic_status){
            console.log("status machine :" + message.payloadString);
            status_machine = message.payloadString;
            if(status_machine == "1"){
                light_mac.style.backgroundColor = "rgb(132 255 59)";
            } else {
                light_mac.style.backgroundColor = "#ccc";
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

function clean(){
    light_mac.style.backgroundColor = "#ccc";
    light_server.style.backgroundColor = "#ccc";
    div_pm.innerHTML = "0.00";
    div_temp.innerHTML = "0.00";
    div_hum.innerHTML = "0.00";
    chart1.innerHTML = "";
    chart2.innerHTML = "";
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

// get id delete
let delID;
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
            // console.log(response);
            document.getElementById("dialog-delete").style.display = "none";
            location.reload();
          } else{
            console.log("Not have response");
          }
        }
    })
}

// control machine
function controlMachine(){
    let checkBox = document.getElementById("checkbox_mac").checked;
    if(checkBox == true){
        document.getElementById("toru").innerHTML = "on";
        msg = "on";
        message = new Paho.MQTT.Message(msg);
        message.destinationName = topic_status;
        client.send(message);
    }else{
        document.getElementById("toru").innerHTML = "off";
        msg = "off";
        message = new Paho.MQTT.Message(msg);
        message.destinationName = topic_status;
        client.send(message);
    }
}

// control moter
function changeMode(){
    let mode = document.getElementById("checkbox_mode").checked;
    let updown = document.getElementById("checkbox_updown");
    if(mode == true){
        updown.disabled = false;
        // console.log(topic_mode)
        if(updown.checked == true){
            // console.log("1");
        }else{
            // console.log("0");
        }
    }else{
        updown.disabled = true;
        updown.checked = false; 
    }
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
            if(chartDay.length > 1){
                Graph(chartDay);
                console.log("not data")
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
        url: "/getChartWeek",
        data: {id: macid},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: (response) => {
        if(response){
            chartWeek = JSON.parse(response);
            if(chartWeek.length > 1){
                Graph2(chartWeek);
                console.log(chartWeek);
            }else{
                noData();
                console.log("not data")
            }
        }
        } 
    });
}

// map
function init() {

    let locationList = <?php echo json_encode($map) ?>;

    // var map = new longdo.Map({
    //     placeholder: document.getElementById('map')
    // });
    // map.location({ lon:103.1011 , lat:14.9904},true);
    // map.Ui.Crosshair.visible(false);
    // map.zoom(14, true);
    // for (var i = 0; i < locationList.length; ++i) {
    //     let pm25 = parseFloat(locationList[i].macpm).toFixed(0);
    //     var color;
    //     if(pm25 >= 91){
    //     color = "rgb(240, 70, 70)";
    //     } else if (pm25 >= 51 ){
    //     color = "rgb(255, 162, 0)";
    //     } else if(pm25 >= 38){
    //     color = "rgb(255, 255, 0)";
    //     } else if(pm25 >= 26){
    //     color = "rgb(146, 208, 80)";
    //     } else if(pm25 >= 0){
    //     color = "rgb(59, 204, 255)";
    //     } else{
    //     color = "black";
    //     }
    //     map.Overlays.add(new longdo.Marker({lon: locationList[i].longitude, lat: locationList[i].latitude },
    //         {
    //         title: locationList[i].machine_name,
    //         icon: {
    //             html:  `<div class="icon-map-box">
    //                     <div id="iconmap" style="background-color:${color};"></div>
    //                     <strong class="mappm">${pm25}</strong>
    //                 </div>`,
    //             offset: { x: 18, y: 21 }
    //             },
    //             detail: `${locationList[i].longitude},${locationList[i].latitude}`,
    //             draggable: true,
    //             weight: longdo.OverlayWeight.Top
    //     }));
    // }
}

// show graph
function showChart(){
    let macid = document.getElementById("macid").value;
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
    let macid = document.getElementById("macid").value;
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

// chart
function Graph(chartDay) {
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    
    function drawChart(){
      var data = google.visualization.arrayToDataTable(chartDay);
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
        pointSize: 5
      };
      var chart = new google.visualization.LineChart(document.getElementById('chart2'));
      chart.draw(data, options);
    }
  }

$(window).resize(function(){
    let macid = document.getElementById("macid").value;
    if(chartBox2.style.display == "none"){
        getChart(macid);
    } else if(chartBox1.style.display == "none"){
        getChartWeek(macid);
    }
});

</script>
</body>
</html>