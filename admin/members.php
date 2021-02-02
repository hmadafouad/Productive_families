<?php
/*
** Manage Members Page
** You can add | edit | Delete Members from here
*/

session_start();

$pageTitle=''; 

if(isset($_SESSION['admin'])){
 
 include "include.php";

$do= isset($_GET['do']) ? $_GET['do'] : 'manage';

 
 if ($do =='manage') {

 	$select=$connect->prepare("SELECT * 
	FROM 
	   users 
	WHERE GroupID=0");
$select->execute();	
$users=$select->fetchAll();
?>
<h1 class="text-center">Manage Members</h1>
    <div class="container">
        <div class="table-responsive">
            <table class="main-table text-center table table-bordered">
            <tr>
                <td>#ID</td>
                <td>Name</td>
                <td>Email</td>
                <td>Full Name</td>
                <td>City</td>
                <td>Registered Date</td>
                <td>Control</td>
            </tr>   
<?php           
foreach ($users as $user) {
            echo "<tr>";
                echo "<td>" . $user['ID']. "</td>" ;
                echo "<td>" . $user['Name']. "</td>" ;
                echo "<td>" . $user['Email']. "</td>" ;
                echo "<td>" . $user['FullName']. "</td>" ;
                echo "<td>" . $user['City']. "</td>" ;
                echo "<td>" . $user['Date']. "</td>" ;
                echo "<td>
                <a href='members.php?do=edit&userid=".$user['ID']."' class='btn btn-success'><i class='fas fa-edit'></i>Edit</a> 
                <a href='members.php?do=delete&userid=".$user['ID']."' class='confirm btn btn-danger'><i class='fas fa-times'></i>Delete</a>
                </td>";
            echo "<tr>";
    }
echo '</table>';
echo '</div>';
echo '</div>';
echo "<div class='text-center'><a href='members.php?do=add' class='btn btn-primary add'><i class='fas fa-plus edit'></i>Add Member</a></div>"; 


} elseif ($do== 'add') {
?> 	
<h1 class="text-center">Add New Member</h1>
			        <div calss="container">
			 <form class="form-horizontal" action="members.php?do=insert" method="POST" enctype="multipart/form-data">
			       
			     <!-- username field-->
			     <div class="form-group">
			        <label class="col-sm-2 control-label">Username</label>
			         <div class="col-sm-10 col-md-4">
			          <input type="text" 
			          name="username" 
			          pattern=".{4,9}"
			          class="form-control"autocomplete="off" required="required" />
			         </div>
			      </div>
			    <!-- end username field-->
			    
			    <!-- password field-->
			     <div class="form-group">
			       <label class="col-sm-2 control-label">Password</label>
			        <div class="col-sm-10 col-md-4">
			        <input type="password" 
			        minlength="6" 
			        name="password" 
			        class="password form-control" autocomplete="new-password" required="required" />
			        </div>
			        </div>
			    <!-- end password field-->

			    
			    <!-- Email field-->
			     <div class="form-group">
			       <label class="col-sm-2 control-label">Email</label>
			        <div class="col-sm-10 col-md-4">
			        <input type="email"
			        name="email" 
			        class="form-control" required="required"/>
			        </div>
			        </div>
			    <!-- end email field-->
			    
			    <!-- Full name field-->
			     <div class="form-group">
			       <label class="col-sm-2 control-label">Full Name</label>
			        <div class="col-sm-10 col-md-4">
			        <input type="text" name="full" class="form-control" />
			        </div>
			        </div>
			    <!-- end Full name field-->

			    <!-- City field-->
				<div class="form-group">
				<select name="city" required="">
					<option value="city">City</option>
				    <option value="Abha">Abha</option>
				    <option value="Albaha">Albaha</option>
				    <option value="Dammam">Dammam</option>Dammam
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
			    </div>
			    <!-- submit field-->
			     <div class="form-group">
			      
			        <div class="col-sm-offset-2 col-sm-10">
			        <input type="submit" value="Add Member" class="btn btn-primary"/>
			        </div>
			        </div>
			    <!-- end submit field-->
			    </form>
			    </div>
   
 
 <?php 

} elseif ($do=='insert') {

	if($_SERVER['REQUEST_METHOD']=='POST'){
echo "<h1 div class='text-center'> Add Memberer</h1>";
echo "<div class='container'>";


// get variable from form
	$user=$_POST['username'];
	$pass=$_POST['password'];
	$email=$_POST['email'];
	$name=$_POST['full'];
	$city=$_POST['city'];


	$formErrors=array();     // validate the form 
    
    // Check the Name Doesnt Exist
    $stmt=$connect->prepare("SELECT Name FROM users Where Name=?");
    $stmt->execute(array($user));
    $check=$stmt->rowcount();

    if(strlen($user) < 4 ){
    	$formErrors[]= '<div class="alert alert-danger text-center">Username cant be less than <strong> 4 letters </strong></div>'; }
	if (empty($user)){
		$formErrors[]= '<div class="alert alert-danger text-center"> username cant be <strong> empty </strong></div>'; }
	if (empty($pass)){
		$formErrors[]= '<div class="alert alert-danger text-center"> password cant be <strong> empty </strong></div>'; }
	if (empty($email)){
		$formErrors[]= '<div class="alert alert-danger text-center"> Email cant be <strong> empty </strong> </div>'; }		
	if($check>0){
    	$formErrors[]= '<div class="alert alert-danger text-center">Username is already <strong> exist </strong></div>';
    }
    if($_POST['city']=='city'){
    	$formErrors[]= '<div class="alert alert-danger text-center">You Have To Choose <strong> City </strong></div>';
    }
    foreach ($formErrors as $Msg) {
	redirect($Msg,'back',5);
	 }

//check if there is no error insert in database
if(empty($formErrors)){

		// insert record into database with this Info			
		$stmt=$connect-> prepare("INSERT INTO 
			users(Name,Email,Password,FullName,City, Date)
			VALUES(:zuser, :zmail, :zpass, :zname, :zcity,now())");

		$stmt-> execute(array(
		'zuser' =>$user,
		'zmail'=>$email,
		'zpass'=>$pass,
		'zname'=>$name,
		'zcity'=>$city));

		$count=$stmt->rowcount();
		$Msg="<div class='alert alert-success text-center'>" . $count . 'Member Added </div>' ;
		redirect($Msg,'members.php',5);
		}


} else {

			echo "<div class='container'>";
			echo '<div class="alert alert-danger text-center"> sorry you cant browse this page directly </div>';
			echo "</div>";
			} 	
echo "</div>";
	

 } elseif ($do== 'edit') {

 	$userid= isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0; 
$stmt= $connect->prepare(" SELECT * FROM  users where ID= ? ");
$stmt->execute(array($userid));

// fetch data
$row=$stmt->fetch();
$count= $stmt->rowcount();

// if the id exist
     if($count > 0){ ?>

		 	<h1 class="text-center">Edit Member</h1>
		     <div calss="cntainer">
			 <form class="form-horizontal" action="members.php?do=update" method="POST">

			        <input type="hidden" name="userid" value="<?php echo $userid?>" />
			     <!-- username field-->
			     <div class="form-group">
			        <label class="col-sm-2 control-label">Username</label>
			         <div class="col-sm-10 col-md-4">
			          <input type="text" name="username" class="form-control" 
			          pattern=".{4,9}" value="<?php echo $row['Name'] ?>" autocomplete="off" required="required" />
			         </div>
			      </div>
			    <!-- end username field-->
			    
			    <!-- password field-->
			     <div class="form-group">
			       <label class="col-sm-2 control-label">Password</label>
			        <div class="col-sm-10 col-md-4">
			        	<input type="hidden" name="oldPassword" value="<?php echo $row['Password']?>"/>
			        <input type="password" name="newPassword" minlength="6"  class="form-control"  autocomplete="new-password" />
			        </div>
			        </div>
			    <!-- end password field-->
			    
			    <!-- Email field-->
			     <div class="form-group">
			       <label class="col-sm-2 control-label">Email</label>
			        <div class="col-sm-10 col-md-4">
			        <input type="email" name="email" class="form-control" value="<?php echo $row['Email'] ?>"required="required"/>
			        </div>
			        </div>
			    <!-- end email field-->
			    
			    <!-- Full name field-->
			     <div class="form-group">
			       <label class="col-sm-2 control-label">Full Name</label>
			        <div class="col-sm-10 col-md-4">
			        <input type="text" name="full" class="form-control" value="<?php echo $row['FullName'] ?>"/>
			        </div>
			        </div>
			    <!-- end Full name field-->
			    
                
			    <!-- City field-->
				<label>City</label>
				<select name="city">
					<option value= '<?php echo $row['City']  ?>' selected="" > <?php echo $row['City'] ?> </option>
				    <option value="Abha" >Abha</option>
				    <option value="Albaha">Albaha</option>
				    <option value="Dammam">Dammam</option>Dammam
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
			    
			    <!-- submit field-->
			     <div class="form-group">
			      
			        <div class="col-sm-offset-2 col-sm-10">
			        <input type="submit" value="save" class="btn btn-primary"/>
			        </div>
			        </div>
			    <!-- end submit field-->
			    </form>
			    </div>
 	
 <?php 

  } else {
  
  	echo "<div class='container'>";
  	echo '<div class="alert alert-danger text-center">there is no such ID </div>';
  	
  	echo "</div>";

  }
 	

} elseif ($do=='update') {

if($_SERVER['REQUEST_METHOD']=='POST'){

// To Get Vlues From Forms
	$id=$_POST['userid'];
	$user=$_POST['username'];
	$email=$_POST['email'];
	$name=$_POST['full'];
	$city=$_POST['city'];
	if(empty($_POST['newPassword'])){
	$pass= $_POST['oldPassword'];	
	}else{
		$pass= $_POST['newPassword'];
	}

$formErrors=array();     // validate the form 
    
    
    if(strlen($user) < 3 ){
    	$formErrors[]= '<div class="alert alert-danger text-center">Username cant be less than <strong> 3 letters </strong></div>';
    }
	if (empty($user)){
		$formErrors[]= '<div class="alert alert-danger text-center"> username cant be <strong> empty </strong></div>'; }

	if (empty($email)){
		$formErrors[]= '<div class="alert alert-danger text-center"> Email cant be <strong> empty </strong> </div>'; }		
    
    foreach ($formErrors as $Msg) {
	redirect($Msg,'back',5);
}	

if(empty($formErrors)){
	$stmt=$connect->prepare("UPDATE users
	SET 
		Name=?,
		Email=?,
		Password=?,
		FullName=?,
		City=?
	 WHERE ID=? ");
	$stmt->execute(array($user,$email,$pass,$name,$city,$id));
	$count= $stmt->rowcount();
	$Msg= "<div class='alert alert-success text-center'>" . $count . 'Member updated </div>' ;
	redirect($Msg,'members.php',5);
}

 
}
} elseif ($do=='delete') {
	
	echo "<h1 div class='text-center'>Delete Memberer</h1>";
    echo "<div class='container'>";

	// check if userid is numeric
		$userid= isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0; 


		$stmt= $connect->prepare(" SELECT * FROM  users where ID= {$userid} ");
		$stmt->execute();
		$check=$stmt->rowcount();
		
		
		// if the id exist
		  
		 if($check > 0){ 
		 $stmt=$connect->prepare("DELETE FROM users WHERE ID= ?");
		 $stmt-> execute(array($userid));
		$Msg="<div class='alert alert-success text-center'>" . $stmt->rowcount() . 'Member deleted </div>' ;
		redirect($Msg,'members.php',5);
		}

		else{

		echo '<div class="alert alert-danger text-center">This id is not exist</div>';
		
		}
		
		echo '</div>';

} 

}else {
header('Location:login.php');
exit();
} 