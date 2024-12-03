<?php
include 'db_connect.php';
if(isset($_POST['id'])){
    $id = $_POST['id'];
    $delete = $conn->query("DELETE FROM users WHERE id = $id");
    if($delete){
        echo 1;
    } else {
        echo 0;
    }
}
?>
