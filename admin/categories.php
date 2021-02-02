<?php
session_start();
include 'include.php';
if(isset($_SESSION['admin'])){



$do='';

if (isset($_GET['do'])){

    $do=$_GET['do'];


} else {

$do='manage'; }

if($do=='manage'){
    $stmt=$connect->prepare("SELECT * FROM categories");
    $stmt->execute();
    $cats=$stmt->fetchAll();
    
?>
<h1 class="text-center">Manage Categories</h1>
    <div class="container">
        <div class="table-responsive">
            <table class="main-table text-center table table-bordered">
            <tr>
                <td>#ID</td>
                <td>Name</td>
                <td>Number of Items</td>
                <td>Control</td>
            </tr>   
<?php           
foreach ($cats as $cat) {
            echo "<tr>";
                echo "<td>" . $cat['ID']. "</td>" ;
                echo "<td>" . $cat['Name']. "</td>" ;
                echo "<td>" . countItem('ID','items','where Cat_ID='.$cat['ID'].''). "</td>" ;
                echo "<td>
                <a href='categories.php?do=edit&catid=".$cat['ID']."' class='btn btn-success'><i class='fas fa-edit'></i>Edit</a> 
                <a href='categories.php?do=delete&catid=".$cat['ID']."' class='confirm btn btn-danger'><i class='fas fa-times'></i>Delete</a>
                </td>";
            echo "<tr>";
    }
echo '</table>';
echo '</div>';
echo '</div>';

echo "<div class='text-center'><a href='categories.php?do=add' class='btn btn-primary add'><i class='fas fa-plus edit'></i>Add Category</a></div>"; 



} elseif ($do== 'add') { ?>
    
    <h1 class="text-center">Add New Category</h1>
        <div calss="container">
             <form class="form-horizontal" action="categories.php?do=insert" method="POST">
                   
                
                 <!--name field-->
                 <div class="form-group">
                    <label class="col-sm-2 control-label">Name</label>
                     <div class="col-sm-10 col-md-4">
                      <input type="text" name="name" class="form-control"autocomplete="off" required="required" />
                     </div>
                  </div>
                <!-- end name field-->
                
               <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" value="Add Category" class="btn btn-primary "/>
               </div>
 
  </form>       
    </div>
    <?php 


} elseif ($do=='insert') {

    if($_SERVER['REQUEST_METHOD']=='POST'){
        echo "<h1 div class='text-center'> Insert Category</h1>";
        echo "<div class='container'>";

        $name=$_POST['name'];
        $stmt=$connect->prepare("SELECT Name FROM categories WHERE Name=?");
        $stmt->execute(array($name));
        $check= $stmt->rowcount();
        if($check == 1){
        $Msg='<div class="alert alert-danger text-center">Sorry this category is exist</div>';
        redirect($Msg,'back',5);
        }else{

        $stmt=$connect-> prepare("INSERT INTO 
            categories(Name) VALUES(:zname)");

        $stmt-> execute(array('zname' =>$name ));

        $count=$stmt->rowcount();

        $Msg= "<div class='alert alert-success text-center'>" . $count . 'category Added </div>' ;
        redirect($Msg,'categories.php',5);
        }


    }
 } elseif ($do== 'edit') {

$catid= isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0; 
$stmt= $connect->prepare(" SELECT * FROM  categories where ID= ? ");
$stmt->execute(array($catid));

// fetch data
$cat=$stmt->fetch();
$count= $stmt->rowcount();

// if the id exist
     if($count > 0){ ?>
     <h1 class="text-center">Edit Category</h1>
        <div calss="container">
          <form class="form-horizontal" action="categories.php?do=update" method="POST">
               
                <input type="hidden" name="catid" value="<?php echo $catid?>"/>        
                 <!--name field-->
                 <div class="form-group">
                    <label class="col-sm-2 control-label">Name</label>
                     <div class="col-sm-10 col-md-4">
                      <input type="text" name="name" class="form-control" required="required" value="<?php echo $cat['Name']; ?>" />
                     </div>
                  </div>
                <!-- end name field-->
    
               <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" value="Save" class="btn btn-primary"/>
               </div>
 
  </form>       
    </div>
    
  <?php } else {
  
    echo "<div class='container'>";
    echo '<div class="alert alert-danger">there is no such ID </div>';
    echo "</div>";

  }
   

} elseif ($do=='update') {

echo "<h1 div class='text-center'>Update Category</h1>";
echo "<div class='container'>";

if($_SERVER['REQUEST_METHOD']=='POST'){
// get variable from form
    $id       =$_POST['catid'];
    $name     =$_POST['name'];

    // update the database with this Info
    $stmt = $connect ->prepare("UPDATE
           categories 
        SET 
           Name=? WHERE ID=? ");
    $stmt-> execute(array($name,$id));
    $count= $stmt->rowcount();
   $Msg="<div class='alert alert-success text-center'>" . $count . 'record updated </div>' ;
     redirect($Msg,'categories.php',5);    

} else {

     echo '<div class="alert alert-danger">sorry you cant browse this page directly</div>';
    
} 
 echo "</div>";


} elseif ($do=='delete') {

echo "<h1 div class='text-center'>Delete Category</h1>";
    echo "<div class='container'>";

    // check if userid is numeric
        $catid= isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0; 


        $stmt= $connect->prepare(" SELECT * FROM  categories where ID= ? ");
        $stmt->execute(array($catid));
        $check=$stmt->rowcount();
        
        // if the id exist
         if($check > 0){ 
         $stmt=$connect->prepare("DELETE FROM categories WHERE ID= ?");
         $stmt-> execute(array($catid));
        
        $Msg="<div class='alert alert-success text-center'>" . $stmt->rowcount() . 'Category deleted </div>' ;
        redirect($Msg,'categories.php',5); 
        }

        else{
       echo '<div class="alert alert-danger text-center">This id is not exist</div>';
        }
        
        echo '</div>';


} 
}
else {
header('Location:login.php');
exit();
} 



