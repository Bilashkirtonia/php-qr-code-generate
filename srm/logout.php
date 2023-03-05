<?php
include('config.php');
include('functions.php');

unset($_SESSION['UID']);
unset($_SESSION['UNAME']);
unset($_SESSION['UROLE']);
unset($_SESSION['QR_USER_LOGIN']);

redirect('index.php');
?>