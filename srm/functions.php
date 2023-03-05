<?php
function pr($data){
	echo '<pre>';
	print_r($data);
	die();
}

function prx($data){
	echo '<pre>';
	print_r($data);
	die();
}

function get_safe_value($data){
	global $con;
	if($data !=""){
		return mysqli_real_escape_string($con,$data);
	}
}

function redirect($link){
	?>
	<script>
		window.location.href="<?php echo $link?>";
		
	</script>
	<?php
}

function check_auth(){

	if(!isset($_SESSION['QR_USER_LOGIN'])){
		redirect('index.php');		
	}
}

function check_admin_auth(){

	if($_SESSION['UROLE'] != 0 ){
		redirect('index.php');		
	}
}

function get_user_info($uid){
	global $con;
	$row = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM users WHERE id = '$uid'"));
	return $row;
}

function get_user_total_qr($uid){
	global $con;
	$row = mysqli_fetch_assoc(mysqli_query($con,"SELECT count(*) as total_qr FROM qr_code WHERE added_by = '$uid'"));
	return $row;
}


// function get_safe_value($data){
// 	global $con;
// 	if($data !=""){
// 		return mysqli_real_escape_string($con,$data);
// 	}
// }


?>