<html>
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- chart css -->
    <link rel="stylesheet" type="text/css" href="{{ url('/css/chart.css') }}" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Google Chart -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>

    <script type="text/javascript">

      $(document).ready(()=>{
        Graph();
      });

      // day
      function Graph(){

      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {
        var data = new google.visualization.arrayToDataTable(<?php echo $data ?>);

        var options = {
          width: 800,
          legend: { position: 'none' },
          chart: {
            title: '',
            subtitle: '' },
          axes: {
            x: {
              0: { side: 'top', label: 'ค่าเฉลี่ย PM 2.5 รายวัน'} // Top x-axis.
            }
          },
          bar: { groupWidth: "90%" }
        };

        var chart = new google.charts.Bar(document.getElementById('chart'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
      }};

      // week
      function Graph2(){

      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawStuff);
      
      function drawStuff(){
        var data = new google.visualization.arrayToDataTable(<?php echo $dataWeek ?>);

        var options = {
            width: 800,
            legend: { position: 'none' },
            chart: {
              title: '',
              subtitle: '' },
            axes: {
              x: {
                0: { side: 'top', label: 'ค่าเฉลี่ย PM 2.5 รายสัปดาห์'} // Top x-axis.
              }
            },
            bar: { groupWidth: "90%" }
          };

            var chart = new google.charts.Bar(document.getElementById('chart2'));
            chart.draw(data, google.charts.Bar.convertOptions(options));
      }};
    </script>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <a class="navbar-brand mb-0 h1" href="/weather">IT Weather</a>
          <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                  <a  class="nav-link active" onclick="show()">รายวัน</a>
                </li>
                <li class="nav-item">
                  <a  class="nav-link" onclick="show2()">รายสัปดาห์</a>
                </li>
            </ul>
        </div>
      </div>
    </nav>

    <div class="col-md-12 pmDay" id="pm1">
      <h1>ค่าสถิติ PM 2.5 รายวัน</h1>
        <div id="chart" style="width: 800px; height: 600px;"></div>
        <p><?php echo $datenow; ?>
        </p>
    </div>
    <div class="col-md-12 pmWeek" id="pm2">
      <h1>ค่าสถิติ PM 2.5 สัปดาห์</h1>
        <div id="chart2" style="width: 800px; height: 600px;"></div>
        <p><?php 
            echo $minTimeDay."-".$datenow; 
          ?>
        </p>
    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  
    <script>
      function show(){
          Graph();
          document.getElementById("pm1").style.display = "block";
          document.getElementById("pm2").style.display = "none";
      }
      function show2(){
          Graph2();
          document.getElementById("pm2").style.display = "block";
          document.getElementById("pm1").style.display = "none";
      }
    </script>
  
  </body>
</html>
