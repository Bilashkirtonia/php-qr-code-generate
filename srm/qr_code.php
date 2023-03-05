<?php
   include('header.php');
   $condition = "";

   if($_SESSION['QR_USER_LOGIN'] == 0){
      $condition = "and added_by = '".$_SESSION['UID'] ."'";
   }

   if(isset($_GET['status']) && $_GET['status'] != '' && isset($_GET['id']) && $_GET['id'] >0){
      $id = get_safe_value($_GET['id']);
      $status = get_safe_value($_GET['status']);
      
   
      if($status == "active"){
          $status = 1;
      }else{
          $status = 0;  
      }
      mysqli_query($con,"UPDATE qr_code SET status ='$status' where id= '$id' $condition ");
      redirect('qr_code.php');
   }
  
   $res=mysqli_query($con,"select * from qr_code where 1 $condition order by id desc");
   
   
   ?>
<script>
   setTitle("Users");
   selectLink('users_link');
</script>
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-12">
               <h2>Users</h2>
               <a href="manage_qr_code.php">Add qr code</a>
               <br/><br/>
               <div class="table-responsive table--no-card m-b-30">
                  <table class="table table-borderless table-striped table-earning">
                     <thead>
                        <?php
                           if(mysqli_num_rows($res)>0){
                           ?>
                        <tr>
                           <th>ID</th>
                           <th>Name</th>
                           <th>Link</th>
                           <th>Color</th>
                           <th>Size</th>
                           <th>Added on</th>
                           <th>Action</th>
                        </tr>
                     <tbody>
                        <?php while($row=mysqli_fetch_assoc($res)){?>
                        <tr>
                           <td><?php echo $row['id'];?></td>
                           <td>
                           <?php echo $row['name'];?>
                           <br>
                              <a target="_blank" href="https://chart.apis.google.com/chart?cht=qr&chs=<?php echo $row['size'];?>&chco=<?php echo $row['color'];?>&chl=<?php echo $file_path?>?id=<?php echo $row['id'];?>">
                              <img style="width:100px;" src="https://chart.apis.google.com/chart?cht=qr&chs=<?php echo $row['size'];?>&chl=<?php echo $row['link'];?>&chco=<?php echo $row['color'];?>" alt="">
                              </a>
                              <a href="qr_report.php?id=<?php echo $row['id'];?>">QR report</a>
                           </td>
                           <td><?php echo $row['link'];?></td>
                           <td><?php echo $row['color']?></td>
                           <td><?php echo $row['size'];?></td>
                           <td><?php echo $row['added_on']?></td>
                           <td>
                              <a href="manage_qr_code.php?id=<?php echo $row['id'];?>">Edit</a>&nbsp;
                             <?php 
                              $status = "active";
                              $strStatus = "Deactive";
                              if($row['status'] == 1){
                              	$status = "deactive";
                              	$strStatus = "Active";
                              }
                             ?>
                              <a href="?id=<?php echo $row['id'];?>&status=<?php echo $status;?>"><?php echo $strStatus?></a>
                           </td>
                        </tr>
                        <?php } ?>
                     </tbody>
                  </table>
                  <?php } 
                     else{
                     	echo "No data found";
                     }
                     ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php
   include('footer.php');
   ?>