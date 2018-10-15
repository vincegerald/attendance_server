<?php 

    require("database.php");
    if(isset($_POST['id'])){
        $id = $_POST['id'];
        studentPresent($id);
        header("location:studentPresent.php");
    }


?>