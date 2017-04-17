<?php
/**
 * Created by PhpStorm
 * User: kyosin
 * Date: 2017/4/15
 * Time: 16:20
 */
require_once('config/config.php');
mysqli_select_db($conn,'signer');
ob_start();



echo "<table width='1200px' align='center'; style='text-align:center;margin-top:50px;;color:black'border='3'>
                <tr>
                    <th style='text-align:center;'>Icon</th>
                    <th style='text-align:center;'>UserID</th>
                    <th style='text-align:center;'>Username</th>
                    <th style='text-align:center;'>sign in time</th>
                    <th style='text-align:center;'>state</t>
                </tr>";
$rst = mysqli_query($conn,"select * from logs order by id asc");
$userList[] = array();
while(@$row1 = mysqli_fetch_array($rst)){
    $userList[]= $row1;
}
if(is_array($userList) && !empty($userList)) {
//    $i=0;

    foreach ($userList as $user) {

//        if($i>0){
            echo "<tr>";
            echo "<td>" . "<img alt='icon' src='{$user[5]}'" . "</td>";
            echo "<td>" . $user[1] . "</td>";
            echo "<td>" . $user[2] . "</td>";
            echo "<td>" . $user[3] . "</td>";
            echo "<td>" . $user[4] . "</td>";
            echo "</tr>";
//        }
    }
//    $i++;
}

