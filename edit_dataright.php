<?php

include_once("functions.php") ; 
$base_url=getBaseUrl() ;

?>

<html>
<head>
<title>Employee information</title>
<!-- <link rel="stylesheet" type="text/css" href="edit_data.css"> -->

</head>
<body>

<?php
$name = $email = $salary = $gender = $job = "";
$noname = $noemail = $nosalary = $nogender = $nojob = "";

$id = $_GET['employee_id'];
    echo $_GET['employee_id'];
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "employees";


$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT employee_name,email,job,salary,gender FROM employee_data WHERE employeeID = '$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$name = $row["employee_name"];
$gender = $row["gender"];
$email = $row["email"];
$salary=$row["salary"];
$job = $row["job"];


if(!empty($_POST))
{
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $input_error = false;
	if (empty($_POST["name"])){
	$noname= "name is required";
	$input_error = true;
	}
	else{
		$name = check($_POST["name"]);
	if (!preg_match("/^[a-zA-Z ]*$/",$name)){
	 $noname="Invalid name";
	}
    }

    if (empty($_POST["email"])) {
    $noemail = "email is required";
    $input_error = true;
    } 
    else {
    $email = check($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $noemail = "Invalid email format"; 
    }
    }
    
   

	
    if (empty($_POST["salary"])) {
    $nosalary = "salary is required";
    $input_error = true;
    }
    else {
    $salary = check($_POST["salary"]);
    if (!filter_var($salary, FILTER_VALIDATE_FLOAT)) {
      $nosalary = "Invalid salary"; 
    }
    }
	
	if (empty($_POST["gender"])){
    $nogender = "gender is required";
    $input_error = true;
    } else {
    $gender = check($_POST["gender"]);
    }



	if (empty($_POST["job"])){
    $nojob = "job required";
    $input_error = true;
    } else {
    $job = check($_POST["job"]);
    }

   
    if($input_error == false){
    
    

$sql = "UPDATE employee_data SET employee_name='$name',email='$email',job='$job',salary='$salary',gender='$gender' 
WHERE employeeID='$id'";

// echo $sql;exit;

if (mysqli_query($conn, $sql)) {
	echo '<script language="javascript">';
      echo 'alert("Record updated successfully")';
      echo '</script>';
	} else {
    	echo "Error updating record: " . mysqli_error($conn);
    }
$sql = "SELECT employee_name,email,job,salary,gender FROM employee_data WHERE employeeID = '$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$name = $row["employee_name"];
$gender = $row["gender"];
$email = $row["email"];
$salary=$row["salary"];
$job = $row["job"];     

mysqli_close($conn);
}
}
}
function check($text){
    $text = trim($text);
    $text = stripslashes($text);
    $text = htmlspecialchars($text);
    return $text;
}


?>


	<center>
		<div class="head"><h1>EDIT EMPLOYEE INFORMATION </h1></div>
		<h3>* required entries</h3>
		<div class="theform">
			<form  method="post" action="edit_dataright.php?employee_id=<?php echo $id;?>">
				NAME : <br>
				<input type="text" name="name" value="<?php echo $name;?>">
					<span id="error">*<?php echo $noname; ?></span>
					<br><br>

				EMAIL: <br> 
				<input type="text" name="email" value="<?php echo $email;?>">
					<span id="error">*<?php echo $noemail; ?></span>
					<br><br>
				
				JOB: <br> 
				<input type="text" name="job" value="<?php echo $job;?>">
					<span id="error">*<?php echo $nojob; ?></span>
					<br><br>

				SALARY: <br>
				<input type="text" name="salary" value="<?php echo $salary;?>">
					<span id="error">*<?php echo $nosalary ; ?></span>
					<br><br>

				GENDER: <br> 
				<input type="radio" name="gender" <?php if (isset($gender) && $gender=="male") echo "checked";?> value="male">MALE
				<input type="radio" name="gender" <?php if (isset($gender) && $gender=="female") echo "checked";?> value="female">FEMALE*
					<span><?php echo $nogender; ?></span>
					<br><br>
				<hr>
				<input type="submit" name="submit" value="UPDATE" id="submit">
			</form>
		</div>
		
		<div>
			<hr>
			<button name="back" id="button" onclick= 'window.location.replace("<?php $base_url ;?>index.php")'>Back to Home</button>
		</div>
	</center>
</body>
</html>

