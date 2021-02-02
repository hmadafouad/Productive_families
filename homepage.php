<?php

session_start();
include 'include.php';

$do='';

if (isset($_GET['do'])){

    $do=$_GET['do'];

} else {

$do='manage'; }

if($do=='manage'){ ?>

<h1 class="text-center"> <strong>Productive Families Area</strong></h1>

<div class="container cat">
    <div class="row">
  <div class="col-sm"><h1>Drinks</h1>
        <a href="homepage.php?do=drinks"><img src="image/drinks.png"/></a></div>
  <div class="col-sm"><h1>Cooking</h1>
        <a href="homepage.php?do=cooking"><img src="image/coock.png"/></a></div>
  <div class="col-sm"><h1>Desserts</h1>
        <a href="homepage.php?do=dessert"><img src="image/dessert.png"/></a></div>
   </div>

<div class="row rows">
  <div class="col-sm-4"><h1 class="title">Accessories</h1>
        <a href="homepage.php?do=accessories" class="acce"><img src="image/accessories.jpg"/></a></div>
  <div class="col-sm-4 knit"><h1>Knitting</h1>
        <a href="homepage.php?do=Knitting"><img src="image/Knitting.jpg"/></a></div>
</div>

</div>


<!-- Footer -->
<footer class="page-footer font-small black">
  <!-- Copyright -->
  <div class="footer-copyright text-center py-3">© 2019 Copyright: PFA
  </div>
  <!-- Copyright -->

</footer>
<!-- Footer -->

<?php

}elseif ($do=='cooking') {

if (isset($_POST["city"]) && $_POST['city']!='All' )
{
$city =$_POST["city"];
$stmt=$connect->prepare("SELECT * FROM items where City ='$city' AND Cat_ID=1");
$cooking=$stmt->rowCount();  

}else
    $stmt=$connect->prepare("SELECT * FROM items WHERE Cat_ID=1");
    $stmt->execute();
    $cooking=$stmt->fetchAll();

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
    echo '<div class="container">';
    echo '<div class="row">';   
    foreach ($cooking as $cook) {    
    echo '<div class="col-sm-6 col-md-4">';
    echo '<div class="thumbnail item-box">';
       echo "<img src='admin/upload/" . $cook['img']."'/>";
    echo '<div class="caption">';
        echo "<a href='items.php?do=disp&itemid=".$cook['ID']."'><h3>" . $cook['Name']  .       "</a></h3>";
        echo '<p><i class="fas fa-tag"> '   . $cook['Price'] ." SR" .  '</i></p>';
        echo '<p><i class="fas fa-map-marker-alt"> ' . $cook['City']  .       '</i></p>';
            
    echo '</div>';    
    echo '</div>';
    echo '</div>';
    }
    echo '</div>';
    echo '</div>';



}elseif ($do=='dessert') {

if (isset($_POST["city"]) && $_POST['city']!='All' )
{
$city =$_POST["city"];
$stmt=$connect->prepare("SELECT * FROM items where City ='$city' AND Cat_ID=2");
$cooking=$stmt->rowCount();  

}else
    $stmt=$connect->prepare("SELECT * FROM items WHERE Cat_ID=2");
    $stmt->execute();
    $cooking=$stmt->fetchAll();

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
    echo '<div class="container">';
    echo '<div class="row">';   
foreach ($cooking as $cook) {
    echo '<div class="col-sm-6 col-md-4">';
    echo '<div class="thumbnail item-box">';
        echo "<img src='admin/upload/" . $cook['img']."'/>";       
    echo '<div class="caption">';
        echo "<a href='items.php?do=disp&itemid=".$cook['ID']."'><h3>" . $cook['Name']  .       "</a></h3>";
        echo '<p><i class="fas fa-tag"> '   . $cook['Price'] ." SR" .  '</i></p>';
        echo '<p><i class="fas fa-map-marker-alt"> ' . $cook['City']  .       '</i></p>';
            
            
    echo '</div>';    
    echo '</div>';
    echo '</div>';
    }
    echo '</div>';
    echo '</div>';



}elseif ($do=='accessories') {

if (isset($_POST["city"]) && $_POST['city']!='All' )
{
$city =$_POST["city"];
$stmt=$connect->prepare("SELECT * FROM items where City ='$city' AND Cat_ID=3");
$cooking=$stmt->rowCount();  

}else
    $stmt=$connect->prepare("SELECT * FROM items WHERE Cat_ID=3");
    $stmt->execute();
    $cooking=$stmt->fetchAll();


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
    
    echo '<div class="container">';
    echo '<div class="row">';   
foreach ($cooking as $cook) {
    echo '<div class="col-sm-6 col-md-4">';
    echo '<div class="thumbnail item-box">';
        echo "<img src='admin/upload/" . $cook['img']."'/>";
    echo '<div class="caption">';
        echo "<a href='items.php?do=disp&itemid=".$cook['ID']."'><h3>" . $cook['Name']  .       "</a></h3>";
        echo '<p><i class="fas fa-tag"> '   . $cook['Price'] ." SR" .  '</i></p>';
        echo '<p><i class="fas fa-map-marker-alt"> ' . $cook['City']  .       '</i></p>';
            
    echo '</div>';
    echo '</div>';
    echo '</div>';    
      }
    echo '</div>';
    echo '</div>';



}elseif ($do=='Knitting') {

if (isset($_POST["city"]) && $_POST['city']!='All' )
{
$city =$_POST["city"];
$stmt=$connect->prepare("SELECT * FROM items where City ='$city' AND Cat_ID=4 ");
$cooking=$stmt->rowCount();  

}else
    $stmt=$connect->prepare("SELECT * FROM items WHERE Cat_ID=4");
    $stmt->execute();
    $cooking=$stmt->fetchAll();
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
  
    echo '<div class="container">';
    echo '<div class="row">';  
foreach ($cooking as $cook) {
    echo '<div class="col-sm-6 col-md-4">';
    echo '<div class="thumbnail item-box">';
        echo "<img src='admin/upload/" . $cook['img']."'/>";
    echo '<div class="caption">';
        echo "<a href='items.php?do=disp&itemid=".$cook['ID']."'><h3>" . $cook['Name']  .       "</a></h3>";
        echo '<p><i class="fas fa-tag"> '   . $cook['Price'] ." SR" .  '</i></p>';
        echo '<p><i class="fas fa-map-marker-alt"> ' . $cook['City']  .       '</i></p>';  
    echo '</div>';    
    echo '</div>';
    echo '</div>';
         }
    echo '</div>';    
    echo '</div>';



}elseif ($do=='drinks') {
   
if (isset($_POST["city"]) && $_POST['city']!='All' )
{
$city =$_POST["city"];
$stmt=$connect->prepare("SELECT * FROM items where City ='$city' AND Cat_ID=5");
$cooking=$stmt->rowCount();  

}else
    $stmt=$connect->prepare("SELECT * FROM items WHERE Cat_ID=5");
    $stmt->execute();
    $cooking=$stmt->fetchAll();

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
    echo '<div class="container">';
    echo '<div class="row">';   
    foreach ($cooking as $cook) {
    echo '<div class="col-sm-6 col-md-4">';
    echo '<div class="thumbnail item-box">';
        echo "<img src='admin/upload/" . $cook['img']."'/>";
    echo '<div class="caption">';
        echo "<a href='items.php?do=disp&itemid=".$cook['ID']."'><h3>" . $cook['Name']  .       "</a></h3>";
        echo '<p><i class="fas fa-tag"> '   . $cook['Price'] ." SR" .  '</i></p>';
        echo '<p><i class="fas fa-map-marker-alt"> ' . $cook['City']  .       '</i></p>';  
    echo '</div>';    
    echo '</div>';
    echo '</div>';
        }
    echo '</div>';
    echo '</div>';
?>

<?php
}else{
    header('Location:categories.php');
}

