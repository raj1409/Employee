<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login page</title>
</head>
<body>
<?php
$usernameErr = $passwordErr = "";
$login = ""; 
$flag = false;

define("filepath", "users.json");
 if ($_SERVER["REQUEST_METHOD"] == "POST") 
{ 


if (empty($_POST["username"])) 
    {  
       $usernameErr = " Username is required";
       $flag = True;  
    } 

if (empty($_POST["password"])) 
    {  
       $passwordErr = " Password is required";
       $flag = True;  
    } 
 
if(!$flag) 
    {
    	

    $username = input_data($_POST["username"]);
    $password = input_data($_POST["password"]); 
    $fileData = read();
    $users=json_decode($fileData);

    	foreach($users as $user)

	{
   
	if($user->username === $username && $user->password === $password)
    session_start();
    $_SESSION['fname'] = $user->fname;
    $_SESSION['lname'] = $user->lname;
    $_SESSION['gender'] = $user->gender;
    $_SESSION['dob'] = $user->dob;
    $_SESSION['religion'] = $user->religion;
    $_SESSION['praddress'] = $user->praddress;
    $_SESSION['religion'] = $user->religion;
    $_SESSION['username'] = $user->username;
    $_SESSION['image'] = $user->image;
    $_SESSION['password'] = $user->password;
	$flag = true;
	}
    if($flag)
    {

   
    header("Location: homepage.php");
    }
    else 
    {
	$login =  "Wrong password";
    }
    }
}
function input_data($data) 
{  
$data = trim($data);  
$data = stripslashes($data);  
$data = htmlspecialchars($data);  
return $data;  
}
function write($content) {
$file = fopen(filepath, "w+");
$fw = fwrite($file, $content . "\n");
fclose($file);
return $fw;
}
?>
<h1>Login</h1><br>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
<fieldset>
	<br><br>
<label for="username">User Name:</label>
<input type="text" name="username" id="username" >
<?php echo $usernameErr; ?> <br><br>
<label for="password">Password:</label>
<input type="password" name="password" id="password" >
<?php echo $passwordErr; ?>
<?php echo $login; ?>  <br><br>
<input type="submit" name="submit" value="Login">
<br><br><br>
<a href="http://localhost/filedemo/registration.html">Create New Account</a><br><br>

</fieldset>
</form>
    
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