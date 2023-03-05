<?php
    include('header.php');
    check_auth();
    $condition = "";
    if($_SESSION['QR_USER_LOGIN'] == 0){
      $condition = "and added_by = '".$_SESSION['UID'] ."'";
   }

    if(isset($_GET['id']) && $_GET['id']>0){
        $id = $_GET['id'];
        $res = mysqli_query($con,"SELECT count(*) as total_record , qr_traffic.*,qr_code.name FROM qr_traffic,qr_code WHERE qr_traffic.qr_code_id = qr_code.id AND qr_code.id = '$id' $condition group by qr_traffic.added_on_str");

        if(mysqli_num_rows($res)>0){
            while($row = mysqli_fetch_assoc($res)){
                $arr[] = $row;
            }
        }else{
          redirect('qr_code.php');
        }

           $resDevice = mysqli_query($con,"SELECT count(*) as total_record , device FROM qr_traffic WHERE qr_code_id = '$id' group by qr_traffic.device");
           $totalDevice = "";
            while($rowDevice = mysqli_fetch_assoc($resDevice)){
              $totalDevice .= "['".$rowDevice['device']."',         ".$rowDevice['total_record']." ],";
            }
            $totalDevice = rtrim($totalDevice,",");



          $resos = mysqli_query($con,"SELECT count(*) as total_record , os FROM qr_traffic WHERE qr_code_id = '$id' group by qr_traffic.os");
          $totalos = "";
          while($rowos = mysqli_fetch_assoc($resos)){
          $totalos .= "['".$rowos['os']."',         ".$rowos['total_record']." ],";
          }
          $totalos = rtrim($totalos,",");
          

          $resBrowser = mysqli_query($con,"SELECT count(*) as total_record , browser FROM qr_traffic WHERE qr_code_id = '$id' group by qr_traffic.browser");
          $totalBrowser = "";
          while($rowBrowser = mysqli_fetch_assoc($resBrowser)){
          $totalBrowser .= "['".$rowBrowser['browser']."',         ".$rowBrowser['total_record']." ],";
          }
          $totalBrowser = rtrim($totalBrowser,",");
          $total = 0;
          foreach($arr as $list){
            $total += $list['total_record'];
          }
    

    }
?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawDeviseChart);

      function drawDeviseChart() {

        var data = google.visualization.arrayToDataTable([
          ['Drowser', 'Hours per Day'],
          <?php echo $totalDevice;?>
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
         ['OS', 'Hours per Day'],
         <?php echo $totalos;?>
      
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
         ['Browser', 'Hours per Day'],
         <?php echo $totalBrowser;?>
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
         
            <div class="col-6">
             <div>
                <div class="card">
                  <div class="card-body">
                    <h2>Total count: </h2>
                    <?php echo $total?>
                    <h4><a href="qr_code_details_report.php?id=<?php echo $id?>">Qr code report</a></h4>
                  </div>
                </div>
             </div>
            </div>

            <div class="col-6">
             <div id="drawDeviseChart"></div>
            </div>
            <div class="col-6">
              <div id="drawOsChart"></div>
            </div>
            <div class="col-6">
              <div id="drawBrawserChart"></div>
            </div>
            <div class="col-12">


            <?php 
            
            ?>
            <div class="table-responsive table--no-card m-b-30 mt-5">
                  <table class="table table-borderless table-striped table-earning">
                     <thead>

                        <tr>
                           <th>ID</th>
                           <th>Name</th>
                           <th>Date</th>
                           <th>Count</th>
                          
                        </tr>
                     <tbody>
                      <?php 
                     $key = 1;
                      foreach ($arr as $row){
                      ?>
                        <tr>
                           <td><?php echo $key ?></td>
                           <td><?php echo $row['name'];?></td>
                           <td><?php echo $row['added_on_str']?></td>
                           <td><?php echo $row['total_record'];?></td>
                           
                           
                        </tr>

                        <?php 
                        }

                        ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>



<?php
    include('footer.php');
?>