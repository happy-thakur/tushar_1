<?php
ob_start();
session_start();
require_once 'dbconnect.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
// select logged in users detail
$res = $conn->query("SELECT * FROM users WHERE id=" . $_SESSION['user']);
$userRow = mysqli_fetch_array($res, MYSQLI_ASSOC);

?>



<?PHP

if (isset($_POST['enter'])) {



  if(strlen($_FILES['uploaded_file']['name']) != 0)
  {

    include_once 'dbconnect.php';
    
    $path = "uploads/";
    $path = $path . basename( $_FILES['uploaded_file']['name']);
    if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path)) {
      echo "The file ".  basename( $_FILES['uploaded_file']['name']). 
      " has been uploaded";


      

        $sql = "INSERT INTO data (uid,fileUrl,text,dataType) VALUES ('".$userRow['email']."', '".$path."', '".$_POST['message']."', '".$_POST['dataType']."')";


      if ($conn->query($sql) === TRUE) {
          echo "New record created successfully<br>";
      } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
      }

    } else{
        echo "There was an error uploading the file, please try again!";
    }
  } else {

    include_once 'dbconnect.php';
    $path = "";
         $sql = "INSERT INTO data (uid,fileUrl,text,dataType)
          VALUES ('".$userRow['email']."', '".$path."', '".$_POST['message']."', '".$_POST['dataType']."')";


        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
}

}
?>
<script>
    alert('<?php  echo("this = ".$_FILES['pic']); ?>')
</script>

<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Hello,<?php echo $userRow['email']; ?></title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"/>
    <link rel="stylesheet" href="assets/css/index.css" type="text/css"/>

    <style scoped>
.example2 {
  font-family: Helvetica, Arial, sans-serif;
  text-align: center;
}
</style>
<style>
.myForm {
font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
font-size: 0.8em;
padding: 1em;
border: 9px solid #ccc;
border-radius: 15px;
}

.myForm * {
box-sizing: border-box;
}

.myForm label {
padding: 0;
font-weight: bold;
}

.myForm input {
border: 1px solid #ccc;
border-radius: 3px;
font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
font-size: 0.9em;
padding: 0.5em;

}

.myForm button {
padding: 0.7em;
border-radius: 0.5em;
background: #eee;
border: none;
font-weight: bold;
}

.myForm button:hover {
background: #ccc;
cursor: pointer;
}
</style>
</head>
<body>

<!-- Navigation Bar-->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">DHCBA</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <!-- <ul class="nav navbar-nav">
                <li class="active"><a href="#">First Link</a></li>
                <li><a href="#">Second Link</a></li>
                <li><a href="#">Third Link</a></li>
            </ul> -->
            <ul class="nav navbar-nav navbar-right">

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">
                        <span
                            class="glyphicon glyphicon-user"></span>&nbsp;Logged
                        in: <?php echo $userRow['email']; ?>
                        &nbsp;<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>




<div class="container" style="margin-top: 5%;">
    <!-- <input type="image" src="download.jpg" alt="Submit" width="90" height="90" align="right"> -->
<div class="example2">
<!-- <h1 style="font-size:500%"><span style="color:blue">DHCBA</span></h1> -->
</div>

<p>
<label style="font-size:200%">message</label> 
<form method="post" enctype="multipart/form-data" name="myForm" value="message" action="./index.php">
  <input type="file" name="uploaded_file" accept="image/*">
  <p>
   <label for="from">Your message:</label>
<br />
   <input type="text" name="dataType" hidden value="message">
   <textarea name="message" id="message" style="height: 50px; width: 1100px;" placeholder="Enter text here..."></textarea><br>
   <input type="submit" name="enter">
</p>      
</form>
<label style="font-size:200%">Notices</label>
<form enctype="multipart/form-data" method="post" name="myForm" value="notices" action="./index.php">
  <input type="file" name="uploaded_file" accept="image/*">
<p>
   <label for="from">Your Notices:</label>
<br />
   <input type="text" name="dataType" hidden value="notices">
   <textarea name="message" id="message" style="height: 50px; width: 1100px;" placeholder="Enter text here..."></textarea><br>
   <input type="submit" name="enter">
</p>
</form>
<label style="font-size:200%">Obituary</label> 
<form enctype="multipart/form-data" method="post" name="myForm" value="obituary" action="./index.php">
  <input type="file" name="uploaded_file" accept="image/*">
<p>
   <label for="from">Your Obituary:</label>
<br />

   <input type="text" name="dataType" hidden value="obituary">
   <textarea name="message" id="message" style="height: 50px; width: 1100px;" placeholder="Enter text here..."></textarea><br>
   <input type="submit" name="enter">
</p>

</form>
<label style="font-size:200%">Events</label> 
<form enctype="multipart/form-data" method="post"  name="myForm" value="events" action="./index.php">
  <input type="file" name="uploaded_file" accept="image/*">
<p>
   <label for="from">Your Events:</label>
<br />
   <input type="text" name="dataType" hidden value="events">
   <textarea name="message" id="message" style="height: 50px; width: 1100px;" placeholder="Enter text here..."></textarea><br>
   <input type="submit" name="enter">
</p>

</form>
</p>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

</body>
</html>

