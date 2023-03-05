<?php
   include('header.php');
   check_auth();

   if(isset($_GET['type']) && $_GET['type']=='delete' && isset($_GET['id']) && $_GET['id']>0){
   	$id=get_safe_value($_GET['id']);
   	mysqli_query($con,"delete from qr_code where id=$id");
   	
   	// mysqli_query($con,"delete from expense where added_by=$id");
   	// echo "<br/>Data deleted<br/>";
   }
   
   $res=mysqli_query($con,"select * from qr_code order by id desc");
   ?>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawDeviseChart);

      function drawDeviseChart() {

        var data = google.visualization.arrayToDataTable([
          ['Mobile', 'Hours per Day'],
          ['Tablate',     11],
          ['Computer',      2]
        ]);

        var options = {
          title: 'Devise'
        };

        var chart = new google.visualization.PieChart(document.getElementById('drawDeviseChart'));

        chart.draw(data, options);
      }

      google.charts.setOnLoadCallback(drawOsChart);
      function drawOsChart() {

      var data = google.visualization.arrayToDataTable([
         ['Mobile', 'Hours per Day'],
          ['Tablate',     11],
          ['Computer',      2]
      
      ]);

            var options = {
            title: 'Os'
            };

         var chart = new google.visualization.PieChart(document.getElementById('drawOsChart'));

         chart.draw(data, options);
         }


google.charts.setOnLoadCallback(drawBrawserChart);
function drawBrawserChart() {

      var data = google.visualization.arrayToDataTable([
         ['Mobile', 'Hours per Day'],
          ['Tablate',     11],
          ['Computer',      2]
      ]);

      var options = {
      title: 'PC'
      };

      var chart = new google.visualization.PieChart(document.getElementById('drawBrawserChart'));

      chart.draw(data, options);
      }

    </script>


<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-12">
             <div id="drawDeviseChart">Welcome to the dashboard</div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php
   include('footer.php');
   ?>