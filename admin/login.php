<?php 
session_start();
if(isset($_SESSION['admin'])){
	header('Location: dashboard.php');
	
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
	WHERE Name=? AND Password=? AND GroupID=1");
$stmt->execute(array($UserName,$password));
$get= $stmt->fetch();
$count=$stmt->rowCount();  // Number of record Founded IN DATABASE

// If count > 0 The Data base has the record
if($count > 0){
	$_SESSION['admin'] = $UserName ; // Register Session Name
	$_SESSION['id'] = $get['ID'] ;
	header('Location: dashboard.php');
	echo 'admin';
	exit();	

}


}
}
?>
<div class="container login-page">
	<h1 class="text-center">
	<span class="selected" data-class="login">Login</span> 
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
	class="btn btn-primary" 
	name="login" 
	type="submit" 
	value="login" />
</form>


</div>