<?php
   include('header.php');

   $msg="";
   $name = '';
   $link = '';
   $color = '';
   $size = '';
   $label="Add";
   $id= 0;
   $condition = "";
   $isAdmin = "yes";

   if($_SESSION['QR_USER_LOGIN'] == 1){
      $condition = "and added_by = '".$_SESSION['UID'] ."'";
      $get_user_info = get_user_info($_SESSION['UID']);
      $get_user_total_qr = get_user_total_qr($_SESSION['UID']);
      $isAdmin = "no";
   }

   if(isset($_GET['id']) && $_GET['id']>0){
	$label="Edit";
	$id=get_safe_value($_GET['id']);
	$res=mysqli_query($con,"select * from qr_code where id='$id '$condition");
	if(mysqli_num_rows($res)==0){
		redirect('qr_code.php');
		die();
	}

   if(mysqli_num_rows($res)>0){
	  $row = mysqli_fetch_assoc($res);
	  $name = $row['name'];
	  $link = $row['link'];
	  $color = $row['color'];
	  $size = $row['size'];

   }else{
	  redirect('qr_code.php');
   }
}
  
   if(isset($_POST['submit'])){
      $name=get_safe_value($_POST['name']);
	   $link=get_safe_value($_POST['link']);
	   $color=get_safe_value($_POST['color']);
	   $size=get_safe_value($_POST['size']);
	   $status = 1;
	   $added_on = date('Y-m-d h:i:s');

	   if($id>0){
		$result = mysqli_query($con,"UPDATE qr_code SET name = '$name',link = '$link',color='$color',size='$size' WHERE id = '$id' $condition");
            if($result){
               redirect('qr_code.php');
            }else{
               $msg = "Data not inserted";
            }
	   }else{
		$result = mysqli_query($con,"INSERT INTO qr_code (`name`,`link`,`color`,`size`,`status`,`added_on`)  values('$name','$link','$color','$size','$status','$added_on')");
 
       if($result){
          redirect('qr_code.php');
       }else{
         $msg = "Data not inserted";
        }
	   }

       
   }
   ?>

<div class="main-content">
<div class="section__content section__content--p30">
<div class="container-fluid">
<div class="row">
<div class="col-lg-12">
<h2><?php echo $label?> User</h2>
<a href="qr_code.php">Back</a>
<div class="card">
<div class="card-body card-block">
<form method="post" class="form-horizontal ">
   <div class="form-group">											
	<label class="control-label mb-1">Name</label>
      <input type="text" name="name" required value="<?php echo $name?>" class="form-control" rquired>
   </div>
   <div class="form-group">	
	<label class="control-label mb-1">Link</label>
      <input type="text" name="link" required value="<?php echo $link?>" class="form-control" rquired>
   </div>
   <div class="form-group"> 											
      <label class="control-label mb-1">Color</label>
      <select name="color" id="" class="form-control">
      <option value="" disabled>Select color</option>
         <?php 
            $res = mysqli_query($con,"select * from color");
            while($row = mysqli_fetch_assoc($res)){
         ?>
         <option value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
         <?php  
         }
         ?>	
      </select>
   </div>

   <div class="form-group"> 											
      <label class="control-label mb-1">Size</label>
      <select name="size" id="" class="form-control">
      <option value="" disabled>Select color</option>
         <?php 
            $res = mysqli_query($con,"select * from size");
            while($row = mysqli_fetch_assoc($res)){
         ?>
         <option value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
         <?php  
         }
         ?>	
      </select>
   </div>

   <div class="form-group">
      <?php 
      if($id == 0 && $isAdmin == 'no'){
         if($get_user_info['total_qr'] > $get_user_total_qr['total_qr']){
            ?>
            <input type="submit" name="submit" value="Submit"  class="btn btn-lg btn-info btn-block">
            <?php
         }else{
            $msg = " You touch your limit";
         }
      }	
      ?>											
                                
   </div>
   <div id="msg"><?php echo $msg?></div>
</form>
<?php
   include('footer.php');
?>

