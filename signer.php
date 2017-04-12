<?php
/**
 * Created by PhpStorm
 * User: kyosin
 * Date: 2017/2/20
 * Time: 16:16
 */
session_start();

require_once('class.signer.php');
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
        </div>
        <div class="col-md-4 column" style="margin-top: 100px">
            <a href="./adduser.php">管理者ページ</a>
            <h5 style="margin-top: 60px">* Turn your sight on camera when you sign in the system </h5>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-md-6 column">
            <form class="form-horizontal" name="form-horizontal" role="form" method="post" action="signer.php" onsubmit="return check()">
                <div class="form-group">
                    <label for="inputUsername3" class="col-sm-2 control-label"><br>UserID</label>
                    <div class="col-sm-5">
<!--                        <br><input type="text" class="form-control" name="inputUserID3" id="inputUserID3" /><br>-->
                        <br><select class="form-control" name="inputUserID3" id="inputUserID3">
                            <?php foreach (Signer::getInstance()->getUsers() as $idx => $user) { ?>
                                <option value="<?= $user['id'] ?>"><?= $user['name'] ?></option>
                            <?php } ?>
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
                    document.write( webcam.get_html(250, 170, 70,50) );
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
            <h3>Logs</h3>
            <table width='1200px' align='center'; style='text-align:center;margin-top:50px;color:black' border='3'>
                <thead>
                    <tr>
                        <th style='text-align:center;'>id</th>
                        <th style='text-align:center;'>user.name</th>
                        <th style='text-align:center;'>datetime</th>
                        <th style='text-align:center;'>type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (Signer::getInstance()->getLogs() as $idx => $log) { ?>
                    <tr>
                        <td><?= $log['id'] ?></td>
                        <td><?= $log['name'] ?></td>
                        <td><?= $log['datetime'] ?></td>
                        <td><?= $log['type'] ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-12 column">
            <?php
            require_once('config/config.php');
            mysqli_select_db($conn,'signer');
            ob_start();

            date_default_timezone_set('Asia/Tokyo');
            $userid = @$_POST['inputUserID3'];

            //检测用户名及密码是否正确
            $result = mysqli_query($conn,"select * from users where userid='$userid'limit 1");
            echo "<table width='1200px' align='center'; style='text-align:center;margin-top:50px;;color:black'border='3'>
                <tr>
                    <th style='text-align:center;'>Icon</th>
                    <th style='text-align:center;'>UserID</th>
                    <th style='text-align:center;'>Username</th>
                    <th style='text-align:center;'>sign in time</th>
                    <th style='text-align:center;'>state</th>
                </tr>";
            while($row = mysqli_fetch_array($result)) {
                if (@$row['userid'] == $userid) {
                    $uid = $row['userid'];
                    $uname = $row['username'];
                    $date = date("Ymd");
                    $url = 'pic/'. date('YmdHis') . '.jpg';
                    $sql = "INSERT INTO info (userid,username,logindate,picurl)VALUES('$uid','$uname','$date','$url')";
                    if($conn->query($sql) === TRUE){
//                        exit();
                    }else{
                        echo "error: ".$sql."<br>".$conn->error;
                    }
                    $filename = 'pic/'. date('YmdHis') . '.jpg';
                    $time = date("Y/m/d H:i:s");
                    if (!isset($_SESSION['savedate'])) {
                        $_SESSION['savedate'] = array();
                        array_push($_SESSION['savedate'], array($row['userid'], $row['username'], $time, $filename));
                    } else {
                        array_push($_SESSION['savedate'], array($row['userid'], $row['username'], $time, $filename));
                    }
                    if (is_array($_SESSION['savedate']) && !empty($_SESSION['savedate'])) {
                        $i = 0;
                        foreach ($_SESSION['savedate'] as $savedate) {
                            if ($i >= 0) {
                                echo "<tr>";
                                echo "<td>" . "<img alt='icon' src='$savedate[3]'" . "</td>";
                                echo "<td>" . $savedate[0] . "</td>";
                                echo "<td>" . $savedate[1] . "</td>";
                                echo "<td>" . $savedate[2] . "</td>";
                                echo "<td>" . "online" . "</td>";
                                echo "</tr>";

                            }
                            $i++;
                        }
                    }
                    echo "</table>";
                } else {
                    echo "error!";
                }
            }
            if(@$_GET['action']=='logout'){
                session_unset();
            }
            ?>
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
