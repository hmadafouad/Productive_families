<?php
session_start();
include 'include.php'; 

if(isset($_SESSION['admin'])){


?>

<div class="container text-center home-stats">
	<h1 class="dash">Dashboard</h1>
	<div class="row">
		<div class="col-sm">
			<div class="stat members">Total Members
			<span><a href="members.php"><?php echo countItem('ID','users','') ?> </a></span>	
			</div>
		</div>
		<div class="col-sm">
			<div class="stat categories">Total Categoreis
			<span><a href="categories.php"><?php echo countItem('ID','categories','') ?> </a></span>	
			</div>	
		</div>
		<div class="col-sm">
			<div class="stat items">Total Items
			<span><a href="items.php"><?php echo countItem('ID','items','') ?> </a></span>
			</div>
		</div>
			
	</div>
</div>
	

	
<?php 
} else
header('Location:login.php');
exit();

