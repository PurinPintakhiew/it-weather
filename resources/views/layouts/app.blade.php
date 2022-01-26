<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>IT Weather</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="">
                    IT Weather
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

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
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
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
var msg = "off";
    if(!client){
        console.log("not connect");
    }
        
    client.onConnectionLost = onConnectionLost;
    client.onMessageArrived = onMessageArrived;

client.connect({onSuccess:onConnect});

function onConnect() {
    console.log("onConnect");
    document.getElementById("status").innerHTML = "Connect";
    client.subscribe("TEST/MQTT");
    client.subscribe("TEST/PM");
    client.subscribe("TEST/HUM");
    message = new Paho.MQTT.Message(msg);
    message.destinationName = "TEST/MQTT";
    client.send(message);
}

function onConnectionLost(responseObject) {
  if (responseObject.errorCode !== 0) {
    console.log("onConnectionLost:" + responseObject.errorMessage);
  } else {
    console.log("connect");
  }
}

function onMessageArrived(message) {
  if(message.destinationName == "TEST/PM"){
    console.log("PM 2.5:" + message.payloadString);
    document.getElementById("pm").innerHTML = message.payloadString;
  } else if(message.destinationName == "TEST/MQTT"){
    console.log("Temperature:" + message.payloadString);
    document.getElementById("temp").innerHTML = message.payloadString;
  } else if(message.destinationName == "TEST/HUM"){
    console.log("Humidity:" + message.payloadString);
    document.getElementById("hum").innerHTML = message.payloadString;
  }
}

function showAdd(){
    document.getElementById("dialog-background").style.display = "block";
}
function clossAdd(){
    document.getElementById("dialog-background").style.display = "none";
}
function setCheckbox(){
    var checkBox = document.getElementById("checkbox_on").checked;
    if(checkBox == true){
        document.getElementById("toru").innerHTML = "on";
        msg = "on";
        message = new Paho.MQTT.Message(msg);
        message.destinationName = "TEST/MQTT";
        client.send(message);
    }else{
        document.getElementById("toru").innerHTML = "off";
        msg = "off";
        message = new Paho.MQTT.Message(msg);
        message.destinationName = "TEST/MQTT";
        client.send(message);
    }
}

</script>

</body>
</html>
