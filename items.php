<?php
session_start();
include 'include.php'; 

$do='';

if (isset($_GET['do'])){

	$do=$_GET['do'];

} else {

$do='manage'; }


// Profile Page (First Page in Items Page)
if($do=='manage'){

	
if (isset($_POST["city"]) && $_POST['city']!='All' )
{
$city =$_POST["city"];
$select=$connect->prepare("SELECT * FROM items where City ='$city'");
$count=$select->rowCount();  

}else
$select=$connect->prepare("SELECT * FROM items");
$select->execute();	

?>
<!-- FILTER -->
<div class="row">
	<div class="col-sm">
       	<div class="text-center color">
            <form method="post" action="" >
                <label><strong> Choose city: </strong></label>
                    <select  name="city" class="select">
                                <option >All</option>
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
<div class="row">
    <div class="col">
        <button type="submit" class="btn-primary search">
            <i class="fa fa-search"></i>Search</button>
                  
    </div>
</div>
            </form>         
         </div>
    </div>
</div>
            
            <!-- END FILTER -->

<?php


echo '<div class="container items">';
echo '<div class="row">';	

foreach ($select as $sel) {

echo '<div class="col-sm-6 col-md-4">';
		echo '<div class="thumbnail item-box">';
		echo "<img src='admin/upload/" . $sel['img']."'/>";
		echo '<div class="caption border">';
			echo "<a href='items.php?do=disp&itemid=".$sel['ID']."'><h3>" . $sel['Name']  .       "</a></h3>";
		    echo '<p><i class="fas fa-tag"> '   . $sel['Price'] ." SR" .  '</i></p>';
		    echo '<p><i class="fas fa-map-marker-alt"> ' . $sel['City']  .       '</i></p>';
		    
		    
		echo '</div>';    
		echo '</div>';
echo '</div>';
}
echo '</div>';
echo '</div>';




// Profile Page (Second Page in Items Page)
}elseif ($do=='disp') {

echo '<div class="container disp">';
//SELECT * FROM items WHERE ID='$itemID'
$itemID=$_GET['itemid'];
$select=$connect->prepare("SELECT 
			items.* ,categories.Name as Cat_Name , users.Name as User_Name , users.Phone as User_Phone, users.Instagram as User_Insta
				FROM 
				   items 
				INNER JOIN 
				   categories
				ON 
				   categories.ID = items.Cat_ID
				INNER JOIN 
				   users
				ON
				   users.ID = items.Member_ID
				 
				WHERE 
				   items.ID='$itemID' ");
$select->execute();	
foreach ($select as $sele) {


echo '<div class="container cont">';

  echo '<div class="row">';
    echo '<div class="col-3">';
      echo '<img class="image" src="admin/upload/' . $sele['img'].' "/>';
    echo '</div>';


    echo '<div class="col">';  
  	  echo '<div class="info">';  	
        	echo '<strong><h1>'.$sele['Name']. '</h1></strong>';
        	 echo $sele['Description'];
		    echo '<p><i class="fas fa-tag"> '   . $sele['Price'] ." SR" .  '</i></p>';
		    echo '<p><i class="fas fa-map-marker-alt"> ' . $sele['City']  .       '</i></p>';
		    echo '<strong><p>'.'Category: ' .$sele['Cat_Name']. '</p></strong>';
		    echo '<strong><p>'.'Seller: ' . '<a href="items.php?do=profile&id='.$sele['Member_ID'].'">'. $sele['User_Name'].'</a>'. '</p></strong>';
		    echo '<strong><p> <i class="fab fa-instagram "> ' . $sele['User_Insta']. '</i></p></strong>';
		    if($sele['User_Phone'] != 0){
		    	echo '<strong><p> <i class="fab fa-whatsapp "> ' . $sele['User_Phone']. '</i></p></strong>';
		    }

echo '<div class="row rate">';		    



// Rating Code
echo 'Rate this item: ';
foreach (range(1, 5 )as $rating) {
		echo ' <a class="star" href="rate.php?itemid='.$sele['ID'].'&rating=' . $rating .'" >'.
		'<i class="far fa-star">' .'</i></a>';
	}


// To Count Number of Rating
$rate=$connect->prepare("SELECT AVG(Rating) as rating, count(Rating) as Count
	FROM rating 
	WHERE Item_ID={$itemID} ");
$rate->execute();

foreach ($rate as$ra) {
	echo '<span class="col-3">' .'(' .$ra['Count'].')'.'</span>';
echo '</div>';	

	echo '<div><strong><i class="far fa-star"> '. ' Rating:'.round($ra['rating']).'/5' . '</i></strong>';
}


	  echo '</div>'; 
    echo '</div>';
  
  echo '</div>';
   echo '</div>';     	     	
}

echo '</div>';




// Profile Page (Third Page in Items Page)
}elseif ($do=='profile') {

$id=$_GET['id'];	
$getUser=$connect->prepare("SELECT * FROM users WHERE ID = {$id} ");
$getUser->execute();
$info=$getUser->fetch();
?>

<h1 class="text-center"><?php echo $info['Name']; ?> Profile</h1>
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
			
			<div><i class="fas fa-ad"><span> Number of Items   </span>: <?php echo countItem('ID','items','where Member_ID='.$info['ID'].'') ?> </i>  </div>
			<div><i class="fas fa-calendar-alt">  <span>  Registered Date </span>: <?php echo $info['Date'];?> </i>   </div>
    
			
		</div>
	</div>




<?php

}