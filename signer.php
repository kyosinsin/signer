<?php
/**
 * Created by PhpStorm
 * User: kyosin
 * Date: 2017/2/20
 * Time: 16:16
 */
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <!--兼容IE,设置效果使用的最高版本-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--视口viewport-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>sign in</title>
    <script type="text/javascript" src="js/webcam.js"></script>
    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
        #cam{float:right; width:300px; height:200px;}
        .btn1 {height:28px; line-height:28px; border:1px solid #d3d3d3; margin-top:10px; background:url(images/btn_bg.gif) repeat-x; cursor:pointer}
        #results{margin-top:50px}
    </style>
</head>
<body>
<div style="position:absolute; width:100%; height:100%; z-index:-1; left:0; top:0;">
    <img src="images/bg.jpg" height="100%" width="100%" style="left:0; top:0;">
</div>
<div class="container">
    <div class="row clearfix">
        <div class="col-md-4 column">
            <img alt="system logo" src="images/logo.png" style="margin-top: 50px"/>
        </div>
        <div style="margin-top:60px;" class="col-md-4 column">
            <h1 class="text-center">
                Signer
            </h1>
            <h4>----Reset ALLを押してからsign in----</h4>
            <h4>----sign inは一度で大丈夫!----</h4>
            <h4>----只用登陆一次，否则作废!----</h4>
        </div>
        <div class="col-md-4 column" style="margin-top: 160px">
            <h5>* Turn your sight on camera when you sign in the system </h5>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-md-6 column">
            <form class="form-horizontal" name="form-horizontal" role="form" method="post" action="signer.php" onsubmit="return check()">
                <div class="form-group">
                    <label for="inputUsername3" class="col-sm-2 control-label"><br>NAME</label>
                    <div class="col-sm-5">
                        <br><select class="form-control" name="inputUserID3" id="inputUserID3">
                            <option value="0">名前を選んでね</option>
                            <?php
                            require_once('config/config.php');
                            mysqli_select_db($conn,'signer');
                            $result = mysqli_query($conn,'select * from users');
                            while($row = mysqli_fetch_array($result)) {
                                echo "<option value='{$row['id']}'>{$row['name']}</option>";
                            }
                            ?>
                        </select><br>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default" onclick="take_snapshot()">Sign in</button>
                        <a href="signer.php?action=logout"><button type="button" class="btn btn-default">Reset All</button></a>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-6 column">
            <div id="cam">
                <script language="JavaScript">
                    webcam.set_api_url( 'action.php' );
                    webcam.set_quality( 100 ); // JPEG quality (1 - 100)
                    webcam.set_shutter_sound( false ); // play shutter click sound
                    document.write( webcam.get_html(250, 170, 400,300) );
                </script>

                <script language="JavaScript">
                    webcam.set_hook( 'onComplete', 'my_completion_handler' );

                    function take_snapshot() {
                        // take snapshot and upload to server
                        document.getElementById('results').innerHTML = '<h4>Uploading...</h4>';
                        webcam.snap();
                    }
                    function my_completion_handler(msg) {
                        // extract URL out of PHP output
                        if (msg.match(/(http\:\/\/\S+)/)) {
                            var image_url = RegExp.$1;
                            // show JPEG image in page
                            document.getElementById('results').innerHTML =
                                '<h4></h4>' +
                                '<img src="' + image_url + '">';

                            // reset camera for another shot
                            webcam.reset();
                        }
                        else alert("PHP Error: " + msg);
                    }
                </script>
            </div>
            <div id="results">

            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-md-12 column">
            <?php
            require_once('config/config.php');
            mysqli_select_db($conn,'signer');
            ob_start();

            date_default_timezone_set('Asia/Tokyo');
            if($userid = @$_POST['inputUserID3']) {
                $_SESSION['id']= $_POST['inputUserID3'];
                //检测用户名及密码是否正确
                $result = mysqli_query($conn, "select * from users where id='$userid'limit 1");
                echo "<table width='1200px' align='center'; style='text-align:center;margin-top:50px;;color:black'border='3'>
                <tr>
                    <th style='text-align:center;'>Icon</th>
                    <th style='text-align:center;'>UserID</th>
                    <th style='text-align:center;'>Username</th>
                    <th style='text-align:center;'>sign in time</th>
                    <th style='text-align:center;'>state</t>
                </tr>";
                while ($row = mysqli_fetch_array($result)) {
                        if (@$row['id'] == $userid) {
                            $uid = $row['id'];
                            $uname = $row['name'];
                            $url = 'pic/' . date('YmdHis') . '.jpg';
                            $sql = "INSERT INTO logs (user_id,user_name,pic_url)VALUES('$uid','$uname','$url')";

                            if ($conn->query($sql) === TRUE) {
//                        exit();
                            } else {
                                echo "error: " . $sql . "<br>" . $conn->error;
                            }
                            $rst = mysqli_query($conn, "select * from logs WHERE sign_time>= date(now()) and sign_time<DATE_ADD(date(now()),INTERVAL 1 DAY)");
                            $userList[] = array();
                            while (@$row1 = mysqli_fetch_array($rst)) {
                                $userList[] = $row1;
                            }
                            if (is_array($userList) && !empty($userList)) {
                                $i = 0;
                                foreach ($userList as $user) {
                                    if ($i > 0) {
                                        echo "<tr>";
                                        echo "<td>" . "<img alt='icon' style='width: 160px; height: 120px;' src='{$user[5]}'" . "</td>";
                                        echo "<td>" . @$user[1] . "</td>";
                                        echo "<td>" . @$user[2] . "</td>";
                                        echo "<td>" . @$user[3] . "</td>";
                                        echo "<td>" . @$user[4] . "</td>";
                                        echo "</tr>";
                                    }
                                    $i++;
                                }
                            }
                        }
                    }
//                    if($conn->query($sql) === TRUE){
//                        exit();
//                    }else{
//                        echo "error: ".$sql."<br>".$conn->error;
//                    }
//                    $filename = 'pic/'. date('YmdHis') . '.jpg';
//                    $time = date("Y/m/d H:i:s");
//                    if (!isset($_info['savedate'])){
//                        $_info['savedate'] = array();
//                        array_push($_info['savedate'], array($uid, $uname, $time, $filename));
//                    }else{
//                        array_push($_info['savedate'], array($uid, $uname, $time, $filename));
//                    }
//                    if (is_array($_info['savedate']) && !empty($_info['savedate'])) {
//                        $i = 0;
//                        foreach ($_info['savedate'] as $savedate) {
//                            if ($i >= 0) {
//                                echo "<tr>";
//                                echo "<td>" . "<img alt='icon' src='$savedate[3]'" . "</td>";
//                                echo "<td>" . $savedate[0] . "</td>";
//                                echo "<td>" . $savedate[1] . "</td>";
//                                echo "<td>" . $savedate[2] . "</td>";
//                                echo "<td>" . "in" . "</td>";
//                                echo "</tr>";
//
//                            }
//                            $i++;
//                        }
//                    }
//                    echo "</table>";
//                } else {
//                    echo "error!";
//                }
//
//                    if (!isset($_SESSION['savedate'])) {
//                        $_SESSION['savedate'] = array();
//                        array_push($_SESSION['savedate'], array($row['user_id'], $row['user_name'], $time, $filename));
//                    } else {
//                        array_push($_SESSION['savedate'], array($row['userid'], $row['username'], $time, $filename));
//                    }
//                    if (is_array($_SESSION['savedate']) && !empty($_SESSION['savedate'])) {
//                        $i = 0;
//                        foreach ($_SESSION['savedate'] as $savedate) {
//                            if ($i >= 0) {
//                                echo "<tr>";
//                                echo "<td>" . "<img alt='icon' src='$savedate[3]'" . "</td>";
//                                echo "<td>" . $savedate[0] . "</td>";
//                                echo "<td>" . $savedate[1] . "</td>";
//                                echo "<td>" . $savedate[2] . "</td>";
//                                echo "<td>" . "in" . "</td>";
//                                echo "</tr>";
//
//                            }
//                            $i++;
//                        }
//                    }
//                    echo "</table>";
//                } else {
//                    echo "error!";
//                }
                }

//            if(@$_GET['action']=='logout'){
//                session_unset();
//            }
            ?>
            </table>
        </div>
    </div>
</div>
</body>
<script src="js/myjs.js" language="JavaScript"></script>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery-2.2.3.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>

</html>
