<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>IT Weather</title>
    <link rel="icon" href="{{url('/images/LOGO-IT.png')}}" type="image/gif" sizes="16x16">

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
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ url('/css/login.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('/css/admin.css') }}" />

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md" style="background-color:#6165f8;">
            <div class="container-fluid">
                <a id="it-brand" class="navbar-brand" href="/">
                    <img id="icon-weather" src="{{url('/images/it-weather2.png')}}" >
                </a>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item text-bar">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item text-bar">
                                <a class="nav-link" style="color:white;font-size:18px;font-weight:600;" href="dashboard">หน้าควบคุม</a>
                            </li>
                            <li class="nav-item dropdown text-bar">
                                <a id="navbarDropdown" style="color:white;font-size:18px;font-weight:600;" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

<!-- Mqtt -->
<script type="text/javascript" src="{{ asset('js/paho-mqtt.js') }}"></script>
<script type="text/javascript">

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
    document.getElementById("status").innerHTML = "Connect";
    document.getElementById("checkbox_on").checked = true;
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

function showAdd(){
    document.getElementById("dialog-background").style.display = "block";
}

function closs(){
    document.getElementById("dialog-background").style.display = "none";
    document.getElementById("dialog-delete").style.display = "none";
}

function showDelete(){
    document.getElementById("dialog-delete").style.display = "block";
}

var delID;
function showDelete(id){
    delID = id;
    document.getElementById("dialog-delete").style.display = "block";
}

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


</script>

</body>
</html>
