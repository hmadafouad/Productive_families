<?php
session_start();
$pageTitle= 'Profile';
include "include.php";

if(isset($_SESSION['username'])){
 

$do= isset($_GET['do']) ? $_GET['do'] : 'manage';

if ($do =='manage') {

$id_member=$_SESSION['uid'];	
$getUser=$connect->prepare("SELECT * FROM users WHERE Name=?");
$getUser->execute(array($_SESSION['username']));
$info=$getUser->fetch();
?>

<h1 class="text-center">My Profile</h1>
<div class="container info">

			<div><i class="fas fa-id-badge">      <span>  Name    </span>: <?php echo $info['Name']; ?> </i>          </div>
			<div><i class="fas fa-envelope">      <span>  Email           </span>: <?php echo $info['Email'];?> </i>  </div>
			<div><i class="fas fa-id-badge">      <span>  Full Name       </span>: <?php echo $info['FullName'];?></i></div>
			<div><i class="fas fa-map-marker-alt"><span>  City   </span>: <?php echo $info['City']; ?>   </i>         </div>
			<?php 
			if($info['Phone'] != 0){ ?>
			<div><strong><i class="fab fa-whatsapp"><span> WhatsApp</span>: <?php echo $info['Phone']; ?> </i></strong>        </div>
		   <?php }
		  ?>
			<div><strong><i class="fab fa-instagram">     <span>  Instagram</span>: <?php echo $info['Instagram']; ?> </i>    </strong> </div>
			
<div><i class="fas fa-ad"><span> Number of Ads   </span>: <?php 
echo countItem('ID','items','where Member_ID='.$info['ID'].'') ?> </i>  </div>
			<div><i class="fas fa-calendar-alt">  <span>  Registered Date </span>: <?php echo $info['Date'];?> </i>   </div>
    
			<a href='profile.php?do=info&userid=<?php echo $info['ID']; ?>'   class=" btn btn btn-success "><i class="fas fa-user-edit ">  Edit Information </i></a>
			
		</div>
	</div>




<?php	


}elseif ($do== 'info') {

	$userid= isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0; 
$stmt= $connect->prepare(" SELECT * FROM  users where ID= ? ");
$stmt->execute(array($userid));

// fetch data
$row=$stmt->fetch();
$count= $stmt->rowcount();

// if the id exist
     if($count > 0){ ?>

		 	<h1 class="text-center">Edit Informaion</h1>
		     <div calss="cntainer">
			 <form class="form-horizontal" action="profile.php?do=updated" method="POST">

			        <input type="hidden" name="userid" value="<?php echo $userid?>" />
			     <!-- username field-->
			     <div class="form-group">
			        <label class="col-sm-2 control-label">Username</label>
			         <div class="col-sm-10 col-md-4">
			          <input type="text" name="username" class="form-control" value="<?php echo $row['Name'] ?>" autocomplete="off" required="required" />
			         </div>
			      </div>
			    <!-- end username field-->

			    <!-- Email field-->
			     <div class="form-group">
			       <label class="col-sm-2 control-label">Email</label>
			        <div class="col-sm-10 col-md-4">
			        <input type="email" name="email" class="form-control" value="<?php echo $row['Email'] ?>"required="required"/>
			        </div>
			        </div>
			    <!-- end email field-->
			    
			    <!-- password field-->
			     <div class="form-group">
			       <label class="col-sm-2 control-label">Password</label>
			        <div class="col-sm-10 col-md-4">
			        	<input type="hidden" name="oldPassword" value="<?php echo $row['Password']?>"/>
			        <input type="password" name="newPassword" class="form-control" autocomplete="new-password" />
			        </div>
			        </div>
			    <!-- end password field-->
			    
			    <!-- Full name field-->
			     <div class="form-group">
			       <label class="col-sm-2 control-label">Full Name</label>
			        <div class="col-sm-10 col-md-4">
			        <input type="text" name="full" class="form-control" value="<?php echo $row['FullName'] ?>"/>
			        </div>
			        </div>
			    <!-- end Full name field-->
			    
			    <div class="form-group">
			    	<label class="col-sm-2 control-label">WhatsApp</label>
			    	<div class="col-sm-10 col-md-4">
			    <input 
					type="tel" 
					name="whats" 
					class="form-control"
					placeholder="WhatsApp"
					value="<?php echo $row['Phone'] ?>"/>	
					</div>
				</div>	

				<div class="form-group">
			    	<label class="col-sm-2 control-label">Instagram</label>
			    	<div class="col-sm-10 col-md-4">
			    <input 
					type="text" 
					name="insta" 
					class="form-control"
					placeholder="Instagram"
					value="<?php echo $row['Instagram'] ?>"
					required="" />	
					</div>
				</div>	

                
			    <!-- City field-->
			    <div class="form-group">
				<label class="col-sm-2 control-label">City</label>
				<div class="col-sm-10 col-md-4">
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
			    </div>
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

  } 


}elseif ($do== 'updated') {

echo "<h1 div class='text-center'>Update Information</h1>";
echo "<div class='container'>";

if($_SERVER['REQUEST_METHOD']=='POST'){
// get variable from form
	$id=$_POST['userid'];
	$user=$_POST['username'];
	$email=$_POST['email'];
	$name=$_POST['full'];
	$whats=$_POST['whats'];
	$insta=$_POST['insta'];
	$city=$_POST['city'];
	$pass=empty($_POST['newPassword'])?$_POST['oldPassword']:$_POST['newPassword'];
    // password trick

	
	
	$formErrors=array();     // validate the form 
    
	
    if(strlen($user) < 4 ){
    	$formErrors[]= '<div class="alert alert-danger">Username cant be less than <strong> 4 letters </strong></div>';
    }
	if (empty($user)){
		$formErrors[]= '<div class="alert alert-danger"> username cant be <strong> empty </strong></div>'; }

	if (empty($name)){
		$formErrors[]='<div class="alert alert-danger"> Full name cant be <strong> empty </strong></div>'; }
 
	if (empty($email)){
		$formErrors[]= '<div class="alert alert-danger"> Email cant be <strong> empty </strong> </div>'; }		
    
    foreach ($formErrors as $Msg) {

	 redirect($Msg,'back',5);
}
//check if there is no error update the database
if(empty($formErrors)){

	// update the database with this Info
	$stmt = $connect ->prepare("UPDATE 
		users 
	SET 
		Name=?, 
		Email=?, 
		password=?,
		FullName=?,
		Phone=?,
		Instagram=?,
		City=?  
	WHERE ID=? ");
	$stmt-> execute(array($user, $email,$pass, $name,$whats,$insta,$city,$id));
    $count= $stmt->rowcount();
	$Msg= "<div class='alert alert-success'>" . $count . 'information updated </div>' ;
	redirect($Msg,'profile.php',5);
}
	

} else {

	$Msg='<div class="alert alert-danger">sorry you cant browse this page directly</div>';
	redirect($Msg);
} 
 echo "</div>";


}	
}else {
header('Location:homepage.php');
exit();
} 
