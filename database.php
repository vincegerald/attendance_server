<?php  

    

    function database(){
        $database = "attendance";
        $host = "localhost";
        $username = "root";
        $password = "";

        return new PDO("mysql:host=$host; dbname=$database;", $username,$password);
    }

    function addStudent($idnumber,$name){
        $db = database();
        $sql = "INSERT INTO attendance (idnumber, name) VALUES(?,?)";
        $row = $db->prepare($sql);
        $row->execute(array($idnumber,$name));
        $db = null;
    }

    function retrieveStudents(){
        $db = database();
        $sql = "SELECT * from attendance";
        $rows = $db->prepare($sql);
        $rows->execute();
        $data = $rows->fetchAll(PDO::FETCH_ASSOC);
        $db = null;
        echo json_encode(array("students"=> $data));
    }

    function deleteStudent($id){
        $db = database();
        $sql = "DELETE FROM attendance where id = ?";
        $row = $db->prepare($sql);
        $row->execute(array($id));
        $db = null;
    }


?>