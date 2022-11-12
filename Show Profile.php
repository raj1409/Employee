<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Edit</title>
</head>
<body>
<?php
session_start();
define("filepath", "users.json");
$fnameErr = $lnameErr  = $genderErr = $dobErr = $religionErr = $addressErr  =$phoneErr = "";  
$fname = $lname  = $gender = $dob = $religion = $Address  =$phone = "";  
$flag = false;
$successfulMessage = $errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {  
    
    if (empty($_POST["fname"])) 
    {  
        $fnameErr = " *This field can't be empty";
        $flag = True;  
    }
    if (empty($_POST["lname"])) 
    {  
        $lnameErr = " *This field can't be empty";
        $flag = True;  
    }
  
     
    
    if (empty($_POST["gender"])) 
    {  
        $genderErr = "*This field can't be empty";
        $flag = True;  
    }     
    if (empty($_POST["dob"])) 
    {  
        $dobErr = " *This field can't be empty";
        $flag = True;  
    }  

    if (empty($_POST["religion"])) 
    {  
        $religionErr = " *This field can't be empty";
        $flag = True;  
    } 
    if (empty($_POST["Address"])) 
    {  
        $addressErr = " *This field can't be empty";
        $flag = True;  
    } 

    if (empty($_POST["phone"])) 
    {  
        $phoneErr = " *This field can't be empty";
        $flag = True;  
    } 

    if(!$flag) 
    {

    $fname = input_data($_POST["fname"]);
    $lname = input_data($_POST["lname"]);
 
    $gender = input_data($_POST["gender"]);
    $dob = input_data($_POST["dob"]);
    $religion = input_data($_POST["religion"]);
    $Address = input_data($_POST["Address"]);
    $phone = input_data($_POST["phone"]);
      
    session_start();
    $username = "";
    if(isset($_SESSION['username'])) 
    {
    $username = $_SESSION['username'];
    }
    $fileData = read();
    $datas=json_decode($fileData);
    foreach($datas as $data)
    {
    if($data->username == $username )
    {
    $data->fname = $fname;
    $data->lname = $lname;
    
    $data->gender = $gender;
    $data->dob = $dob;
    $data->religion = $religion;
    $data->Address = $Address;
    $data->phone = $phone;
    $result = json_encode($datas);
    write("");
    $show = write($result);
        if($show) {
        $successfulMessage = "Data Updated";
        }
        else {
        $errorMessage = "Error while Updating.";
        }
   }
  }
 }
}

function input_data($data) {  
$data = trim($data);  
$data = stripslashes($data);  
$data = htmlspecialchars($data);  
return $data;  
}

function write($content) {
$file = fopen(filepath, "w");
$fw = fwrite($file, $content . "\n");
fclose($file);
return $fw;
}
?> 


<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" novalidate enctype="application/x-www-form-urlencoded">
  <fieldset>
    <legend>Show Personal Information</legend>
        <label for="fname">Enter your First name:</label>
    <input type="text" id="fname" name="fname" value = "<?php echo $_SESSION['fname']; ?>" placeholder="Please fill this blank" >
    <?php echo $fnameErr; ?>  <br><br>
        <label for="lname">Enter your Last name:</label>
    <input type="text" id="lname" name="lname" value = "<?php echo $_SESSION['lname']; ?>" placeholder="Please fill this blank">
    <?php echo $lnameErr; ?>  <br><br>
    
    <label for="DOB">Date of birth:</label>
    <input type="date" id="dob" name="dob" value = "<?php echo $_SESSION['dob']; ?>">
    <?php echo "&nbsp;&nbsp;".$dobErr; ?><br><br>
   
    </fieldset>
    <fieldset>
    <legend>Update Contact Information</legend>
    <label for="Address">Enter your Address:</label>
    <textarea name="Address" rows="3" cols="40"  placeholder="Please fill this blank"><?php echo $_SESSION['praddress']; ?></textarea>
    <?php echo $addressErr; ?><br><br>

    <?php echo "<img src='upload/" . $_SESSION['image'] . "' width='100' height='100' >" ; ?>

   
 
    </fieldset>
  <br>
 </form>
 <br>
 <a href="Employee homepage.php">Go Back</a><br>
 <?php echo "<b>".$successfulMessage."</b>"; ?>
 <?php echo "<b>".$errorMessage."</b>"; ?>

 <?php
function read() {
$file = fopen(filepath, "r");
$fz = filesize(filepath);
$fr = "";
if($fz > 0) {
$fr = fread($file, $fz);
}
fclose($file);
return $fr;
}
?>
</body>
</html>