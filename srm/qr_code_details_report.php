<?php
    include('header.php');
    check_auth();
    $condition = "";
    if($_SESSION['QR_USER_LOGIN'] == 0){
      $condition = "and added_by = '".$_SESSION['UID'] ."'";
   }

    if(isset($_GET['id']) && $_GET['id']>0){
        $id = $_GET['id'];
        $res = mysqli_query($con,"SELECT qr_traffic.*,qr_code.name FROM qr_traffic,qr_code WHERE qr_traffic.qr_code_id = qr_code.id AND qr_code.id = '$id' $condition ");

        if(mysqli_num_rows($res)>0){
            while($row = mysqli_fetch_assoc($res)){
                $arr[] = $row;
            }
        }else{
          redirect('qr_code.php');
        }       
    }
?>

<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">            
            <div class="col-12">
            <?php 
            
            ?>
            <div class="table-responsive table--no-card m-b-30 mt-5">
                  <table class="table table-borderless table-striped table-earning">
                     <thead>

                        <tr>
                           <th>ID</th>
                           <th>Device</th>
                           <th>OS</th>
                           <th>Browser</th>
                           <th>City</th>
                           <th>State</th>
                           <th>Country</th>
                           

                        </tr>
                     <tbody>
                      <?php 
                     $key = 1;
                      foreach ($arr as $row){
                      ?>
                        <tr>
                           <td><?php echo $key++ ?></td>
                           <td><?php echo $row['device'];?></td>
                           <td><?php echo $row['os']?></td>
                           <td><?php echo $row['browser']?></td>
                           <td><?php echo $row['city'];?></td>
                           <td><?php echo $row['state'];?></td>
                           <td><?php echo $row['conutry']?></td>
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