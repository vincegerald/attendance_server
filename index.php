<?php 
    require("database.php");
    

    if(isset($_POST['submit'])){
        $name = $_POST['name'];
        $idnumber = $_POST['idnumber'];
        addStudent($idnumber,$name);
        header("location:index.php");
    }

    if(isset($_POST['edit'])){
        $id = trim($_POST['edit']);
        $name = $_POST['name'];
        $idnumber = $_POST['idnumber'];
        editStudent($id,$name,$idnumber);
        header("location:index.php");
    }

    if(isset($_POST['delete'])){
        $id = trim($_POST['delete']);
        deleteStudent($id);
        header("location:index.php");
    }

    if(isset($_POST['present'])){
        $id = trim($_POST['present']);
        studentPresent($id);
        header("location:index.php");
    }

    if(isset($_POST['absent'])){
        $id = trim($_POST['absent']);
        studentAbsent($id);
        header("location:index.php");
    }

    if(isset($_POST['search'])  && $_POST['text'] != ""){
        $a = $_POST['text'];
        $data = search($a);
    }
    else{
        $data = Students();
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <title>Student Attendance</title>
</head>
<body>
    <div class="container">
        <div class="container">
            <nav class="navbar fixed-top navbar-expand-lg bg-dark">
                <a class="btn btn-outline-info my-2 my-sm-0" href="#">Student Attendance</a>
            </nav>
        </div>
        <br><br><br><br>
        
        <div class="container">
            <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#addStudent">Add Student</button>
            <form class="form-inline" method="POST" style="margin-left:70%; margin-top:-40px;">  
                <div class="form-group mx-sm-3 mb-2">
                    <input type="text" class="form-control" name="text">&nbsp;&nbsp;
                    <button type="submit" class="btn btn-outline-info" name="search">Search</button>
                </div>
            </form>    
        </div>
        
        <div class="container" style="margin-top:20px;">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Student ID Number</th>
                        <th scope="col">Student Name</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data as $d): ?>
                        <tr>
                            <td><?php echo $d['id']; ?></td>
                            <td><?php echo $d['idnumber'] ?></td>
                            <td><?php echo $d['name'] ?></td>
                            <td><?php if($d['status'] == 'PRESENT'){ ?>
                            <?php echo '<p class="font-weight-bold text-success">PRESENT</p>'; } else { ?>
                            <?php echo '<p class="font-weight-bold text-danger">ABSENT</p>'; } ?>
                            </td>
                            <td><button type="button" class="btn btn-outline-warning" data-toggle="modal" data-target="#editStudent<?php echo $d['id'] ?>">Edit</button>
                            <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#deleteStudent<?php echo $d['id'] ?>">Delete</button>
                            <?php 
                                if($d['status'] == 'PRESENT'){ ?>
                                    <button type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#absentStudent<?php echo $d['id'] ?>">Absent</button>
                            <?php    }
                                else{ ?>
                                    <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#presentStudent<?php echo $d['id'] ?>">Present</button>
                             <?php   }
                            ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
    foreach($data as $d): ?>
    <!-- Edit Modal -->
    <div class="modal fade" id="editStudent<?php echo $d['id']?>" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo $d['name'] ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST">
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">ID Number</span>
                        </div>
                        <input type="number" value="<?php echo $d['idnumber'] ?>" name="idnumber" class="form-control">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Name</span>
                        </div>
                        <input type="text" name="name" value="<?php echo $d['name'] ?>" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info" value="<?php echo $d['id'] ?>" name="edit">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteStudent<?php echo $d['id']?>" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo $d['name'] ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST">
                <div class="modal-body">
                    <h4>Delete Student?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info" value="<?php echo $d['id'] ?>" name="delete">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div> 

    <!-- Present Modal -->
    <div class="modal fade" id="presentStudent<?php echo $d['id']?>" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo $d['name'] ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST">
                <div class="modal-body">
                    <h4>Is this student present?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info" value="<?php echo $d['id'] ?>" name="present">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>   

    <!-- Absent Modal -->
    <div class="modal fade" id="absentStudent<?php echo $d['id']?>" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo $d['name'] ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST">
                <div class="modal-body">
                    <h4>Is this student absent?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info" value="<?php echo $d['id'] ?>" name="absent">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>      
    <?php endforeach; ?>
</body>
<!-- Add Student Modal -->
    <div class="modal fade" id="addStudent" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST">
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">ID Number</span>
                        </div>
                        <input type="number" name="idnumber" class="form-control">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Name</span>
                        </div>
                        <input type="text" name="name" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info" name="submit">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</html>