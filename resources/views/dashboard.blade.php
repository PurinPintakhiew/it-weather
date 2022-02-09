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
</head>
<body>

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

<script type="text/javascript" src="{{ asset('js/paho-mqtt.js') }}"></script>
<script type="text/javascript">

const id = Math.random().toString(36).substring(2);
client = new Paho.MQTT.Client("10.133.0.103", Number(9001),id);
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

// closs dialog add
function closs(){
    document.getElementById("dialog-background").style.display = "none";
    document.getElementById("dialog-delete").style.display = "none";
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
var locationList = <?php echo $machines ?>;

setAddress();
function setAddress(){
    let macid = document.getElementById("macid").value;
    let address = document.getElementById("address");
    locationList.map((val,key) => {
        if(macid == (key+1)){
            console.log("id: "+ macid + "," + key + 1);
            address.value = val.address;
        }
    })
}

</script>
</body>
</html>