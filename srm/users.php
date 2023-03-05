
<?php 
include('header.php');

if(isset($_GET['status']) && $_GET['status'] != '' && isset($_GET['id']) && $_GET['id'] >0){
   $id = get_safe_value($_GET['id']);
   $status = get_safe_value($_GET['status']);
   

   if($status == "active"){
       $status = 1;
   }else{
       $status = 0;  
   }
   mysqli_query($con,"UPDATE users SET status ='$status' where id= '$id'");
   redirect('users.php');
}

   $res=mysqli_query($con,"select * from users order by id desc");


?>

<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-12">
               <h2>Users</h2>
               <a href="manage_user.php">Add User</a>
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
                           <th>Email</th>
                           <th>Total QR/Total used</th>
                           <th>Total hit / total used</th>
                           <th>Action</th>
                        </tr>
                     <tbody>
                        <?php while($row=mysqli_fetch_assoc($res)){?>
                        <tr>
                           <td><?php echo $row['id'];?></td>
                           <td><?php echo $row['name']?></td>
                           <td><?php echo $row['email'];?></td>
                           <td><?php echo $row['total_qr'];?></td>
                           <td><?php echo $row['total_hit']?></td>
                           
                           <td>
                              <a href="manage_user.php?id=<?php echo $row['id'];?>">Edit</a>&nbsp;
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
                  <?php
                   } 
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