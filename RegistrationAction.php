
	<?php

function test($data)
{
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

   $flag = false;
   $destination = "upload/";
   $fileName = $_FILES['image']['name'];
   $tempFile = $_FILES['image']['tmp_name'];
   $target_file = $destination . basename($_FILES["image"]["name"]);
   $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
   
   define("filepath", "users.json");//file location


//Input fields validation  
if ($_SERVER["REQUEST_METHOD"] == "POST") {  
      
//String Validation  
    if (empty($_POST["firstname"])) 
    {  
        echo " first Name is required <br><br>"; 
        $flag = True;
        
    } 
  
    
    if (empty($_POST["lastname"])) 
    {  
       echo " Last Name is required <br><br>";
        $flag = True;  
    } 
     
    
    if (empty($_POST["gender"])) 
    {  
        echo " Gender is required <br><br>";
        $flag = True;  
    } 
      

    if (empty($_POST["dob"])) 
    {  
        echo  " Date of birth is required <br><br>";
        $flag = True;  
    }  

    if (empty($_POST["religion"])) 
    {  
       echo  " Religion is required <br><br>";
        $flag = True;  
    } 

    if (empty($_POST["praddress"])) 
    {  
        echo  " present Address is required <br><br>";
        $flag = True;  
    } 


    if (empty($_POST["mail"])) 
    {  
       echo " Email is required <br><br>";
       $flag = True;  
    } 

    if (empty($_POST["username"])) 
    {  
       echo " Username is required <br><br>";
       $flag = True;  
    } 

    if (empty($_POST["password"])) 
    {  
       echo " Password is required <br><br>";
       $flag = True;  
    } 

      if (empty($_POST["confirmpass"])) 
    {  
       echo " Confirm Password is required <br><br>";
       $flag = True;  
    } 
    
    if(strlen($_POST["username"])>5)
    {
    	echo " Username can be max 5 characters <br><br>";
    	$flag = True;
    }

    if(strcmp($_POST['password'],$_POST['confirmpass'])!=0)
    {
    	echo " Password doesn't matched <br><br>";
    	$flag = True;
    }

    if ($imageFileType != "jpg" && $imageFileType != "png") {
        echo "Sorry, only JPG files are allowed.";
        echo "<br>";
        $flag = true;
    }

	
if (!$flag) {

    $firstname = test($_POST['firstname']);
    $lastname = test($_POST['lastname']);
    $gender = test($_POST['gender']);
    $dob = test($_POST['dob']);
    $religion = test($_POST['religion']);
    $praddress = test($_POST['praddress']);
    $mail = test($_POST['mail']);
    $username = test($_POST['username']);
    $password = test($_POST['password']);

    $fileData = read();
    if (empty($fileData)){
        $data[]= array("fname" => $firstname, "lname" => $lastname, "gender" => $gender, "dob" => $dob, "religion" => $religion, "praddress" => $praddress, "mail" => $mail, "username" => $username, "password" => $password,"image"=>$fileName);

    }
    else{
        $data = json_decode($fileData);
        array_push($data,array("fname" => $firstname, "lname" => $lastname, "gender" => $gender, "dob" => $dob, "religion" => $religion, "praddress" => $praddress, "mail" => $mail, "username" => $username, "password" => $password,"image"=>$fileName));
    }
    $data_encode=json_encode($data);
    write("");
    $res = write($data_encode);
    if ($res){
        echo "Registration done successfully";
        move_uploaded_file($tempFile,$destination . "" .$fileName);
    }
    else{
        echo "Registration failed..!!!";
    }
 
 }
}

	
		
	?>
