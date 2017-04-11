<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>search</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row clearfix">
        <div class="col-md-12 column">
            <nav class="navbar navbar-default " role="navigation">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button> <a class="navbar-brand" href="http://localhost/signer/signer.php">Signer</a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="http://localhost/signer/adduser.php">AddUser</a>
                        </li>
                        <li>
                            <a href="http://localhost/signer/search.php">SearchUser</a>
                        </li>
                        <li>
                            <a href="http://localhost/signer/delete.php">DeleteUser</a>
                        </li>
                    </ul>
                    <form class="navbar-form navbar-left" role="search" action="search.php" method="post">
                        <div class="form-group">
                            <input type="text" name="logindate" class="form-control" placeholder="例：20171205"/>
                        </div> <button type="submit" class="btn btn-default">Submit</button>
                    </form>
                    <ul class="nav navbar-nav navbar-right">

                    </ul>
                </div>
            </nav>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-md-12 column">
            <div style="text-align:center;margin:100px 0; font:normal 14px/24px 'MicroSoft YaHei';">
                <table border="1" cellspacing="0" cellpadding="0" id="userList" align="center">
                    <tr align="center">
                        <th>Icon</th>
                        <th>Userid</th>
                        <th>Username</th>
                        <th>Logindate</th>
                    </tr>
                    <?php
                    require_once('config/config.php');
                    mysqli_select_db($conn,'signer');
                    $logindate=@$_POST['logindate'];
                    if($logindate) {
                        $result = mysqli_query($conn, "select * from info where logindate='$logindate'");
                        $userList[] = array();

                        while (@$row = mysqli_fetch_array($result)) {
                            $userList[] = $row;
                        }
                        if (is_array($userList) && !empty($userList)) {
                            $i = 0;
                            foreach ($userList as $user) {
                                if ($i > 0) {
                                    echo "<tr>";
                                    echo "<td><img src='{$user['picurl']}'></td>";
                                    echo "<td>" . $user['userid'] . "</td>";
                                    echo "<td>" . $user['username'] . "</td>";
                                    echo "<td>" . $user['logindate'] . "</td>";
                                    echo "</tr>";
                                }
                                $i++;
                            }
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery-2.2.3.min.js"></script>
</html>
