<?php
require_once('config/config.php');
mysqli_select_db($conn,'signer');

$id = @$_GET['id'];
$row = delete($id,$conn);
if($row>=1){
    alert("delete success!");
}else{
    alert("error!");
}
href("delete.php");
function delete($id,$conn){
    $sql = "delete from users where id='$id'";
    mysqli_query($conn,$sql);
    $rows= mysqli_affected_rows($conn);
    return $rows;
}
function alert($title){
    echo "<script type='text/javascript'>alert('$title');</script>";
}
function href($url){
    echo "<script type='text/javascript'>window.location.href='$url'</script>";
}
?>