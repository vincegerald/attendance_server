<?php
    require("database.php");

    if(isset($_POST['idnumber']) && isset($_POST['name'])){
        $idnumber = $_POST['idnumber'];
        $name = $_POST['name'];
        addStudent($idnumber,$name);
        header("location:addStudent.php");
    }

?>

