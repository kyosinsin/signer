<?php
//phpinfo();        //获取php信息
//require_once('config/config.php');
//mysqli_select_db($conn,'signer');
date_default_timezone_set('Asia/Tokyo');

//$sql = "select sign_time count(*) as cnt from logs where yearweek(date_format(sign_time,'%Y-%m-%d')) = yearweek(now())-1";

//$res = mysqli_query($conn,"select count(*) as cnt from logs where YEARWEEK(date_format(login_time,'%Y-%m-%d')) = YEARWEEK(now())-1");
//$row = mysqli_fetch_assoc($res);
//echo $row['cnt'];
//$rate = round($row_2['cnt2']/$row_1['cnt1']*100,0);
//echo $rate."%";
//$lastSunday = date("Y-m-d",strtotime("Sunday previous week"));
//$lastMonday = date("Y-m-d",strtotime("Monday previous week"));
//$lastSunday = date("Y-m-d",strtotime("-1 week Monday"));
//$lastMonday=date("Y-m-d",strtotime("-1 week Sunday"));
//$lastMonday = strtotime("2017-05-15");
//$lastSunday = strtotime("2017-05-21");
//if($result = mysqli_query($conn,"select * from logs where date_format(sign_time,'%Y-%m-%d') <= date_format($lastSunday,'%Y-%m-%d')
//and date_format(sign_time,'%Y-%m-%d') >= date_format($lastMonday,'%Y-%m-%d')")){
//print_r($result);
//    $count = mysqli_num_rows($result);
//    echo $count."<br>";
//}else{
//    echo "empty"."<br>";
//}
//echo "Monday:".$lastMonday. '<br>';
//
//echo "Sunday:".$lastSunday;

//echo date($endLastweek);
//echo date("Y-m-d",strtotime("-1 week Monday")), "<br />"; //离现在最近的周一
//echo date("Y-m-d",strtotime("-1 week Sunday")), "<br />"; //离现在最近的周末

$date_time = date("H:i:s");
$m_start = date("17:00:00");
$day_end = date("24:00:00");
if($date_time > $m_start && $date_time < $day_end){
    echo "<script>alert('Now maintaining')</script>";
}else{

}

?>
