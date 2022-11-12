<!DOCTYPE html>
<html>
<head>
<title>Change Password</title>
</head>
<body>
<?php
define("filepath",  "users.json");
$newpasswordErr = $passwordoldErr = "";  
$newpassword = $passwordold = ""; 
$passE = ""; 
$flag = false;
$successfulMessage = $errorMessage = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {  

    if (empty($_POST["passwordold"])) 
    {  
        $passwordoldErr = " *This field can't be empty"; 
        $flag = True;
    } 
  
    if (empty($_POST["newpassword"])) 
    {  
        $newpasswordErr = " *This field can't be empty"; 
        $flag = True;
    } 
        

    if(!$flag) 
    {

    $passwordold = input_data($_POST["passwordold"]);
    $newpassword = input_data($_POST["newpassword"]);
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
    if($data->username === $username && $data->password === $passwordold)
    {
    $data->password = $newpassword;
    $result = json_encode($datas);
    write("");
    $show = write($result);
        if($show) {
        $successfulMessage = "Successfully changed";
        }
    }
    else {
    $errorMessage = "Wrong old password";
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

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
 <fieldset>
 <legend>Change Password</legend>
 <label for="passwordold">Enter Old Password:</label>
 <input type="password" id="passwordold" name="passwordold">
 <?php echo $passwordoldErr; ?><br><br>
 <label for="newpassword">Enter New Password:</label>
 <input type="password" id="newpassword" name="newpassword">
 <?php echo $newpasswordErr; ?>
 <br><br><input type="submit" value="Submit">
 </form>
 <br>
<?php echo "<b>".$successfulMessage."</b>"; ?>
<?php echo "<b>".$errorMessage."</b>"; ?>
</fieldset>
<br><br><a href="homepage.php">Go Back</a><br>

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