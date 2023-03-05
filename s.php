<?php
   include('srm/config.php');
   include('srm/functions.php');

   include('lib/BrowserDetection.php');
   include('lib/Mobile_Detect.php');

   $mobile ="";
   $browser_name ="";
   $os ="";

   if(isset($_GET['id']) && $_GET['id']>0){

	$id=get_safe_value($_GET['id']);
	$res=mysqli_query($con,"select link from qr_code where id='$id' and status='1'");
	if(mysqli_num_rows($res)>0){
       $row = mysqli_fetch_assoc($res);
       $link = $row['link'];
    //    echo $link;
    //    die();

        $mobile = new Mobile_Detect();
        $browser = new Wolfcast\BrowserDetection();
        $browser_name = $browser->getName();


        if($mobile->isTablet()){
            $mobile = "Tablet";
        }elseif($mobile->isMobile()){
            $mobile = "Mobile";
        }else{
            $mobile = "Computer";
        }

        $chp = curl_init();
        curl_setopt($chp, CURLOPT_URL, "http://ip-api.com/json");
        curl_setopt($chp, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($chp);
        curl_close($chp);
        $output = json_decode($output, true);
        

        $ip = $output['query'];
        $country = $output['country'];
        $city = $output['city'];
        $region = $output['regionName'];
        $add_on = date('Y-m-d h:i:s');
        $added_on_str = date('Y-m-d');

       $result = mysqli_query($con,"insert into qr_traffic(`qr_code_id`,`device`,`browser`,`city`,`state`,`conutry`,`added_on`,`ip_address`,`added_on_str`) values('$id','$mobile','$browser_name','$city','$region','$country','$add_on','$ip','$added_on_str')");
       ?>
        <script>
            window.location.href="<?php echo '//'. $link?>";
        </script>
        <?php



	}else{
        die("something going wrong");
    }
    
}
?>


