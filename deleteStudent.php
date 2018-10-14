<?php 
    require("database.php");
    if(isset($_POST['id'])){
        $id = $_POST['id'];
        deleteStudent($id);
        header("location:deleteStudent.php");
    }

?>