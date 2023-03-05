<?php
   include('header.php');

   $msg="";
   $name = '';
   $email = '';
   $password = '';
   $total_qr = '';
   $total_hit = '';
   $id = 0;
   $password_required = "required";
   $label="Add";

   if(isset($_GET['id']) && $_GET['id']>0){
   	$label="Edit";
   	$id=get_safe_value($_GET['id']);
   	$res=mysqli_query($con,"select * from users where id=$id");
   	if(mysqli_num_rows($res)==0){
   		redirect('users.php');
   		die();
   	}

      if(mysqli_num_rows($res)>0){
         $row = mysqli_fetch_assoc($res);
         $name = $row['name'];
         $email = $row['email'];
         $password = $row['password'];
         $total_qr = $row['total_qr'];
         $total_hit = $row['total_hit'];
         $password_required = "";
      }else{
         redirect('users.php');
      }
   }


   
   if(isset($_POST['submit'])){
       $username=get_safe_value($_POST['username']);
       $email=get_safe_value($_POST['email']);
       $password=get_safe_value($_POST['password']);
       $total_qr=get_safe_value($_POST['total_qr']);
       $total_hit=get_safe_value($_POST['total_hit']);
       $status = 1;
       $role = 1;
       $added_on = date('Y-m-d h:i:s');
       $eamil_sql ="";

       if($id>0){
         $eamil_sql = " and id != '$id'";
       }
       if(mysqli_num_rows(mysqli_query($con,"SELECT * FROM users WHERE email='$email' $eamil_sql")) > 0){
              $msg = "Email already exists";
       }else{
         if($id>0){
            $password_sql = '';
            if($password != ''){
               $password_sql = ",password ='$password'";
            }
            $result = mysqli_query($con,"UPDATE users SET name = '$username',email = '$email',total_qr='$total_qr',total_hit='$total_hit' $password_sql WHERE id = '$id'");
            if($result){
               redirect('users.php');
            }else{
               $msg = "Data not inserted";
            }
         }else{
            $password=password_hash($password,PASSWORD_DEFAULT);
            $result = mysqli_query($con,"INSERT INTO users (`name`,`email`,`password`,`total_qr`,`total_hit`,`status`,`role`,`added_on`)  values('$username','$email','$password','$total_qr','$total_hit','$status','$role','$added_on')");
 
            if($result){
               redirect('users.php');
            }else{
               $msg = "Data not inserted";
            }
         }
       }
    }

   

   
   ?>
<script>

</script>
<div class="main-content">
<div class="section__content section__content--p30">
<div class="container-fluid">
<div class="row">
<div class="col-lg-12">
<h2><?php echo $label?> User</h2>
<a href="users.php">Back</a>
<div class="card">
<div class="card-body card-block">
<form method="post" class="form-horizontal ">
   <div class="form-group">											
	<label class="control-label mb-1">Name</label>
      <input type="text" name="username" required value="<?php echo $name?>" class="form-control" rquired>
   </div>
   <div class="form-group">	
	<label class="control-label mb-1">Email</label>
      <input type="text" name="email" required value="<?php echo $email?>" class="form-control" rquired>
   </div>
   <div class="form-group">												
	<label class="control-label mb-1">Password</label>
      <input type="text" name="password" <?php echo $password_required?> value="<?php ?>" class="form-control" rquired>
   </div>
   <div class="form-group">												
	<label class="control-label mb-1">Total QR code</label>
      <input type="text" name="total_qr" required value="<?php echo $total_qr?>" class="form-control" rquired>
   </div>
   <div class="form-group">												
	<label class="control-label mb-1">Totall QR hits</label>
      <input type="text" name="total_hit" required value="<?php echo $total_hit?>" class="form-control" rquired>
   </div>
   <div class="form-group">												
      <input type="submit" name="submit" value="Submit"  class="btn btn-lg btn-info btn-block">                          
   </div>
   <div id="msg"><?php echo $msg?></div>
</form>
<?php
   include('footer.php');
?>