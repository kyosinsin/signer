<?php
require_once('config/config.php');
mysqli_select_db($conn,'signer');

$id = @$_GET['userid'];
echo $id;
$row = delete($id,$conn);
if($row>=1){
    alert("error");
}else{
    alert("delete success");
}
href("delete.php");
function delete($id,$conn){
    $sql = "delete from users where userid='$id'";
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