<?php
/**
 * Created by PhpStorm
 * User: kyosin
 * Date: 2017/2/20
 * Time: 16:19
 */
$servername = "127.0.0.1";
$username = "signer";
$password = "signer";
$dbname = "signer";
//创建连接
$conn = new mysqli($servername,$username,$password,$dbname);
//检测连接
if($conn->connect_error){
    die("connecting error:".$conn->connect_error);
}

?>
