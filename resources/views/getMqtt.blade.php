<script type="text/javascript" src="{{ asset('js/paho-mqtt.js') }}"></script>
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
  
<script>
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
  client.subscribe("TEST/MQTT");
  client.subscribe("TEST/PM");
  client.subscribe("TEST/HUM");
}

function onConnectionLost(responseObject) {
  if (responseObject.errorCode !== 0) {
    console.log("onConnectionLost:" + responseObject.errorMessage);
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
  
  setInterval(() => {
    $.ajax({
        url: "/weather-add",
        type:"POST",
        data: data,
        success:function(data){
            console.log(data);
        },error:function(){ 
            alert("error!!!!");
        }
    });
  }, 60000);

  setInterval(() => {
    $.ajax({
        type: "GET",
        url: "/weather-save",
        success: function (response) {
            console.log(response);
        }
    });     
  }, 3600 * 1000);

});    

function onMessageArrived(message) {
  if(message.destinationName == "TEST/MQTT"){
    console.log("Temp:" + message.payloadString);
    data['temp'] = message.payloadString;

  } else if(message.destinationName == "TEST/PM"){
    console.log("PM:" + message.payloadString);
    data['pm'] = message.payloadString;

  } else if(message.destinationName == "TEST/HUM"){
    console.log("Humidity:" + message.payloadString);
    data['hum'] = message.payloadString;

  }
}
  </script>