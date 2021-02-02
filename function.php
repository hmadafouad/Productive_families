<?php 


function countItem($item,$table,$where=null){
global $connect;
$stmt=$connect->prepare("SELECT COUNT($item) FROM $table $where");
$stmt->execute();

return $stmt->fetchColumn();

}


/* Redirect Function 
** Function accept parameters
** $Msg = Echo the message[error|secces|warning]
** $url = The Link you want to direct to
** $seconds = seconds before redirecting
*/
function redirect($Msg, $url=null, $seconds=3){
if($url === null){
	$url= 'homepage.php';
	$link= 'Homepage' ;
}elseif($url!=null && $url!='back'){
	$link=$url;
}else{
		if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ''){
			$url=$_SERVER['HTTP_REFERER'];
			$link= 'Previous Page';	
		}else{
	      $url='homepage.php';
	      $link= 'Homepage' ;
			}
	
   }
echo $Msg;
echo "<div class='alert alert-info text-center'>you will be redirected to $link after $seconds Seconds.</div>";
header("refresh:$seconds;url=$url");
exit();

}