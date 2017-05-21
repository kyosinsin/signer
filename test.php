<?php
//phpinfo();        //获取php信息
require_once('config/config.php');
mysqli_select_db($conn,'signer');
date_default_timezone_set('Asia/Tokyo');
//
//$sql = 'select count(*) as cnt from logs where user_id = 1';

//$sql = "select sign_time count(*) as cnt from logs where yearweek(date_format(sign_time,'%Y-%m-%d')) = yearweek(now())-1";

//$res = mysqli_query($conn,"select count(*) as cnt from logs where YEARWEEK(date_format(login_time,'%Y-%m-%d')) = YEARWEEK(now())-1");
//$row = mysqli_fetch_assoc($res);
//echo $row['cnt'];
//$rate = round($row_2['cnt2']/$row_1['cnt1']*100,0);
//echo $rate."%";
$lastSunday = date("Y-m-d",strtotime("Sunday previous week"));
$lastMonday = date("Y-m-d",strtotime("Monday previous week"));
//$lastSunday = date("Y-m-d",strtotime("-1 week Monday"));
//$lastMonday=date("Y-m-d",strtotime("-1 week Sunday"));
if($result = mysqli_query($conn,"select sign_time from logs where sign_time>=$lastSunday and sign_time<=$lastMonday")){
   $row_cnt = $result -> num_rows;
    echo $row_cnt;
    echo $lastSunday;
}
//echo date($endLastweek);
//echo date("Y-m-d",strtotime("-1 week Monday")), "<br />"; //离现在最近的周一
//echo date("Y-m-d",strtotime("-1 week Sunday")), "<br />"; //离现在最近的周末
?>
