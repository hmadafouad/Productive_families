<?php
session_start();

$pageTitle='My Items'; 

if(isset($_SESSION['username'])){
 
 include "include.php";

$do= isset($_GET['do']) ? $_GET['do'] : 'manage';

 
 if ($do =='manage') {

$id_member=$_SESSION['uid'];	
$getUser=$connect->prepare("SELECT * FROM users WHERE Name=?");
$getUser->execute(array($_SESSION['username']));
$info=$getUser->fetch();
?>

<h1 class="text-center">My Items</h1>
<div class="container info">
<?php
$select=$connect->prepare("SELECT * FROM items WHERE Member_ID=?");
$select->execute(array($id_member));	

echo '<div class="row">';	
$path= "upload\\";
foreach ($select as $sel) {

echo '<div class="col-sm-6 col-md-4">';
	echo '<div class="thumbnail item-box">';
		echo "<img src='admin/upload/" . $sel['img']."'/>";
		echo '<div class="caption">';
			echo '<h3><i class="fas fa-ad"> ' . $sel['Name']  .       '</i></h3>';
		    echo '<p><i class="fas fa-tag"> '   . $sel['Price'] ." SR" .  '</i></p>';
		    echo '<p><i class="fas fa-map-marker-alt"> ' . $sel['City']  .       '</i></p>';
		    
	echo '</div>';    

	  echo "<a href='my_items.php?do=edit&itemid=".$sel['ID']."'class='btn btn-success'><i class='fas fa-edit '> Edit</i></a>"; 
	  echo ' ';
      echo "<a href='my_items.php?do=delete&itemid=".$sel['ID']."' class='confirm btn btn-danger'><i class='fas fa-times'> Delete</i></a>";
		
		echo '</div>';
	echo '</div>';
}

echo '</div>';
	echo '</div>';

echo "<div class='text-center'><a href='my_items.php?do=add' class=' btn btn-primary add'><i class='fas fa-plus edit'> Add Item</i></a></div>";



} elseif ($do== 'add') {
 	
$select=$connect->prepare("SELECT items.* , 
	users.City as Item_City
 FROM items
 INNER JOIN 
	   users
	ON
	   users.ID = items.Member_ID
 WHERE users.Name=?");
$select->execute(array($_SESSION['username']));	
$items=$select->fetch();
?>
<div calss="container">
	<form class="form-horizontal" action="my_items.php?do=insert" method="POST" enctype="multipart/form-data"> <!-- The ecnoded Type for upload File -->
			       		       
	    <!--name field-->
		 <div class="form-group">
	     <label class="col-sm-2 control-label">Name</label>
         <div class="col-sm-10 col-md-4">
	     <input type="text" name="name" class="form-control" required="required" />
         </div>
	     </div>
		 <!-- end name field-->
		
		<!--Description field-->
		 <div class="form-group">
	     <label class="col-sm-2 control-label">Description</label>
         <div class="col-sm-10 col-md-4">
	     <input type="text" name="description" class="form-control" />
	     </div>
	     </div>
	    <!-- end Description field-->

		<!--Price field-->
		 <div class="form-group">
	     <label class="col-sm-2 control-label">Price</label>
         <div class="col-sm-10 col-md-4">
	     <input type="text" name="price" class="form-control" required="required" />
	     </div>
	     </div>
		<!-- end price field-->

		<!-- Category field-->
		<div class="form-group">
	     
	     <select name="category" required="">
	     <option value="0">Category</option>
	     <?php 
	     $stmt2=$connect->prepare("SELECT * FROM categories");
	     $stmt2->execute();
	     $cats=$stmt2->fetchAll();
	     foreach ($cats as $cat) {
	  
			echo "<option value= '" . $cat['ID'] ."'>" .    $cat['Name']."</option>";
	       }
	     ?>
	     </select>

	     <!-- City field-->
		<select  class="form-control" name="city" id="city" required="">
			
			<option value="city">City </option>
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
		</div>	

		<!-- Image field-->
		<input type="file" name="img" required="required"/>

	    
        <input type="submit" value="Add Item" class="btn btn-primary"/> 
        </form>		
    </div>
<?php 
 

} elseif ($do=='insert') {
	
// Upload Variable
	$imgName   = $_FILES['img']['name'];
	$imgSize   = $_FILES['img']['size'];
	$imgTmp    = $_FILES['img']['tmp_name'];
	$imgType   = $_FILES['img']['type'];
	$extensionAllowed = array("jpeg", "jpg", "png", "gif");

	// Get img Extension
	$imgExtension = explode('.' , $imgName ); // explode To Display Last element in the Name
	$lastElement = strtolower(end($imgExtension));

	// Get Value From the Form
	$name   =	$_POST['name'];
	$desc   =	$_POST['description'];
	$price  =	$_POST['price'];
	$city   =	$_POST['city'];  
	$img    = $_FILES['img'];
	$cat_ID =   $_POST['category']  ;
	$Member_ID= $_SESSION['uid'];
				   

// Make sure No Errors in the form
	$formErrors= array();
	
	if($cat_ID==0){
		$formErrors[]= '<div class="alert alert-danger">You Have To Choose <strong>Category </strong></div>';
	}
	if($_POST['city']=='city'){
    	$formErrors[]= '<div class="alert alert-danger">You Have To Choose <strong> City </strong></div>';
    }
	if(empty($imgName)){
		$formErrors[]= '<div class="alert alert-danger"><strong>No Image </strong></div>';
	}
	if(! in_array($lastElement, $extensionAllowed)){
	$formErrors[]= '<div class="alert alert-danger">This Extension Of Image Not <strong> Allowed </strong></div>';
}
	if($imgSize > 4194304){
		$formErrors[]= '<div class="alert alert-danger">Image is too <strong> big  </strong></div>';
	}
foreach ($formErrors as $Msg) {
	redirect($Msg,'back',5);
}

if(empty($formErrors)){

	$image = rand(0,100000) . '_' . $imgName;

	$path= "admin\upload\\". $image;
	
	move_uploaded_file($_FILES['img']['tmp_name'],$path);

	
	$insert=$connect->prepare("INSERT INTO items(Name,Description,Price,Date, City,img, Cat_ID,Member_ID)
		VALUES(:zname, :zdesc, :zprice, now(),:zcity, :zimg, :zcat, :zmember )");
	$insert->execute(array(
	'zname'  =>$name,
	'zdesc'  =>$desc,
	'zprice' =>$price,		
	'zcity' =>	$city,
	'zimg'   =>$image,
	'zcat'   =>$cat_ID,
	'zmember'=>$Member_ID));
	$count=$insert->rowcount();
	$Msg="<div class='alert alert-success'>" . $count . '<strong>Item Added </strong></div>' ;
	redirect($Msg,'my_items.php',5);
}	


 } elseif ($do== 'edit') {
 	

$itemID=$_GET['itemid'];
$stmt2=$connect->prepare("SELECT * FROM items where ID=?");
$stmt2->execute(array($itemID));
$fetch=$stmt2->fetch();
	
?>
	<div calss="container">
	<form class="form-horizontal" action="my_items.php?do=update" method="POST" enctype="multipart/form-data"> <!-- The ecnoded Type for upload File -->

		<input type="hidden" name="itemid" value= <?php echo $itemID ?> />		       
	    <!--name field-->
		 <div class="form-group">
	     <label class="col-sm-2 control-label">Name</label>
         <div class="col-sm-10 col-md-4">
	     <input type="text" name="name" class="form-control" required="required" value=<?php echo $fetch['Name']; ?> 
	      />
         </div>
	     </div>
		 <!-- end name field-->
		
		<!--Description field-->
		 <div class="form-group">
	     <label class="col-sm-2 control-label">Description</label>
         <div class="col-sm-10 col-md-4">
	     <input type="text" name="description" class="form-control" value=<?php echo $fetch['Description']; ?>  />
	     </div>
	     </div>
	    <!-- end Description field-->

		<!--Price field-->
		 <div class="form-group">
	     <label class="col-sm-2 control-label">Price</label>
         <div class="col-sm-10 col-md-4">
	     <input type="text" name="price" class="form-control" required="required" value=<?php echo $fetch['Price']; ?> 
	       />
	     </div>
	     </div>
		<!-- end price field-->

	    <!-- City field-->
	    <div class="form-group">
		<label>City: </label>
		<select class="col-sm" name="city">
		    <option value="Abha"   <?php if ($fetch['City']=='Abha'){echo 'selected' ;} ?>>Abha</option>
		    <option value="Albaha" <?php if ($fetch['City']=='Albaha'){echo 'selected' ;} ?>>Albaha</option>
		    <option value="Dammam" <?php if ($fetch['City']=='Dammam'){echo 'selected' ;} ?>>Dammam</option>
		    <option value="Hafr"   <?php if ($fetch['City']=='Hafr'){echo 'selected' ;} ?>>Hafr Albatin</option>
		    <option value="Jeddah" <?php if ($fetch['City']=='Jeddah'){echo 'selected' ;} ?>>Jeddah</option>
		    <option value="Jizan"  <?php if ($fetch['City']=='Jizan'){echo 'selected' ;} ?>>Jizan</option>
		    <option value="Khobar" <?php if ($fetch['City']=='Khobar'){echo 'selected' ;} ?>>Khobar</option>
		    <option value="Mecca"  <?php if ($fetch['City']=='Mecca'){echo 'selected' ;} ?>>Mecca</option>
		    <option value="Medina" <?php if ($fetch['City']=='Medina'){echo 'selected' ;} ?>>Medina</option>
		    <option value="Najran" <?php if ($fetch['City']=='Najran'){echo 'selected' ;} ?>>Najran</option>
		    <option value="Riyadh" <?php if ($fetch['City']=='Riyadh'){echo 'selected' ;} ?>>Riyadh</option>
		    <option value="Taif"   <?php if ($fetch['City']=='Taif'){echo 'selected' ;} ?>>Taif</option>
		    <option value="Tabuk"  <?php if ($fetch['City']=='Tabuk'){echo 'selected' ;} ?>>Tabuk</option>
		    <option value="Qassim" <?php if ($fetch['City']=='Qassim'){echo 'selected' ;} ?>>Qassim</option>
		    <option value="Yanbu"  <?php if ($fetch['City']=='Yanbu'){echo 'selected' ;} ?>>Yanbu</option>
		</select>
	    
		<!-- Category field-->
		 
	     <label >Category: </label>
	     <select name="category">
	     <option value="0">...</option>
	     <?php 
	     $stmt2=$connect->prepare("SELECT * FROM categories");
	     $stmt2->execute();
	     $cats=$stmt2->fetchAll();
	     foreach ($cats as $cat) {
	  
			echo "<option value= '" . $cat['ID'] ."'";
			if($cat['ID']==$fetch['Cat_ID']){echo 'selected';} echo ">" . $cat['Name']."</option>";

	       }
	     
	     ?>
	     </select>
	    </div>
	   <input type="submit" value="Update Item" class="btn btn-primary"/> 
        </form>		
    </div>


<?php


} elseif ($do=='update') {
 
echo "<h1 div class='text-center'>Update Items</h1>";
echo "<div class='container'>";


// get variable from form
	$id       =$_POST['itemid'];
	$name     =$_POST['name'];
	$desc     =$_POST['description'];
	$price    =$_POST['price'];
	$city   =$_POST['city'];
	$category =$_POST['category'];
	

	
	$formErrors=array();     // validate the form 
    
	if (empty($name)){
		$formErrors[]= '<div class="alert alert-danger">Name cant be <strong> empty </strong></div>'; }

	if (empty($price)){
		$formErrors[]='<div class="alert alert-danger">Price cant be <strong> empty </strong></div>'; }	
    
	if ($category === 0){
		$formErrors[]='<div class="alert alert-danger">You have to choose <strong>Status </strong></div>'; }		
    
    foreach ($formErrors as $Msg) {
	redirect($Msg,'back',5);
}
//check if there is no error update the database
if(empty($formErrors)){

	// update the database with this Info
	$stmt = $connect->prepare("UPDATE 
		    items 
		SET 
		    Name=?, 
		    Description=?, 
		    Price=?, 
		    City=?,
		    Cat_ID=?
		WHERE ID=? ");
	$stmt->execute(array($name, $desc, $price,$city,$category,$id));
   $count= $stmt->rowcount();

   $Msg="<div class='alert alert-success'>" . $count . 'Item Updated </div>' ;
   redirect($Msg,'my_items.php',5);
       }



} elseif ($do=='delete') {
	

echo "<h1 div class='text-center'>Delete Items</h1>";
    echo "<div class='container'>";

	// check if itemid is numeric
		$itemid= isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0; 


		$stmt= $connect->prepare(" SELECT * FROM  items where ID= {$itemid} ");
		$stmt->execute();
		$check=$stmt->rowcount();
		// if the id exist
		  
		 if($check > 0){ 
		 $stmt=$connect->prepare("DELETE FROM items WHERE ID= ?");
	     $stmt-> execute(array($itemid));
		
		$Msg = "<div class='alert alert-success'>" . $stmt->rowcount() . 'Item deleted </div>' ;
		redirect($Msg,'back',5);
		}

		else{

		echo '<div class="alert alert-danger">This id is not exist</div>';
		}


} 
}else {
header('Location:homepage.php');
exit();
} 