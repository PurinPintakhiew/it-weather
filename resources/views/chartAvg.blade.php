<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    drawGraph()
});

function drawGraph() {

google.charts.load("current", {packages:['corechart']});
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
  var data = google.visualization.arrayToDataTable([
["test", "val", { role: "style" } ],
["test", 21.45, "color: red"]
  ]);
  var options = {
        width: '100%'
        };
  var view = new google.visualization.DataView(data);
  var chart = new google.visualization.ColumnChart(document.getElementById("columnchart"));
  chart.draw(view,options);
  }
}

function drawGraph2() {
  google.charts.load("current", {packages:['corechart']});
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
  var data = google.visualization.arrayToDataTable([
["test", "val", { role: "style" } ],
["test", 21.45, "color: blue"]
  ]);
  var options = {
        width: '100%'
        };
  var view = new google.visualization.DataView(data);
  var chart = new google.visualization.ColumnChart(document.getElementById("columnchart2"));
  chart.draw(view,options);
  }
}

  function test() {
  drawGraph();
  document.getElementById("columnchart").style.display = "block";
  document.getElementById("columnchart2").style.display = "none";
  }
  function test2() {
  drawGraph2();
  document.getElementById("columnchart2").style.display = "block";
  }
</script>
<div onclick="javascript:test()"> click me </div>
<div onclick="javascript:test2()"> click me </div>
<div id="columnchart" style="width: 100%; height: 300px; display:block;"></div>
<div id="columnchart2" style="width: 100%; height: 300px; display:none;"></div>