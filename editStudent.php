<?php 

    require("database.php");
    if(isset($_POST['id']) && isset($_POST['name']) && isset($_POST['idnumber'])){
        $id = $_POST['id'];
        $name = $_POST['name'];
        $idnumber = $_POST['idnumber'];
        editStudent($id,$name,$idnumber);
        header("location:editStudent.php");
    }


?>