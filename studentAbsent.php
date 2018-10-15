
<?php 

    require("database.php");
    if(isset($_POST['id'])){
        $id = $_POST['id'];
        studentAbsent($id);
        header("location:studentPresent.php");
    }


?>