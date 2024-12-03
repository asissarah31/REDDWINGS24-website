<?php
$id = $_GET['id'];
include "./db_connect.php";
mysqli_query($conn,"delete from gallery where id='$id'");
header("location:vgallery.php");


?>