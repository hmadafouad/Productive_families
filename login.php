<?php 
session_start();
if(isset($_SESSION['username'])){
	header('Location: homepage.php');
	
}
include 'include.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

if(isset($_POST['login'])){

// To Get Value From the Form
$UserName  = $_POST['username'];

$password  = $_POST['password'] ;

	

// Check if the User In Database
$stmt=$connect->prepare("SELECT ID,Name, Password 
	FROM users 
	WHERE Name=? AND Password=?");
$stmt->execute(array($UserName,$password));
$get= $stmt->fetch();
$count=$stmt->rowCount();  // Number of record Founded IN DATABASE

// If count > 0 The Data base has the record
if($count > 0){
	$_SESSION['username'] = $UserName ; // Register Session Name
	$_SESSION['uid'] = $get['ID'] ;
	header('Location: homepage.php');
	exit();	
}


}else{
$UserName  = $_POST['username'];	
$email     = $_POST['email'];
$password  = $_POST['password'] ;
$fullName  = $_POST['full'] ;
$phone     = $_POST['whats'] ;
$insta     = $_POST['insta'] ;
$city      = $_POST['city'] ;

$formErrors=array();     // validate the form 
    
	// Check the Name Doesnt Exist
    $stmt=$connect->prepare("SELECT Name FROM users Where Name=?");
    $stmt->execute(array($UserName));
    $check=$stmt->rowcount();
    if($check>0){
    	$formErrors[]= '<div class="alert alert-danger">Username is already <strong> exist </strong></div>';
    }
    if($_POST['city']=='city'){
    	$formErrors[]= '<div class="alert alert-danger">You Have To Choose <strong> City </strong></div>';
    }
    foreach ($formErrors as $error) {
	echo $error ;
}
//check if there is no error update the database
if(empty($formErrors)){

	// insert record into database with this Info
			
		$stmt=$connect-> prepare("
		INSERT INTO 
		users(Name,Email,Password,FullName,Phone,Instagram,City,Date)
		VALUES
		(:zuser, :zmail, :zpass, :zfull, :zphone, :zinsta, :zcity,now())");

		$stmt-> execute(array(
		'zuser' =>$UserName,
		'zmail' =>$email,
		'zpass' =>$password, 
		'zfull' =>$fullName,
		'zphone'=>$phone,
		'zinsta'=>$insta,
		'zcity' =>$city));
}
}
}
?>
<div class="container login-page">
	<h1 class="text-center">
	<span class="selected" data-class="login">Login</span> | 
	<span data-class="signup">Signup</span> 
	</h1>


<!-- Start Login Form -->
<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
<input 
	class="form-control" 
	type="text" 
	name="username" 
	autocomplete="off"
	placeholder="username" />
<input 
	minlength="4" 
	class="form-control" 
	type="password" 
	name="password" 
	autocomplete="new-password"
	placeholder="Password" 
	required="required" />
<input 
	class="btn btn-primary form-control" 
	name="login" 
	type="submit" 
	value="login" />
</form>



<!-- Signup Form -->
<form class="signup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
	<div class="input-container">

<input 
    pattern=".{4,9}"
	title="UserName Must Be More than 4 char And Less Than 10"
	class="form-control" 
	type="text" 
	name="username" 
	autocomplete="off"
	placeholder="username" 
	required="required" />
</div>


<input 
	class="form-control" 
	type="email" 
	name="email" 
	autocomplete="off"
	placeholder="Email"
	required="required" />


<input 
	minlength="6" 
	class="form-control" 
	type="password" 
	name="password" 
	autocomplete="new-password"
	placeholder="Password"
	required="required" />

<input 
	class="form-control" 
	type="text" 
	name="full" 
	autocomplete=""
	placeholder="Full Name"
	 />	


<input 
	class="form-control" 
	type="tel" 
	name="whats" 
	placeholder="WhatsApp:05xxxxxxxxxx"
	pattern="[0-9]{10}" 	 />	


<input 
	class="form-control" 
	type="text" 
	name="insta" 
	autocomplete=""
	placeholder="Instagram"
	required="" 
	 />	

<!-- City field-->
		<select  class="form-control" name="city" id="city" required="">
			<option>city</option>
		    <option value="Abha">Abha</option>
		    <option value="Albaha">Albaha</option>
		    <option value="Dammam">Dammam</option>
		    <option value="Hafr">Hafr Albatin</option>
		    <option value="Jeddah">Jeddah</option>
		    <option value="Jizan">Jizan</option>
		    <option value="Khobar">Khobar</option>
		    <option value="Mecca">Mecca</option>
		    <option value="Medina">Medina</option>
		    <option value="Najran">Najran</option>
		    <option value="Riyadh">Riyadh</option>
		    <option value="Taif">Taif</option>
		    <option value="Tabuk">Tabuk</option>
		    <option value="Qassim">Qassim</option>
		    <option value="Yanbu">Yanbu</option>

		
		</select>	
<div>
<input 
	class="btn btn-success form-control" 
	name="signup" 
	type="submit" 
	value="Signup" />
</div>
</form>
<!-- End Signup Form -->

</div>

