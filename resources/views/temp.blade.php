<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="{{ url('/css/styles.css') }}" />
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script type="text/javascript" src="{{ asset('js/paho-mqtt.js') }}"></script>
  <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <script>
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

var data = {
  temp:0,
  hum:0,
  pm:0
};

$(document).ready(function(){
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  
  // setInterval(() => {
  //   $.ajax({
  //       url: "/temp-add",
  //       type:"POST",
  //       data: data,
  //       success:function(data){
  //           alert(data);
  //       },error:function(){ 
  //           alert("error!!!!");
  //       }
  //   });
  // }, 60000);

  // setInterval(() => {
  //   $.ajax({
  //       type: "GET",
  //       url: "/temp-save",
  //       success: function (response) {
  //           console.log(response);
  //       }
  //   });     
  // }, 60000);
});    

function onMessageArrived(message) {
  if(message.destinationName == "TEST/MQTT"){
    console.log("Temp:" + message.payloadString);
    document.getElementById("tamp").innerHTML = message.payloadString;
    data['temp'] = message.payloadString;

  } else if(message.destinationName == "TEST/PM"){
    console.log("PM:" + message.payloadString);
    document.getElementById("pm").innerHTML = message.payloadString;
    data['pm'] = message.payloadString;

  } else if(message.destinationName == "TEST/HUM"){
    console.log("Humidity:" + message.payloadString);
    document.getElementById("hum").innerHTML = message.payloadString;
    data['hum'] = message.payloadString;

  }
}

  </script>
</head>
<body class="">

  <div class="bar-1 container-fluid">
    <div class="row">
      <div class="d-flex flex-row col-6">
        <!-- <img class="bru-img" src="{{url('/images/bru.png')}}">
        <p>มหาวิทยาลัยราชภัฎบุรีรัมย์</p> -->
        <img class="it-img" src="{{url('/images/LogoHead-1.png')}}">
        <!-- <p>สาขาวิชาเทคโนโลยีสารสนเทศ</p> -->
      </div>
      <div class="d-flex flex-row col-6">
          <div id="display-connect"></div>
      </div>
    </div>
  </div>

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

  <!-- <div>
    <form method = "get" action="{{route('save')}}" enctype="multipart/form-data">
    @csrf
      <input type="text" name="t">
      <button type="submit">send</button>
    </form>
  </div> -->


</body>
</html>