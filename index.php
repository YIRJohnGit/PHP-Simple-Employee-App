<?php

include_once("functions.php") ; 
$base_url=getBaseUrl() ;

?>


<html>
<head>
<title>Employee information</title>
<!-- <link rel="stylesheet" type="text/css" href="employee.css"> -->

</head>
<body>

<?php
$name = $email = $salary = $gender = $job = "";
$noname = $noemail = $nosalary = $nogender = $nojob = "";

if(!empty($_POST))
{

if($_SERVER["REQUEST_METHOD"]=="POST"){
	$input_error = false;
	if (empty($_POST["name"])){
	$noname= "name is required";
	$input_error = true;
	}
	else{
		$name = refine($_POST["name"]);
	if (!preg_match("/^[a-zA-Z ]*$/",$name)){
	 $noname="Invalid name";
	}
  }

    if (empty($_POST["email"])) {
    $noemail = "email is required";
    $input_error = true;
    } 
    else {
    $email = refine($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $noemail = "Invalid email format"; 
    }
  }
	
    if (empty($_POST["salary"])) {
    $nosalary = "salary is required";
    $input_error = true;
    }
    else {
    $salary = refine($_POST["salary"]);
    if (!filter_var($salary, FILTER_VALIDATE_FLOAT)) {
      $nosalary = "Invalid salary"; 
    }
    }
	
	if (empty($_POST["gender"])){
    $nogender = "gender is required";
    $input_error = true;
  } else {
    $gender = refine($_POST["gender"]);
  }



	if (empty($_POST["job"])){
    $nojob = "job required";
    $input_error = true;
  } else {
    $job = refine($_POST["job"]);
  }
  


}

if($input_error == false){
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "employees";


$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql = "INSERT INTO employee_data (employee_name,email,job,salary,gender)
VALUES ('$name', '$email', '$job','$salary','$gender')";



if (mysqli_query($conn, $sql)) {
	echo '<script language="javascript">';
echo 'alert("New record created successfully")';
echo '</script>';

} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
}
}

function refine($text){
    $text = trim($text);
    $text = stripslashes($text);
    $text = htmlspecialchars($text);
    return $text;
}

?>

	<center>
		<div class="head"><h1> EMPLOYEE  INFORMATION </h1></div>
		<h2>* required entries</h2>
	</center>
	<center>
		<div>
			<form  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<table>
					<tr>
						<td>NAME :</td>
						<td>
							<input type="text" name="name" value="<?php echo $name;?>">
						</td>
						<td> 
							<span id="error">*<?php echo $noname; ?></span>
						</td>
					</tr> 

					<tr>
						<td>EMAIL: </td>
						<td>
							<input type="text" name="email" value="<?php echo $email;?>">
						</td>
						<td> 
							<span id="error">*<?php echo $noemail; ?></span>
						</td>
					</tr>
					
					<tr>
						<td>JOB: </td>
						<td>
							<input type="text" name="job" value="<?php echo $job;?>">
						</td>
						<td>
							<span id="error">*<?php echo $nojob; ?></span>
						</td>
					</tr>
					
					<tr>
						<td>SALARY: </td>
						<td>
							<input type="text" name="salary" value="<?php echo $salary;?>">
						</td>
						<td>
							<span id="error">*<?php echo $nosalary ; ?></span>
						</td>
					</tr>
					
					<tr>
						<td>GENDER: </td>
						<td>
							<input type="radio" name="gender" <?php if (isset($gender) && $gender=="male") echo "checked";?> value="male">MALE
							<input type="radio" name="gender" <?php if (isset($gender) && $gender=="female") echo "checked";?> value="female">FEMALE
						</td>
						<td>
							<span id="error">*<?php echo $nogender; ?></span>
						</td>
					</tr>
				</table>
				<input type="submit" name="submit" value="SUBMIT" id="submit">
			</form>
		</div>
	</center>
	<div >
		<hr>
		<center>
			<button name="view" id="button" onclick= 'window.location.replace("<?php getBaseUrl() ;?>display_data.php")'w3>VIEW</button>
		</center>
	</div>
</body>
</html>

































