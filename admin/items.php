<?php
session_start();
if(isset($_SESSION['admin'])){
include 'include.php'; 



$do='';

if (isset($_GET['do'])){

	$do=$_GET['do'];

} else {

$do='manage'; }

if($do=='manage'){

$select=$connect->prepare("SELECT items.* ,
	categories.Name as Cat_Name ,
	users.Name as User_Name,
	users.City as City_Item  
	FROM 
	   items 
	INNER JOIN 
	   categories
	ON 
	   categories.ID = items.Cat_ID
	INNER JOIN 
	   users
	ON
	   users.ID = items.Member_ID");
$select->execute();	
$items=$select->fetchAll();
?>
<h1 class="text-center">Manage Items</h1>
    <div class="container">
        <div class="table-responsive">
            <table class="main-table text-center table table-bordered">
            <tr>
                <td>#ID</td>
                <td>Name</td>
                <td>Image</td>
                <td>City</td>
                <td>Description</td>
                <td>Price</td>
                <td>Adding Date</td>
                <td>Classification</td>
                <td>Username</td>
                <td>Control</td>
            </tr>   
<?php           
foreach ($items as $item) {
            echo "<tr>";
                echo "<td>" . $item['ID']. "</td>" ;
                echo "<td>" . $item['Name']. "</td>" ;
                echo "<td><img src='upload/".$item['img']."'/></td>" ;
                echo "<td>" . $item['City_Item']. "</td>" ; 
                echo "<td>" . $item['Description']. "</td>" ; 
                echo "<td>" . $item['Price']." SR" . "</td>" ;
                echo "<td>" . $item['Date']. "</td>" ;
                echo "<td>" . $item['Cat_Name']. "</td>" ;
                echo "<td>" . $item['User_Name']. "</td>" ;
                echo "<td>
                <a href='items.php?do=edit&itemid=".$item['ID']."' class='btn btn-success'><i class='fas fa-edit'></i>Edit</a> 
                <a href='items.php?do=delete&itemid=".$item['ID']."' class='confirm btn btn-danger'><i class='fas fa-times'></i>Delete</a>
                </td>";
            echo "<tr>";
    }
echo '</table>';
echo '</div>';
echo '</div>';
echo "<div class='text-center'><a href='items.php?do=add' class='btn btn-primary add'><i class='fas fa-plus edit'></i>Add Items</div></a>"; 

}elseif ($do=='add') { ?>

<div calss="container">
	<form class="form-horizontal" action="items.php?do=insert" method="POST" enctype="multipart/form-data"> <!-- The ecnoded Type for upload File -->
			       
	    <!--name field-->
		 <div class="form-group">
	     <label class="col-sm-2 control-label">Name</label>
         <div class="col-sm-10 col-md-4">
	     <input type="text" name="name" 
	      class="form-control" required="required" />
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
	     <select name="category">
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

		<!-- Image field-->
		<input type="file" name="img" required="" />

	    
        <input type="submit" value="Add Item" class="btn btn-primary"/> 
        </form>		
    </div>
<?php 
}elseif ($do=='insert') {

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
	 
	$img       = $_FILES['img'];
	$cat_ID =   $_POST['category']  ;	 
	$Member_ID= $_SESSION['id'];			   

// Make sure No Errors in the form
	$formErrors= array();
	if($cat_ID==0){
		$formErrors[]= '<div class="alert alert-danger text-center">You Have To Choose <strong>Category </strong></div>';
	}
	if(! in_array($lastElement, $extensionAllowed)){
	$formErrors[]= '<div class="alert alert-danger text-center">This Extension Of Image Not <strong> Allowed </strong></div>';
}
	if(empty($imgName)){
		$formErrors[]= '<div class="alert alert-danger text-center"><strong>No Image </strong></div>';
	}
	if($imgSize > 4194304){
		$formErrors[]= '<div class="alert alert-danger text-center">Image is too <strong> big  </strong></div>';
	}
foreach ($formErrors as $Msg) {
	redirect($Msg,'back',5);
}

if(empty($formErrors)){

	$image = rand(0,100000) . '_' . $imgName;

	$path= "upload\\". $image;
	
	move_uploaded_file($_FILES['img']['tmp_name'],$path);

	
	$insert=$connect->prepare("INSERT INTO items(Name,Description,Price,Date, img, Cat_ID, Member_ID)
		VALUES(:zname, :zdesc, :zprice, now(),  :zimg, :zcat, :zuid )");
	$insert->execute(array(
	'zname'  =>$name,
	'zdesc'  =>$desc,
	'zprice' =>$price,		
	
	'zimg'   =>$image,
	'zcat'   =>$cat_ID,
    'zuid'   =>$Member_ID));
	$count=$insert->rowcount();
	$Msg="<div class='alert alert-success text-center'>" . $count . '<strong>Item Added </strong></div>' ;
	redirect($Msg,'items.php',5);
}	


}elseif ($do=='edit') { 

$itemID=$_GET['itemid'];
$stmt2=$connect->prepare("SELECT * FROM items where ID=?");
$stmt2->execute(array($itemID));
$fetch=$stmt2->fetch();	


?>
	<div calss="container">
	<form class="form-horizontal" action="items.php?do=update" method="POST" enctype="multipart/form-data"> <!-- The ecnoded Type for upload File -->

		<input type="hidden" name="itemid" value= <?php echo $itemID ?> />		       
	    <!--name field-->
		 <div class="form-group">
	     <label class="col-sm-2 control-label">Name</label>
         <div class="col-sm-10 col-md-4">
	     <input type="text" name="name" class="form-control" 
	     required=""
	      value=<?php echo $fetch['Name']; ?>  />
         </div>
	     </div>
		 <!-- end name field-->
		
		<!--Description field-->
		 <div class="form-group">
	     <label class="col-sm-2 control-label">Description</label>
         <div class="col-sm-10 col-md-4">
	     <input type="text" name="description" class="form-control" value=<?php echo $fetch['Description']; ?> />
	     </div>
	     </div>
	    <!-- end Description field-->

		<!--Price field-->
		 <div class="form-group">
	     <label class="col-sm-2 control-label">Price</label>
         <div class="col-sm-10 col-md-4">
	     <input type="text" name="price" class="form-control" value=<?php echo $fetch['Price']; ?> required="required"  />
	     </div>
	     </div>
		<!-- end price field-->

	    <!-- City field-->
	    
	    	<div class="row">
		<select name="city">
		    <option value="city">City</option>
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
	     
	     <select name="category">
	     <option value="0">Category</option>
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
	 	
<!--Member field-->
         
	     <select name="member">
	     <option value="0">Member</option>
	     <?php 
	     $stmt=$connect->prepare("SELECT * FROM users");
	     $stmt->execute();
	     $users=$stmt->fetchAll();
	     foreach ($users as $user) {
	  
echo "<option value= '" . $user['ID'] ."'";
		 if ($user['ID']==$fetch['Member_ID']){echo 'selected' ;} 
		echo">" .  $user['Name']."</option>";
	     }
	     ?>
	     </select>
	    
		

		</div>
	   
		<div class="form-group butt">
        <input type="submit" value="Save" class="btn btn-primary"/> 
         </div>
        </form>		
   


<?php
}elseif ($do=='update') {
echo "<h1 div class='text-center'>Update Item</h1>";
echo "<div class='container'>";

if($_SERVER['REQUEST_METHOD']=='POST'){

// get variable from form
	$id       =$_POST['itemid'];
	$name     =$_POST['name'];
	$desc     =$_POST['description'];
	$price    =$_POST['price'];
	$city   =$_POST['city'];
	$category =$_POST['category'];
	$member_ID =$_POST['member'];

	
	$formErrors=array();     // validate the form 
    
	if (empty($name)){
		$formErrors[]= '<div class="alert alert-danger text-center">Name cant be <strong> empty </strong></div>'; }

	if (empty($price)){
		$formErrors[]='<div class="alert alert-danger text-center">Price cant be <strong> empty </strong></div>'; }	
    
	if ($category == 0){
		$formErrors[]='<div class="alert alert-danger text-center">You have to choose <strong> Category </strong></div>'; }		
    
    if ($member_ID == 0){
		$formErrors[]='<div class="alert alert-danger text-center">You have to choose <strong>Member</strong></div>'; }

	if ($city == 'city'){
		$formErrors[]='<div class="alert alert-danger text-center">You have to choose <strong>City </strong></div>'; }
    foreach ($formErrors as $Msg) {
	redirect($Msg,'back',4);
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
		    Cat_ID=?,
		    Member_ID=?
		WHERE ID=? ");
	$stmt->execute(array($name, $desc, $price,$city,$category,$member_ID,$id));
   $count= $stmt->rowcount();
  
   $Msg= "<div class='alert alert-success text-center'>" . $count . 'Item Updated </div>' ;
   redirect($Msg,'items.php',5);
    }
}
}elseif ($do=='delete') {

	
echo "<h1 div class='text-center'>Delete Items</h1>";
    echo "<div class='container'>";

	// check if itemid is numeric
		$itemid= isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0; 


		$stmt= $connect->prepare(" SELECT * FROM  items where ID= ? ");
		$stmt->execute(array($itemid));

		$check=$stmt->rowcount();
		
		
		// if the id exist
		  
		 if($check > 0){ 
		 $stmt=$connect->prepare("DELETE FROM items WHERE ID= ?");
	     $stmt-> execute(array($itemid));
		
		$Msg="<div class='alert alert-success text-center'>" . $stmt->rowcount() . 'record deleted </div>' ;
		redirect($Msg,'back',3);
		}

		else{

		echo '<div class="alert alert-danger text-center">This id is not exist</div>';
		}


}
}else{
	header('Location:login.php');
}
