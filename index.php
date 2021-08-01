<?php 
// Connecting the database
$servername= "localhost";
$username="root";
$password="";
$database="notes";

$insert=false;
$updation=false ;
$delete=false;
// Create connection
$conn=mysqli_connect($servername ,$username ,$password ,$database);

// Die if connection was not successful

if(!$conn){
    die("Sorry we failed to connect : " . mysqli_connect_error());
}

if(isset($_GET['delete'])){
    $sno=$_GET['delete'];
    $sql = "DELETE FROM `notes` WHERE `sno` = $sno" ;
    $result =mysqli_query($conn,$sql);

    if ($result) {
        $delete=true;
    }
}

if($_SERVER['REQUEST_METHOD']=='POST'){

    if (isset($_POST['snoEdit'])) {
        //Updating the note
        $title=$_POST['titleEdit'];
        $desc=$_POST['descriptionEdit'];
        $sno=$_POST['snoEdit'];

        $sql = "UPDATE `notes` SET `title` = '$title', `description`='$desc' WHERE `sno` = '$sno'";
        $result =mysqli_query($conn,$sql);

      $affectedRows=mysqli_affected_rows($conn);

     if($result){
      $updation=true ;
    }
    
}
    else{
    $title=$_POST['title'];
     $desc=$_POST['desc'];

$sql = "INSERT INTO `notes` (`title`, `description`, `time`) VALUES ( '$title', '$desc', current_timestamp())";
$result =mysqli_query($conn,$sql);


if($result){
    $insert = true ;
    }

  }
}
?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

   
        
       

    <title>Magic Notes</title>
</head>

<body>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit this Note</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="/crud/index.php" method="POST">
          <div class="modal-body">
            <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="form-group">
              <label for="title">Note Title</label>
              <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
            </div>

            <div class="form-group">
              <label for="desc">Note Description</label>
              <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
            </div> 
          </div>
            <div class="modal-footer d-block mr-auto">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>



    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Magic Notes</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact Us</a>
                    </li>


                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>


    <?php

if($insert){
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong> Success!</strong> Your notes have been inserted successfully.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
}
// else{
//     echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
//     <strong> Error!</strong>Your notes cannot be submitted due to technical issues. We regret for inconvience caused.
//     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
//   </div>';
// }

 if($updation){
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong> Success!</strong> Your notes have been updated successfully.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
}
 if($delete){
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong> Success!</strong> Your notes have been deleted successfully.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
}

?>


    <div class="container my-3">

        <h2>Add a note</h2>
        <form  action="/crud/index.php"  method="POST">
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Title</label>
              <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
              <div id="emailHelp" class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">Description</label>
              <textarea name="desc" id="desc" cols="158" rows="5"></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Add note</button>
          </form>
    </div>


    <div class="container my-5">

<table class="table" id="myTable">
  <thead>
    <tr>
      <th scope="col">S NO</th>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>

  <?php
       $sql = "SELECT * FROM `notes`";
       $result =mysqli_query($conn,$sql);
       
       $num=mysqli_num_rows($result);
       $serialNo = 1 ;
       
       if($num>0){

           while($row=mysqli_fetch_assoc($result)){
              
               echo '<tr>
                 <th scope="row">'.$serialNo .'</th>
                 <td>'.$row['title']  .'</td>
                 <td>'. $row['description'].  '</td>
                 <td><button class=" edit btn btn-sn btn-primary" id='.$row['sno'].' >Edit</button> <button class=" delete btn btn-sn btn-primary" id=d'.$row['sno'].' >Delete</button></td>
               </tr>';
               $serialNo = $serialNo +1 ;
           }
        }
        
    ?>

  </tbody>
</table>

    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
    crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
        
      <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
      
        <script>
      $(document).ready( function () {
    $('#myTable').DataTable();
} );
  </script>


<script>
    edits = document.getElementsByClassName('edit');

    Array.from(edits).forEach(element => {
    element.addEventListener('click' , (e)=>{
    //  console.log(e.target.parentNode.parentNode);

     tr=e.target.parentNode.parentNode;
     title=tr.getElementsByTagName('td')[0].innerText ;
     description=tr.getElementsByTagName('td')[1].innerText ;
     console.log(title,description);

     titleEdit.value=title;
     descriptionEdit.value = description;
     snoEdit.value=e.target.id ;
     console.log(e.target.id);
     $('#editModal').modal('toggle');

    })
});


deletes = document.getElementsByClassName('delete');

Array.from(deletes).forEach(element => {
element.addEventListener('click' , (e)=>{
//  console.log(e.target.parentNode.parentNode);
 
  dsno=e.target.id;
  sno=dsno.substr(1,);
  console.log(sno);
 
 if (confirm("Are you sure you want to delete this note!")) {
          console.log("yes");
          window.location = `/crud/index.php?delete=${sno}`;
          // TODO: Create a form and use post request to submit a form
        }
        else {
          console.log("no");
        }

    })
});
</script>
</body>

</html>